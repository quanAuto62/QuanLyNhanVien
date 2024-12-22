<?php
include('includes/config.php');
include('includes/session.php');

if (!isset($_SESSION['semail'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset_password') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $email = $_SESSION['semail'];

    if (empty($newPassword) || empty($confirmPassword)) {
        $response = array('status' => 'error', 'message' => 'Hãy điền vào đầy đủ các trường');
        echo json_encode($response);
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        $response = array('status' => 'error', 'message' => 'Mật khẩu không khớp');
        echo json_encode($response);
        exit();
    }

    // Update the password and set password_reset to true
    $stmt = mysqli_prepare($conn, "UPDATE tblemployees SET password = ?, password_reset = 1 WHERE email_id = ?");
    mysqli_stmt_bind_param($stmt, "ss", $newPassword, $email);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Automatically log the user in after password reset
        $_SESSION['password_reset'] = true; // Set password_reset session variable
        $response = array('status' => 'success', 'message' => 'Tạo mật khẩu thành công', 'role' => $_SESSION['srole']);
    } else {
        $response = array('status' => 'error', 'message' => 'Tạo mật khẩu thất bại');
    }

    echo json_encode($response);
    exit();
}
?>
