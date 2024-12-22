<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
include('../includes/config.php');

function resizeImage($sourcePath, $destinationPath, $width, $height) {
     if (!function_exists('imagecreatefromjpeg') || !function_exists('imagejpeg')) {
        throw new Exception('GD library is not available');
    }
    
    list($originalWidth, $originalHeight) = getimagesize($sourcePath);
    $src = imagecreatefromjpeg($sourcePath);
    $dst = imagecreatetruecolor($width, $height);
    
    // Resize
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
    
    // Save the resized image
    imagejpeg($dst, $destinationPath);
    
    // Free memory
    imagedestroy($src);
    imagedestroy($dst);
}

function updateStaffRecords($edit_id, $firstname, $lastname, $middlename, $contact, $designation, $department, $email, $gender, $is_supervisor, $role, $staff_id, $image_path) {
    global $conn;

    if (empty($department) || empty($firstname) || empty($lastname) || empty($contact) || empty($designation) || empty($email)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền đầy đủ các trường');
        echo json_encode($response);
        exit;
    }

    // Check if the image file is provided
    if ($image_path !== null && isset($image_path['name']) && !empty($image_path['name'])) {
        // Upload the image
        $image_upload_dir = '../uploads/images/';
        $image_name = $staff_id . '_' . basename($image_path['name']);
        $image_target_path = $image_upload_dir . $image_name;

        if (!move_uploaded_file($image_path['tmp_name'], $image_target_path)) {
            $response = array('status' => 'error', 'message' => 'Không thể tải hình ảnh len');
            echo json_encode($response);
            exit;
        }

         // Resize the image to 230x230
        resizeImage($image_target_path, $image_target_path, 230, 230);

        // If a new image is provided, remove the old image from the storage folder
        $old_image_path = ''; // Get the old image path from the database
        $stmt = mysqli_prepare($conn, "SELECT image_path FROM tblemployees WHERE emp_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $edit_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $old_image_path);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!empty($old_image_path) && file_exists($old_image_path)) {
            unlink($old_image_path); // Delete the old image
        }

    } else {
        $image_target_path = ''; // Empty image path
    }

    // Xây dựng truy vấn SQL dựa trên sự hiện diện của hình ảnh và mật khẩu
    if (empty($image_target_path)) {
        // Trống hình ảnh
        $stmt = mysqli_prepare($conn, "UPDATE tblemployees SET department=?, first_name=?, last_name=?, middle_name=?, phone_number=?, designation=?, email_id=?, gender=?, role=?, staff_id=?, is_supervisor=? WHERE emp_id=?");
        mysqli_stmt_bind_param($stmt, 'isssssssssii', $department, $firstname, $lastname, $middlename, $contact, $designation, $email, $gender, $role, $staff_id, $is_supervisor, $edit_id);
    } else {
        // Có hình ảnh
        $stmt = mysqli_prepare($conn, "UPDATE tblemployees SET department=?, first_name=?, last_name=?, middle_name=?, phone_number=?, designation=?, email_id=?, password=?, gender=?, role=?, image_path=?, staff_id=?, is_supervisor=? WHERE emp_id=?");
        mysqli_stmt_bind_param($stmt, 'isssssssssssii', $department, $firstname, $lastname, $middlename, $contact, $designation, $email, $password_param, $gender, $role, $image_target_path, $staff_id, $is_supervisor, $edit_id);
    }

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Cập nhật thành công.');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Cập nhật thất bại.');
        echo json_encode($response);
        exit;
    }
}

function addStaffRecord($firstname, $lastname, $middlename, $contact, $designation, $department, $email, $password, $role, $is_supervisor, $staff_id, $gender, $image_path) {
    global $conn;

    if (empty($department) || empty($firstname) || empty($lastname) || empty($contact) ||
        empty($designation) || empty($email) || empty($password) || empty($role) || empty($image_path)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền đầy đủ các trường');
        echo json_encode($response);
        exit;
    }

    // Check if the record already exists
    $stmt = mysqli_prepare($conn, "SELECT emp_id FROM tblemployees WHERE email_id=?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($num_rows > 0) {
        $response = array('status' => 'error', 'message' => 'Trùng email');
        echo json_encode($response);
        exit;
    }

    // Upload the image
    $image_upload_dir = '../uploads/images/';
    $image_name = $staff_id . '_' . basename($image_path['name']);
    $image_target_path = $image_upload_dir . $image_name;

    if (!move_uploaded_file($image_path['tmp_name'], $image_target_path)) {
        $response = array('status' => 'error', 'message' => 'Không thể tải ảnh lên');
        echo json_encode($response);
        exit;
    }

     // Resize the image to 230x230
    resizeImage($image_target_path, $image_target_path, 230, 230);

    // Insert the record into the database
    $password_param = $password;
    $stmt = mysqli_prepare($conn, "INSERT INTO tblemployees (department, first_name, last_name, middle_name, phone_number, designation, email_id, password, gender, image_path, role, staff_id, is_supervisor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'isssssssssssi', $department, $firstname, $lastname, $middlename, $contact, $designation, $email, $password_param, $gender, $image_target_path, $role, $staff_id, $is_supervisor);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Thêm thành viên thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Thêm thành viên thất bại');
        echo json_encode($response);
        exit;
    }
}

function deleteStaff($id) {
    global $conn;

    // Get the old image path before deleting the staff member
    $old_image_path = ''; // Initialize the old image path
    $stmt = mysqli_prepare($conn, "SELECT image_path FROM tblemployees WHERE emp_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $old_image_path);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Delete the staff member
    $stmt = mysqli_prepare($conn, "DELETE FROM tblemployees WHERE emp_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // If the staff member is deleted successfully, check and delete the associated image
        if (!empty($old_image_path) && file_exists($old_image_path)) {
            unlink($old_image_path); // Delete the old image
        }

        $response = array('status' => 'success', 'message' => 'Xóa thành viên thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Xóa thành viên thất bại');
        echo json_encode($response);
        exit;
    }
}


function assignSupervisor($employeeId, $supervisorId) {
    global $conn;

    // Check for empty inputs
    if (empty($employeeId) || empty($supervisorId)) {
        $response = array('status' => 'error', 'message' => 'Vui lòng cung cấp cả ID nhân viên và ID người giám sát');
        return json_encode($response);
    }

    // Prepare the update statement
    $stmt = mysqli_prepare($conn, "UPDATE tblemployees SET supervisor_id = ? WHERE emp_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $supervisorId, $employeeId);
    $result = mysqli_stmt_execute($stmt);

    // Check the result and return appropriate response
    if ($result) {
        $response = array('status' => 'success', 'message' => 'Chỉ định người giám sát thành công');
    } else {
        $response = array('status' => 'error', 'message' => 'Chỉ định người giám sát thất bại');
    }

    return json_encode($response);
}

if(isset($_POST['action'])) {
    // Determine which action to perform
    if ($_POST['action'] === 'updateStaff') {
        $edit_id = $_POST['edit_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $middlename = $_POST['middlename'];
        $contact = $_POST['contact'];
        $designation = $_POST['designation'];
        $department = $_POST['department'];
        $email = $_POST['email'];
        // $password = $_POST['password'];
        $gender = $_POST['gender'];
        $role = $_POST['role'];
        $is_supervisor = $_POST['is_supervisor'];
        $staff_id = $_POST['staff_id'];
        if(isset($_FILES['image_path'])) {
            $image_path = $_FILES['image_path'];
        } else {
            $image_path = ''; // or set it to some default value as needed
        }
        $response = updateStaffRecords($edit_id, $firstname, $lastname, $middlename, $contact, $designation, $department, $email, $gender, $is_supervisor, $role, $staff_id, $image_path);
        echo $response;

    } elseif ($_POST['action'] === 'staff-add') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $middlename = $_POST['middlename'];
        $contact = $_POST['contact'];
        $designation = $_POST['designation'];
        $department = $_POST['department'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $staff_id = $_POST['staff_id'];
        $role = $_POST['role'];
        $is_supervisor = $_POST['is_supervisor'];
        $image_path = $_FILES['image_path'];
        $response = addStaffRecord($firstname, $lastname, $middlename, $contact, $designation, $department, $email, $password, $role, $is_supervisor, $staff_id, $gender, $image_path);
        echo $response;

    } elseif ($_POST['action'] === 'delete-staff') {
        $id = $_POST['id'];
        $response = deleteStaff($id);
        echo $response;
    } elseif ($_POST['action'] === 'assign-supervisor') {
        $employeeId = $_POST['employeeId'];
        $supervisorId = $_POST['supervisorId'];
        $response = assignSupervisor($employeeId, $supervisorId);
        echo $response;
        exit;
    }
}

?>

<?php
// Retrieve the search query and department filter from the AJAX request
$searchQuery = $_POST['searchQuery'];
$departmentFilter = $_POST['departmentFilter'];

$userRole = $_SESSION['srole'];
$userId = $_SESSION['slogin'];
$userDepartment = $_SESSION['department'];
$isSupervisor = $_SESSION['is_supervisor'];

// Generate the SQL query based on the search query and department filter
$sql = "SELECT e.*, d.department_name 
        FROM tblemployees e 
        LEFT JOIN tbldepartments d ON e.department = d.id";

if ($departmentFilter !== '') {
    $sql .= " WHERE d.department_name = '$departmentFilter'";
}
if ($searchQuery !== '') {
    $sql .= ($departmentFilter === '') ? " WHERE" : " AND";
    $sql .= " (e.first_name LIKE '%$searchQuery%' OR e.last_name LIKE '%$searchQuery%' OR e.designation LIKE '%$searchQuery%')";
}

// Execute the SQL query and fetch the staff data
$employeeData = []; // Array to store the fetched staff data
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $employeeData[] = $row;
    }
}

// Generate and return the HTML markup for the staff cards
if (empty($employeeData)) {
    echo '<div class="col-lg-12 text-center">
            <img src="../files/assets/images/no_data.png" class="img-radius" alt="No Data Found" style="width: 200px; height: auto;">
          </div>';
} else {
    foreach ($employeeData as $employee) {
        $imagePath = empty($employee['image_path']) ? '../files/assets/images/user-card/img-round1.jpg' : $employee['image_path'];
        echo '<div class="col-lg-6 col-xl-3 col-md-6">
                <div class="card rounded-card user-card">
                    <div class="card-block">
                        <div class="img-hover">
                            <img class="img-fluid img-radius" src="' . $imagePath . '" alt="round-img">
                            <div class="img-overlay img-radius">
                                <span>
                                    <a href="staff_detailed.php?id=' . $employee['emp_id'] . '&view=2" class="btn btn-sm btn-primary" style="margin-top: 1px;" data-popup="lightbox"><i class="icofont icofont-eye-alt"></i></a>';
                                     // Check if the user role is Admin or Manager and the employee's designation is not 'Administrator'
                                    if ($userRole === 'Admin' || ($userRole === 'Manager' && $employee['designation'] !== 'Administrator')) {
                                        echo '<a href="new_staff.php?id=' . $employee['emp_id'] . '&edit=1" class="btn btn-sm btn-primary" data-popup="lightbox" style="margin-left: 8px; margin-top: 1px;"><i class="icofont icofont-edit"></i></a>';
                                        
                                        // Only show the delete icon if the employee's designation is not 'Administrator'
                                        if ($employee['designation'] !== 'Administrator') {
                                            echo '<a href="#" class="btn btn-sm btn-primary delete-staff" style="margin-top: 1px;" data-id="' . $employee['emp_id'] . '"><i class="icofont icofont-ui-delete"></i></a>';
                                        }
                                    }

                                echo '</span>
                            </div>
                        </div>
                        <div class="user-content">
                            <h4 class="">' . $employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name'] . '</h4>
                            <p class="m-b-0 text-muted">' . $employee['designation'] . '</p>
                        </div>
                    </div>
                </div>
            </div>';
    }
}
?>
<!-- staff_detailed.php -->