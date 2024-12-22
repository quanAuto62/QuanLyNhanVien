<?php
date_default_timezone_set('Africa/Accra');
include('../includes/config.php');
include('../includes/session.php');

function changePassword($email, $oldPassword, $newPassword) {
    global $conn;

    if (empty($oldPassword) || empty($newPassword)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền đầy đủ các trường');
        echo json_encode($response);
        exit;
    }

    // Check if the email exists and retrieve the current password hash
    $stmt = mysqli_prepare($conn, "SELECT password FROM tblemployees WHERE email_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        $response = array('status' => 'error', 'message' => 'Không tìm thấy email');
        echo json_encode($response);
        exit;
    } else {
        $row = mysqli_fetch_assoc($result);
        $currentPasswordHash = $row['password'];


        if ($oldPassword !== $currentPasswordHash) {
            $response = array('status' => 'error', 'message' => 'Mật khẩu cũ không đúng');
            echo json_encode($response);
            exit;
        }

        
        $hashedNewPassword = $newPassword;

        // Check if the new password is the same as the old password
        if ($hashedNewPassword === $currentPasswordHash) {
            $response = array('status' => 'error', 'message' => 'Mật khẩu mới không được giống mật khẩu cũ');
            echo json_encode($response);
            exit;
        }
        
        // Prepare the query to update the password
        $stmt = mysqli_prepare($conn, "UPDATE tblemployees SET password = ? WHERE email_id = ?");
        mysqli_stmt_bind_param($stmt, "ss", $hashedNewPassword, $email);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $response = array('status' => 'success', 'message' => 'Reset mật khẩu thành công');
            echo json_encode($response);
            exit;
        } else {
            $response = array('status' => 'error', 'message' => 'Reset mật khẩu thất bại');
            echo json_encode($response);
            exit;
        }
    }
}

if ($_POST['action'] === 'change_password') {
    if (isset($_SESSION['semail'])) {
        $email = $_SESSION['semail'];
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $response = changePassword($email, $oldPassword, $newPassword);
        echo $response;
    } else {
        $response = array('status' => 'error', 'message' => 'Người dùng chưa đăng nhập');
        echo json_encode($response);
        exit;
    }
}
?>