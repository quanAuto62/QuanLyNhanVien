<?php
date_default_timezone_set('Asia/Ho_Chi_Minh'); ;
include('../includes/config.php');

function updateDepartment($id, $dname, $description)
{
    global $conn;

    if (empty($dname) || empty($description)) {
        $response = array('status' => 'error', 'message' => 'Hãy nhập đầy đủ các trường');
        echo json_encode($response);
        exit;
    }

    $currentDateTime = date('Y-m-d H:i:s');

    $stmt = mysqli_prepare($conn, "UPDATE tbldepartments SET department_name=?, department_desc=?, last_modified_date=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'sssi', $dname, $description, $currentDateTime, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Cập nhật phòng ban thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Không thể cập nhật phòng ban');
        echo json_encode($response);
        exit;
    }
}


function format_date_vietnamese($date)
{
    $months = [
        '01' => 'Tháng Một',
        '02' => 'Tháng Hai',
        '03' => 'Tháng Ba',
        '04' => 'Tháng Tư',
        '05' => 'Tháng Năm',
        '06' => 'Tháng Sáu',
        '07' => 'Tháng Bảy',
        '08' => 'Tháng Tám',
        '09' => 'Tháng Chín',
        '10' => 'Tháng Mười',
        '11' => 'Tháng Mười Một',
        '12' => 'Tháng Mười Hai',
    ];

    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);

    return $day . ' ' . $months[$month] . ', ' . $year;
}


function saveDepartment($dname, $description)
{
    global $conn;

    if (empty($dname) || empty($description)) {
        $response = array('status' => 'error', 'message' => 'Hãy nhập đầy đủ các trường!');
        echo json_encode($response);
        exit;
    }

    // Check if the department already exists
    $stmt = mysqli_prepare($conn, "SELECT * FROM tbldepartments WHERE department_name = ?");
    mysqli_stmt_bind_param($stmt, "s", $dname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $response = array('status' => 'error', 'message' => 'Phòng ban đã tồn tại');
        echo json_encode($response);
        exit;
    } else {
        // Chuẩn bị truy vấn thêm 1 phòng ban
        $currentDateTime = date('Y-m-d H:i:s'); // Lấy thời gian
        $stmt = mysqli_prepare($conn, "INSERT INTO tbldepartments (department_name, department_desc, creation_date) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $dname, $description, $currentDateTime);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $response = array('status' => 'success', 'message' => 'Thêm phòng ban thành công');
            echo json_encode($response);
            exit;
        } else {
            $response = array('status' => 'error', 'message' => 'Không thể thêm phòng ban.');
            echo json_encode($response);
            exit;
        }
    }
}

function deleteDepartment($id)
{
    
    global $conn;

    $stmt = mysqli_prepare($conn, "DELETE FROM tbldepartments WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'Xóa phòng ban thành công');
        echo json_encode($response);
        exit;
    } else {
        $response = array('status' => 'error', 'message' => 'Không thể xóa phòng ban');
        echo json_encode($response);
        exit;
    }
}


if (isset($_POST['action'])) {
    // Xác định hành động nào cần thực hiện
    if ($_POST['action'] === 'update') {
        $dname = $_POST['dname'];
        $description = $_POST['description'];
        $id = $_POST['id'];
        $response = updateDepartment($id, $dname, $description);
        echo $response;
    } elseif ($_POST['action'] === 'save') {
        $dname = $_POST['dname'];
        $description = $_POST['description'];
        $response = saveDepartment($dname, $description);
        echo $response;
    } elseif ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $response = deleteDepartment($id);
        echo $response;
    }
}
