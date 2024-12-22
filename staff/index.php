
<?php include('../includes/header.php')?>
<?php
// Check if the user is logged in
if (!isset($_SESSION['slogin']) || !isset($_SESSION['srole'])) {
    header('Location: ../index1.php');
    exit();
}

// Check if the user has the role of Manager or Admin
$userRole = $_SESSION['srole'];
if ($userRole !== 'Staff') {
    header('Location: ../index1.php');
    exit();
}

// Get the logged-in user ID
$userId = $_SESSION['slogin'];

?>

<?php
$totalStaff = 0;

// Assuming you have a database connection, fetch all departments
$departmentQuery = $conn->prepare("SELECT * FROM tbldepartments");
$departmentQuery->execute();
$departmentResult = $departmentQuery->get_result();

$departments = [];

while ($departmentRow = $departmentResult->fetch_assoc()) {
    $departmentId = $departmentRow['id'];
    $departmentName = $departmentRow['department_name'];
    $departmentDesc = $departmentRow['department_desc'];

    // Fetch the count of staff in the department
    $staffQuery = $conn->prepare("SELECT COUNT(*) as staff_count FROM tblemployees WHERE department = ?");
    $staffQuery->bind_param("i", $departmentId);
    $staffQuery->execute();
    $staffResult = $staffQuery->get_result();
    $staffRow = $staffResult->fetch_assoc();
    $staffCount = $staffRow['staff_count'];

    $totalStaff += $staffCount;

    // Fetch the count of managers in the department
    $managerQuery = $conn->prepare("SELECT COUNT(*) as manager_count FROM tblemployees WHERE department = ? AND role = 'Manager'");
    $managerQuery->bind_param("i", $departmentId);
    $managerQuery->execute();
    $managerResult = $managerQuery->get_result();
    $managerRow = $managerResult->fetch_assoc();
    $managerCount = $managerRow['manager_count'];

    $departments[] = [
        'id' => $departmentId,
        'name' => $departmentName,
        'desc' => $departmentDesc,
        'staffCount' => $staffCount,
        'managerCount' => $managerCount,
    ];
}
?>


<body>
    <!-- Pre-loader start -->
    <?php include('../includes/loader.php')?>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

           <?php include('../includes/topbar.php')?>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <?php $page_name = "dashboard"; ?>
                    <?php include('../includes/sidebar.php')?>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <!-- user card  start -->
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card widget-card-1">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(*) as total_employee FROM tblemployees");
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        $row = $result->fetch_assoc();
                                                        $total_employee = $row['total_employee'];    
                                                    ?>
                                                    <div class="card-block-small">
                                                        <i class="feather icon-user bg-c-blue card1-icon"></i>
                                                        <span class="text-c-blue f-w-600">Active Staff</span>
                                                        <?php if ($total_employee == 0): ?>
                                                            <h4>No</h4>
                                                        <?php else: ?>
                                                            <h4><?= $total_employee ?></h4>
                                                        <?php endif; ?>
                                                        <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-blue f-16 feather icon-user m-r-10"></i>Registered Staff
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card widget-card-1">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(*) as total_depart FROM tbldepartments");
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        $row = $result->fetch_assoc();
                                                        $total_depart = $row['total_depart'];    
                                                    ?>
                                                    <div class="card-block-small">
                                                        <i class="feather icon-home bg-c-pink card1-icon"></i>
                                                        <span class="text-c-pink f-w-600">Phòng ban</span>
                                                        <?php if ($total_depart == 0): ?>
                                                            <h4>No</h4>
                                                        <?php else: ?>
                                                            <h4><?= $total_depart ?></h4>
                                                        <?php endif; ?>
                                                        <div>
                                                            <span class="f-left m-t-10 text-muted">
                                                                <i class="text-c-pink f-16 feather icon-home m-r-10"></i>Phòng ban khả dụng
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- user card  end -->

                                            <!-- statustic with progressbar  start -->
                                             
                                            <!-- statustic with progressbar  end -->

                                            <!-- Department  start -->
                                            <?php foreach ($departments as $department): ?>
                                            <div class="col-md-12 col-xl-6 ">
                                                <div class="card app-design">
                                                    <div class="card-block">
                                                        <a href="staff_list.php?department=<?= urlencode($department['name']) ?>"><button class="btn btn-primary f-right"><?= $department['name'] ?></button></a>
                                                        <h6 class="f-w-400 text-muted"><?= $department['desc'] ?></h6>
                                                        <div class="design-description d-inline-block m-r-40">
                                                            <?php if ($department['staffCount'] > 0): ?>
                                                                <h3 class="f-w-400"><?= $department['staffCount'] ?></h3>
                                                            <?php else: ?>
                                                                <h5>0</h5>
                                                            <?php endif; ?>
                                                            <p class="text-muted">Tổng Số Nhân Viên</p>
                                                        </div>
                                                        <div class="design-description d-inline-block">
                                                            <?php if ($department['managerCount'] > 0): ?>
                                                                <h3 class="f-w-400"><?= $department['managerCount'] ?></h3>
                                                            <?php else: ?>
                                                                <h5>0</h5>
                                                            <?php endif; ?>
                                                            <p class="text-muted">Tổng Số Quản Lý</p>
                                                        </div>
                                                        <div class="team-box p-b-20">
                                                            <p class="d-inline-block m-r-20 f-w-400">
                                                                <?php
                                                                if ($department['staffCount'] > 0) {
                                                                    echo "Team";
                                                                } else {
                                                                    echo "Không Có Nhân Viên";
                                                                }
                                                                ?>
                                                            </p>
                                                            <div class="team-section d-inline-block">
                                                                <?php
                                                                // Fetch and display only 10 staff members for this department
                                                                $staffQuery = $conn->prepare("SELECT * FROM tblemployees WHERE department = ? LIMIT 10");
                                                                $staffQuery->bind_param("i", $department['id']);
                                                                $staffQuery->execute();
                                                                $staffResult = $staffQuery->get_result();

                                                                while ($staffRow = $staffResult->fetch_assoc()) {
                                                                    $staffImage = $staffRow['image_path'];
                                                                    $staffName = $staffRow['first_name'] . ' ' . $staffRow['last_name'];
                                                                    echo "<a href='#!'><img src='$staffImage' data-toggle='tooltip' title='$staffName' alt='' class='m-l-5 '></a>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="progress-box">
                                                            <p class="d-inline-block m-r-20 f-w-400">Tiến trình</p>
                                                            <div class="progress d-inline-block">
                                                                 <?php
                                                                   $staffPercentage = $totalStaff > 0 ? round(($department['staffCount'] / $totalStaff) * 100) : 0;
                                                                 ?>
                                                                <div class="progress-bar bg-c-blue" style="width:<?= $staffPercentage ?>% "><label><?= $staffPercentage ?>%</label></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            <!-- Department  end -->
                                                    
                                        </div>
                                    </div>
                                    <!-- Page-body end -->
                                    
                                </div>
                                <div > </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Jquery -->
    <?php include('../includes/scripts.php')?>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
</body>

</html>