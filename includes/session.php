<?php
session_start();

// Kiểm tra sự tồn tại của biến session SESS_MEMBER_ID 
if (!isset($_SESSION['slogin']) || (trim($_SESSION['slogin']) == '')) {
    // Chuyển hướng về trang login
    header("Location: ../index1.php");
    exit;
}

// Kiểm tra xem phiên hết hạn chưa
$lastActivity = $_SESSION['last_activity'];
$sessionExpiration = 60 * 30; // Session sẽ kết thúc sau 30 phút người dùng không hoạt động

if (time() - $lastActivity > $sessionExpiration) {
    // Nếu session hết hạn, xóa session đó và chuyển hướng về trang login
    session_unset();
    session_destroy();
    
    echo "<script>alert('Phiên đăng nhập hết hạn, vui lòng đăng nhập lại!');</script>";

    // Chuyển hướng về trang đăng nhập
    echo "<script>window.location = '../index1.php';</script>";
    exit;
}

// Update the last activity time
$_SESSION['last_activity'] = time();

$session_id = $_SESSION['slogin'];
$session_role = $_SESSION['srole'];
$session_semail = $_SESSION['semail'];
$session_sfirstname = $_SESSION['sfirstname'];
$session_slastname = $_SESSION['slastname'];
$session_smiddlename = $_SESSION['smiddlename'];
$session_scontact = $_SESSION['scontact'];
$session_sdesignation = $_SESSION['sdesignation'];
$session_sstaff_id = $_SESSION['sstaff_id'];
$session_image = $_SESSION['simageurl'];
$session_depart = $_SESSION['department'];
$session_supervisor = $_SESSION['is_supervisor'];
?>
