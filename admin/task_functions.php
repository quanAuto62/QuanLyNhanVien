<?php
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ Việt Nam
include('../includes/config.php');
include('../includes/session.php');

function updateCustomerRecords($id, $firstname, $lastname, $middlename, $contact, $address, $email, $password) {
    global $conn;

    if (empty($firstname) || empty($lastname) || empty($contact) || empty($address) || empty($email)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền đẩy đủ các trường');
        echo json_encode($response);
        exit;
    }

    if(empty($password)) {
        $stmt = mysqli_prepare($conn, "UPDATE customers SET firstname=?, lastname=?, middlename=?, contact=?, address=?, email=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssssssi', $firstname, $lastname, $middlename, $contact, $address, $email, $id);
    }
    else {
        $password_param = $password;
        $stmt = mysqli_prepare($conn, "UPDATE customers SET firstname=?, lastname=?, middlename=?, contact=?, address=?, email=?, password=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssssssi', $firstname, $lastname, $middlename, $contact, $address, $email, $password_param, $id);
    }
    
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Cập nhật thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Cập nhật thất bại');
        echo json_encode($response);
        exit;
    }
}

function addTaskRecord($title, $description, $assigned_to, $assigned_by, $priority, $start_date, $due_date, $status) {
    global $conn;

    if (empty($title) || empty($description) || empty($assigned_to) || empty($assigned_by) || empty($priority) || empty($start_date) || empty($due_date)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền đầy đủ các trường');
        echo json_encode($response);
        exit;
    }

    // Insert task record
    $stmt = mysqli_prepare($conn, "INSERT INTO tbltask (title, description, assigned_to, assigned_by, priority, start_date, due_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssiissss', $title, $description, $assigned_to, $assigned_by, $priority, $start_date, $due_date, $status);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Thêm nhiệm vụ thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Thêm nhiệm vụ thất bại');
        echo json_encode($response);
        exit;
    }
}

function updatePriority($id, $priority) {
    global $conn;

    if (empty($id) || empty($priority)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền đầy đủ các trường');
        echo json_encode($response);
        exit;
    }

    // Update the priority value in the tickets table
    $stmt = mysqli_prepare($conn, "UPDATE tbltask SET priority = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $priority, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Cập nhật cấp độ thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Cập nhật thất bại');
        echo json_encode($response);
        exit;
    }
}

function updateStatus($id, $status) {
    global $conn;

    if (empty($id)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền đẩy đủ các trường');
        echo json_encode($response);
        exit;
    }

    // Update the status value in the task table
    $stmt = mysqli_prepare($conn, "UPDATE tbltask SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Cập nhật thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Cập nhật thất bại');
        echo json_encode($response);
        exit;
    }
}

  // Delete the task table
function deleteTask($id) {
    global $conn;

    $stmt = mysqli_prepare($conn, "DELETE FROM tbltask WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Xóa thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Xóa thất bại');
        echo json_encode($response);
        exit;
    }
}

function updateTaskRecord($id, $title, $description, $assigned_to, $priority, $start_date, $due_date) {
    global $conn;

    if (empty($title) || empty($description) || empty($assigned_to) || empty($priority) || empty($start_date) || empty($due_date)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền đẩy đủ các trường');
        echo json_encode($response);
        exit;
    }

    $stmt = mysqli_prepare($conn, "UPDATE tbltask SET title=?, description=?, assigned_to=?, priority=?, start_date=?, due_date=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'ssisssi', $title, $description, $assigned_to, $priority, $start_date, $due_date, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Cập nhật thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Cập nhật thất bại');
        echo json_encode($response);
        exit;
    }
}





if(isset($_POST['action'])) {
    // Determine which action to perform
    $query = "CALL CalculateScoreByTask(?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($_POST['action'] === 'tasks-add') {

        $title = $_POST['title'];
        $description = $_POST['description'];
        $assigned_to = intval($_POST['assigned_to']);
        $assigned_by = intval($_SESSION['slogin']);
        $priority = $_POST['priority'];
        $start_date = $_POST['start_date'];
        $due_date = $_POST['due_date'];
        // $status = $_POST['status'];

        $response = addTaskRecord($title, $description, $assigned_to, $assigned_by, $priority, $start_date, $due_date, "Pending");
        echo $response;

    } else if ($_POST['action'] === 'update-task-priority') {
        $id = $_POST['id'];
        $priority = $_POST['priority'];
        $response = updatePriority($id, $priority);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        
        echo $response;

    } else if ($_POST['action'] === 'update-task-status') {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $response = updateStatus($id, $status);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        echo $response;

    } else if ($_POST['action'] === 'remove-task') {
        $id = $_POST['id'];
        $response = deleteTask($id);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        echo $response;
        
    } else if ( $_POST['action'] === 'tasks-update') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $assigned_to = intval($_POST['assigned_to']);
        $priority = $_POST['priority'];
        $start_date = $_POST['start_date'];
        $due_date = $_POST['due_date'];
        $response = updateTaskRecord($id, $title, $description, $assigned_to, $priority, $start_date, $due_date);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        echo $response;
    }
}
?>