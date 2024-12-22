<?php include('../includes/config.php'); ?>
<?php include('../includes/session.php');?>

<?php
// // Fetch the last assigned staff ID
// $query = "SELECT staff_id FROM tblemployees ORDER BY staff_id DESC LIMIT 1";
// $result = $conn->query($query);

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     $lastId = $row['staff_id'];
//     $lastNumber = (int)substr($lastId, 4); // Extract the numeric part of the ID
//     $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Increment and format the number

// } else {
//     $newNumber = '001';
// }

// $newId = 'CF ' . $newNumber;
// echo $newId;
$query = "SELECT CONCAT('CF ', LPAD(COALESCE(MAX(CAST(SUBSTRING(staff_id, 4) AS UNSIGNED)), 0) + 1, 3, '0')) AS newId 
          FROM tblemployees";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newId = $row['newId'];
    echo $newId;
} else {
    echo 'CF 001'; // Trường hợp không có bản ghi nào
}

?>
