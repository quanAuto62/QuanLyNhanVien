<?php include('../includes/header.php') ?>
<?php
// Check if the user is logged in
if (!isset($_SESSION['slogin']) || !isset($_SESSION['srole'])) {
    header('Location: ../index1.php');
    exit();
}

// Check if the user has the role of Manager or Admin
$userRole = $_SESSION['srole'];
if ($userRole !== 'Manager' && $userRole !== 'Admin') {
    header('Location: ../index1.php');
    exit();
}
?>


<body>
    <!-- Pre-loader start -->
    <?php include('../includes/loader.php') ?>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <?php include('../includes/topbar.php') ?>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <?php $page_name = "new_staff"; ?>
                    <?php include('../includes/sidebar.php') ?>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-header start -->
                                    <div class="page-header">
                                        <div class="row align-items-end">
                                            <div class="col-lg-8">
                                                <div class="page-header-title">
                                                    <div class="d-inline">
                                                        <h4>Thêm Nhân Viên</h4>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Page-header end -->

                                    <!-- Page body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- Basic Inputs Validation start -->
                                                <?php
                                                // Kiểm tra xem tham số chỉnh sửa đã được đặt chưa và tìm nạp bản ghi từ cơ sở dữ liệu
                                                if (isset($_GET['edit']) && $_GET['edit'] == 1 && isset($_GET['id'])) {
                                                    $id = $_GET['id'];
                                                    $stmt = mysqli_prepare($conn, "SELECT * FROM tblemployees WHERE emp_id = ?");
                                                    mysqli_stmt_bind_param($stmt, "i", $id);
                                                    mysqli_stmt_execute($stmt);
                                                    $result = mysqli_stmt_get_result($stmt);
                                                    $row = mysqli_fetch_assoc($result);
                                                }
                                                ?>
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row">
                                                            <div class="col-sm-6 mobile-inputs">
                                                                <h4 class="sub-title">Thông Tin Chi Tiết</h4>
                                                                <input type="hidden" id="edit_id" name="edit_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 'null'; ?>">
                                                                <form enctype="multipart/form-data">
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label for="userName-2" class="block">Thông Tin Cá Nhân *</label>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <input type="file" id="image_path" name="image_path" class="form-control">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label for="userName-2" class="block">Họ *</label>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" id="firstname" name="firstname" autocomplete="off" class="form-control" placeholder="" value="<?php echo isset($row['first_name']) ? $row['first_name'] : ''; ?>">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label for="userName-2" class="block">Tên đệm</label>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" id="middlename" name="middlename" autocomplete="off" class="form-control" placeholder="" value="<?php echo isset($row['middle_name']) ? $row['middle_name'] : ''; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label for="userName-2" class="block">Tên *</label>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" id="lastname" name="lastname" autocomplete="off" class="form-control" placeholder="" value="<?php echo isset($row['last_name']) ? $row['last_name'] : ''; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label for="userName-2" class="block">Số Điện Thoại *</label>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <input type="tel" id="contact" name="contact" autocomplete="off" class="form-control" placeholder="" value="<?php echo isset($row['phone_number']) ? $row['phone_number'] : ''; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label for="userName-2" class="block">Công việc *</label>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" id="designation" name="designation" autocomplete="off" class="form-control" placeholder="" value="<?php echo isset($row['designation']) ? $row['designation'] : ''; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <h4 class="sub-title">Giới Tính *</h4>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-radio">
                                                                                <div class="radio radiofill radio-inline">
                                                                                    <label>
                                                                                        <input type="radio" name="gender" value="Nữ" <?php echo (isset($row['gender']) && $row['gender'] === 'Nữ') ? 'checked="checked"' : ''; ?>>
                                                                                        <i class="helper"></i>Nữ
                                                                                    </label>
                                                                                </div>
                                                                                <div class="radio radiofill radio-inline">
                                                                                    <label>
                                                                                        <input type="radio" name="gender" value="Nam" <?php echo (isset($row['gender']) && $row['gender'] === 'Nam') ? 'checked="checked"' : ''; ?>>
                                                                                        <i class="helper"></i>Nam
                                                                                    </label>
                                                                                </div>
                                                                                <div class="radio radiofill radio-inline">
                                                                                    <label>
                                                                                        <input type="radio" name="gender" value="Khác" <?php echo (isset($row['gender']) && $row['gender'] === 'Khác') ? 'checked="checked"' : ''; ?>>
                                                                                        <i class="helper"></i>Khác
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-sm-6 mobile-inputs">
                                                                <h4 class="sub-title">Thông Tin Công Ty</h4>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <label for="userName-2" class="block">Phòng Ban *</label>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <select class="js-example-disabled-results col-sm-12" name="department" id="department" required>
                                                                            <?php
                                                                            // Check if we are coming from an edit page and $selected_department_id is not empty
                                                                            if (!empty($row['department'])) {
                                                                                // Query the database to get the department details
                                                                                $stmt = mysqli_prepare($conn, "SELECT id, department_name FROM tbldepartments WHERE id = ?");
                                                                                mysqli_stmt_bind_param($stmt, "i", $row['department']);
                                                                                mysqli_stmt_execute($stmt);
                                                                                mysqli_stmt_bind_result($stmt, $id, $name);
                                                                                mysqli_stmt_fetch($stmt);
                                                                                mysqli_stmt_close($stmt);
                                                                                // Output the selected option
                                                                                echo '<option value="' . $id . '" selected>' . $name . '</option>';
                                                                                // Output the rest of the options
                                                                                $stmt = mysqli_prepare($conn, "SELECT id, department_name, department_desc FROM tbldepartments");
                                                                                mysqli_stmt_execute($stmt);
                                                                                mysqli_stmt_store_result($stmt);
                                                                                mysqli_stmt_bind_result($stmt, $id, $name, $description);
                                                                                while (mysqli_stmt_fetch($stmt)) {
                                                                                    echo '<option value="' . $id . '">' . $name . '</option>';
                                                                                }
                                                                                mysqli_stmt_close($stmt);
                                                                            } else {
                                                                                // Output the first option as "Select department" and disabled
                                                                                echo '<option value="" disabled selected>Lựa Chọn Phòng Ban</option>';
                                                                                // Output the rest of the options
                                                                                $stmt = mysqli_prepare($conn, "SELECT id, department_name, department_desc FROM tbldepartments");
                                                                                mysqli_stmt_execute($stmt);
                                                                                mysqli_stmt_store_result($stmt);
                                                                                mysqli_stmt_bind_result($stmt, $id, $name, $description);
                                                                                while (mysqli_stmt_fetch($stmt)) {
                                                                                    echo '<option value="' . $id . '">' . $name . '</option>';
                                                                                }
                                                                                mysqli_stmt_close($stmt);
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <label for="userName-2" class="block">ID Nhân Viên *</label>
                                                                    </div>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" id="staff_id" name="staff_id" readonly autocomplete="off" class="form-control" placeholder="" value="<?php echo isset($row['staff_id']) ? $row['staff_id'] : ''; ?>">
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <i id="generate" class="fa fa-cog btn btn-primary" style="cursor: pointer; padding: 10px; border-radius: 5px;" aria-hidden="true" title="Generate ID"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <label for="userName-2" class="block">Email *</label>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input type="email" id="email" name="email" autocomplete="off" class="form-control" placeholder="" value="<?php echo isset($row['email_id']) ? $row['email_id'] : ''; ?>">
                                                                    </div>
                                                                </div>
                                                                <?php if (!isset($row) || empty($row)): ?>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label for="userName-2" class="block">Mật Khẩu *</label>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <input type="password" placeholder="**********" id="password" name="password" autocomplete="off" class="form-control">
                                                                            <?php if (isset($row) && !empty($row)): ?>
                                                                                <label for="userName" class="block" style="font-style: italic; font-size: 12px;">Leave this blank if you don't want to change password</label>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label for="userName-2" class="block">Xác Nhận Mật Khẩu*</label>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <input type="password" placeholder="**********" id="c_password" name="c_password" autocomplete="off" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <h4 class="sub-title">Là Người Giám Sát? *</h4>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-radio">
                                                                            <div class="radio radiofill radio-inline">
                                                                                <label>
                                                                                    <input type="radio" name="is_supervisor" value="1" <?php echo (isset($row['is_supervisor']) && $row['is_supervisor'] == 1) ? 'checked="checked"' : ''; ?>>
                                                                                    <i class="helper"></i>Có
                                                                                </label>
                                                                            </div>
                                                                            <div class="radio radiofill radio-inline">
                                                                                <label>
                                                                                    <input type="radio" name="is_supervisor" value="0" <?php echo (isset($row['is_supervisor']) && $row['is_supervisor'] == 0) ? 'checked="checked"' : ''; ?>>
                                                                                    <i class="helper"></i>Không
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <h4 class="sub-title">Vai trò</h4>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-radio">
                                                                            <div class="radio radiofill radio-inline">
                                                                                <label>
                                                                                    <input type="radio" name="role" value="Staff" <?php echo (isset($row['role']) && $row['role'] === 'Staff') ? 'checked="checked"' : ''; ?>>
                                                                                    <i class="helper"></i>Nhân Viên
                                                                                </label>
                                                                            </div>
                                                                            <?php if ($session_role == 'Admin'): ?>
                                                                                <div class="radio radiofill radio-inline">
                                                                                <label>
                                                                                    <input type="radio" name="role" value="Manager" <?php echo (isset($row['role']) && $row['role'] === 'Manager') ? 'checked="checked"' : ''; ?>>
                                                                                    <i class="helper"></i>Quản lý
                                                                                </label>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label class="col-sm-5"></label>
                                                        <div class="row">
                                                            <label class="col-sm-5"></label>
                                                            <div class="col-sm-5">
                                                                <?php if (isset($row) && !empty($row)): ?>
                                                                    <button id="staff-update" type="submit" class="btn btn-primary m-b-0">Cập Nhật</button>
                                                                <?php else: ?>
                                                                    <button id="staff-add" type="submit" class="btn btn-primary m-b-0">Thêm Nhân Viên</button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Basic Inputs Validation end -->

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page body end -->
                                </div>
                            </div>
                            <!-- Main-body end -->
                            <div id="styleSelector">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Jquery -->
    <?php include('../includes/scripts.php') ?>
    <!-- <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script> -->
    <script>
        $(document).ready(function() {
            $('#staff-update').click(function(event) {
                event.preventDefault(); // Điều này ngăn không cho form gửi yêu cầu lên server ngay lập tức, tạo cơ hội để kiểm tra quyền trước.
                (async () => {
                    var editId = $('#edit_id').val();
                    var userRole = "<?php echo $userRole;?>";
                    console.log(userRole)
                    if (editId == 10 && userRole != "ADMIN") {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Không có quyền chỉnh sửa ADMIN',
                            confirmButtonColor: '#ffc107',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    if ((editId == 1 || editId == 5 || editId == 7 || editId == 9 || editId == 14)   && userRole == "Manager") {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Không có quyền chỉnh sửa Manager',
                            confirmButtonColor: '#ffc107',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    var requiredFields = ['firstname', 'lastname', 'contact', 'designation', 'department', 'email', 'staff_id'];
                    var formData = new FormData();
                    var isValid = true;

                    for (var i = 0; i < requiredFields.length; i++) {
                        var field = requiredFields[i];
                        var value = $('#' + field).val();
                        // console.log(value);
                        
                        if (value.trim() === '') {
                            Swal.fire({
                                icon: 'warning',
                                text: 'Hãy điền các trường bắt buộc',
                                confirmButtonColor: '#ffc107',
                                confirmButtonText: 'OK'
                            });
                            isValid = false;
                            break; //
                        }

                        // append dữ liệu vào formdata
                        formData.append(field, value);
                    }

                    if (!isValid) {
                        return; // 
                    }

                    // Kiểm tra giới tính
                    var selectedGender = $('input[name="gender"]:checked').val();
                    if (!selectedGender) {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Hãy lựa chọn giới tính',
                            confirmButtonColor: '#ffc107',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    formData.append('gender', selectedGender);

                    // Kiểm tra người giám sát
                    var selectedIsSupervisor = $('input[name="is_supervisor"]:checked').val();
                    if (!selectedIsSupervisor) {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Kiểm tra người giám sát',
                            confirmButtonColor: '#ffc107',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    formData.append('is_supervisor', selectedIsSupervisor);

                    // Kiểm tra chức vụ
                    var selectedRole = $('input[name="role"]:checked').val();
                    if (!selectedRole) {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Lựa chọn chức vụ',
                            confirmButtonColor: '#ffc107',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    formData.append('role', selectedRole);

                    // 
                    var imageFile = $('#image_path')[0].files[0];

                    // Check if password and c_password match
                    var password = $('#password').val();
                    var cPassword = $('#c_password').val();
                    if (password !== cPassword) {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Mật khẩu không khớp',
                            confirmButtonColor: '#ffc107',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    formData.append('edit_id', editId);
                    formData.append('middlename', $('#middlename').val());
                    formData.append('password', password);
                    formData.append('image_path', imageFile);
                    formData.append('action', 'updateStaff');

                    console.log('Dữ liệu: ' + JSON.stringify(formData));

                    console.log('Dữ liệu được gửi đi:', formData);
                    $.ajax({
                        url: 'staff_functions.php',
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log('Raw Response:', response);
                            response = JSON.parse(response);
                            console.log('RESPONSE HERE: ' + response.status)
                            console.log(`RESPONSE HERE: ${response.message}`);
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    html: response.message,
                                    confirmButtonColor: '#01a9ac',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "staff_list.php";
                                        // location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    text: response.message,
                                    confirmButtonColor: '#eb3422',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log('AJAX Data HERE: ' + JSON.stringify(formData));
                            console.log("Response from server: " + jqXHR.responseText);
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                })()
            })
        });
    </script>
    <script>
        $('#staff-add').click(function(event) {
            event.preventDefault(); // prevent the default form submission
            (async () => {
                // Validate required fields
                var requiredFields = ['firstname', 'lastname', 'contact', 'designation', 'department', 'email', 'staff_id'];
                var formData = new FormData();
                var isValid = true;

                for (var i = 0; i < requiredFields.length; i++) {
                    var field = requiredFields[i];
                    var value = $('#' + field).val();
                    // console.log(value)
                    // Check if the field is empty
                    if (value.trim() === '') {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Hãy điền các trường bắt buộc',
                            confirmButtonColor: '#ffc107',
                            confirmButtonText: 'OK'
                        });
                        isValid = false;
                        break; // Stop further validation
                    }

                    // Append the field to the form data
                    formData.append(field, value);
                }
                for (var pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }

                if (!isValid) {
                    return; // Don't proceed if there are empty fields
                }

                // Check if password is empty
                var password = $('#password').val();
                var cPassword = $('#c_password').val();
                if (password === '') {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Không thể để trống mật khẩu',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Check if password and c_password match
                if (password !== cPassword) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Mật khẩu không khớp',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Append the password to the form data
                formData.append('password', password);

                // Validate gender
                var selectedGender = $('input[name="gender"]:checked').val();
                if (!selectedGender) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Hãy chọn giới tính',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                formData.append('gender', selectedGender);

                // Validate supervisor
                var selectedIsSupervisor = $('input[name="is_supervisor"]:checked').val();
                if (!selectedIsSupervisor) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Hãy chọn người giám sát',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                formData.append('is_supervisor', selectedIsSupervisor);

                // Validate role
                var selectedRole = $('input[name="role"]:checked').val();
                if (!selectedRole) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Hãy chọn chức vụ',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                formData.append('role', selectedRole);

                // Handle the image field separately
                var imageFile = $('#image_path')[0].files[0];
                if (!imageFile) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Hãy chọn hình ảnh',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                formData.append('middlename', $('#middlename').val());
                formData.append('image_path', imageFile);
                formData.append('action', 'staff-add');

                console.log('Data HERE: ' + JSON.stringify(formData));
                $.ajax({
                    url: 'staff_functions.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('success function called');
                        response = JSON.parse(response);
                        console.log('RESPONSE HERE: ' + response.status)
                        console.log(`RESPONSE HERE: ${response.message}`);
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                html: response.message,
                                confirmButtonColor: '#01a9ac',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: response.message,
                                confirmButtonColor: '#eb3422',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('AJAX Data HERE: ' + JSON.stringify(formData));
                        console.log("Response from server: " + jqXHR.responseText);
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            })()
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#generate').on('click', function() {
                $.ajax({
                    url: 'generate_id.php',
                    type: 'GET',
                    success: function(response) {
                        $('#staff_id').val(response);
                    },
                    error: function() {
                        alert('Không thể tạo ID, vui lòng thử lại');
                    }
                });
            });
        });
    </script>
</body>

</html>