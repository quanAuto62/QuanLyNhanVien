<?php
session_start();
include('includes/config.php');
require_once 'alerts.php';

// Start output buffering
ob_start();

function login($email, $password) {
    global $conn;

    // Truy vấn bảng tblemployee
    $dangnhap = mysqli_query($conn, "SELECT * FROM tblemployees WHERE email_id='$email' AND password='$password'");
    if (!$dangnhap) {
        error_log("MySQL error: " . mysqli_error($conn));
        return array('status' => 'error', 'message' => "Error: " . mysqli_error($conn));
    } else {
        $staffCount = mysqli_num_rows($dangnhap);
        if ($staffCount > 0) {
            $recordsRow = mysqli_fetch_assoc($dangnhap);
            return checkAndSetSession($recordsRow);
        } else {
            return array('status' => 'error', 'message' => 'Sai thông tin đăng nhập');
        }
    }
}

function checkAndSetSession($userRecord) {
    if ($userRecord['lock_unlock'] == "true") {
        return array('status' => 'error', 'message' => 'Tài khoản của bạn đã bị khóa. Vui lòng mở khóa bằng email của bạn hoặc liên hệ với quản trị viên để được hỗ trợ.');
    }

    // Set session variables and redirect based on user type
    $_SESSION['slogin'] = $userRecord['emp_id'];
    $_SESSION['srole'] = $userRecord['role'];
    $_SESSION['semail'] = $userRecord['email_id'];
    $_SESSION['sstaff_id'] = $userRecord['staff_id'];
    $_SESSION['sfirstname'] = $userRecord['first_name'];
    $_SESSION['slastname'] = $userRecord['last_name'];
    $_SESSION['smiddlename'] = $userRecord['middle_name'];
    $_SESSION['scontact'] = $userRecord['phone_number'];
    $_SESSION['sdesignation'] = $userRecord['designation'];
    $_SESSION['is_supervisor'] = $userRecord['is_supervisor'];
    $_SESSION['simageurl'] = $userRecord['image_path'];
    $_SESSION['last_activity'] = time(); // Set the last activity time

    $passwordReset = $userRecord['password_reset'];

    if ($userRecord['role'] == 'Admin') {
        $_SESSION['department'] = $userRecord['department'];
        $userType = 'admin';
    } elseif ($userRecord['role'] == 'Manager') {
        $_SESSION['department'] = $userRecord['department'];
        $userType = 'manager';
    } elseif ($userRecord['role'] == 'Staff') {
        $_SESSION['department'] = $userRecord['department'];
        $userType = 'staff';
    } else {
        return array('status' => 'error', 'message' => 'Sai người dùng');
    }

    $message = '';
    if ($userRecord['role'] == 'Admin') {
        $message = 'Admin đăng nhập thành công';
    } elseif ($userRecord['role'] == 'Manager') {
        $message = 'Manager đăng nhập thành công';
    } elseif ($userRecord['role'] == 'Staff') {
        $message = 'Nhân viên đăng nhập thành công';
    }
    return array(
    'status' => 'success',
    'message' => $message,
    'role' => $userType,
    'password_reset' => $passwordReset
    );

}

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'save') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $loginResponse = login($email, $password);

            // Clean (erase) the output buffer before sending the JSON response
            ob_end_clean();

            header('Content-Type: application/json'); // Set the content type to JSON
            echo json_encode($loginResponse);
        } catch (Exception $e) {
            ob_end_clean();
            error_log("Exception: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Lỗi máy chủ nội bộ', 'error' => $e->getMessage()));
        }
        exit;
    }
}
?>
