<?php include('../includes/header.php') ?>
<?php
// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['slogin']) || !isset($_SESSION['srole'])) {
    header('Location: ../index1.php');
    exit();
}

// Kiểm tra vai trò người dùng
$userRole = $_SESSION['srole'];
if ($userRole !== 'Manager' && $userRole !== 'Admin') {
    header('Location: ../index1.php');
    exit();
}


// Kiểm tra filter
$departmentFilter = isset($_GET['department']) ? $_GET['department'] : 'Xem Tất Cả';

// Khởi tạo biến 
$selectedDepartmentId = null;
$selectedDepartmentName = 'Xem Tất Cả';

// Construct the query
$query = "SELECT emp_id, first_name, middle_name, last_name, phone_number, designation, email_id, department, image_path FROM tblemployees";

// Check if a specific department is selected
if ($departmentFilter !== 'Xem Tất Cả') {
    // Perform a lookup to get the department ID based on the selected department name
    $departmentLookupQuery = mysqli_prepare($conn, "SELECT id FROM tbldepartments WHERE department_name = ?");
    mysqli_stmt_bind_param($departmentLookupQuery, "s", $departmentFilter);
    mysqli_stmt_execute($departmentLookupQuery);
    mysqli_stmt_store_result($departmentLookupQuery);
    mysqli_stmt_bind_result($departmentLookupQuery, $selectedDepartmentId);

    // Fetch the department ID
    mysqli_stmt_fetch($departmentLookupQuery);
    mysqli_stmt_close($departmentLookupQuery);

    // Modify the query to filter by department ID
    $query .= " WHERE department = ?";
    $selectedDepartmentName = $departmentFilter; // Update the selected department name
}

$query .= " ORDER BY date_created DESC";

// Prepare and execute the query
$stmt = mysqli_prepare($conn, $query);

if ($departmentFilter !== 'Xem Tất Cả') {
    // Bind the department filter parameter
    mysqli_stmt_bind_param($stmt, "s", $selectedDepartmentId);
}

mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $id, $firstname, $middlename, $lastname, $contact, $designation, $email, $department, $image_path);

$employeeData = [];

while (mysqli_stmt_fetch($stmt)) {
    $employeeData[] = [
        'id' => $id,
        'firstname' => $firstname,
        'middlename' => $middlename,
        'lastname' => $lastname,
        'contact' => $contact,
        'designation' => $designation,
        'email' => $email,
        'department' => $department,
        'image_path' => $image_path,
    ];
}

mysqli_stmt_close($stmt);
?>

<body>
    <!-- Pre-loader start -->
    <?php include('../includes/loader.php') ?>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <?php include('../includes/topbar.php') ?>

            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <?php $page_name = "staff_list"; ?>
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
                                                        <h4>Danh Sách Nhân Viên</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page-header end -->
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="row">

                                            <div class="col-lg-12 filter-bar">
                                                <!-- Nav Filter tab start -->
                                                <nav class="navbar navbar-light bg-faded m-b-30 p-10">
                                                    <ul class="nav navbar-nav">
                                                        <li class="nav-item active">
                                                            <a class="nav-link" href="#!">Lọc Theo Phòng Ban: <span class="sr-only">(current)</span></a>
                                                        </li>
                                                        <!-- Your existing HTML for the dropdown -->
                                                        <li class="nav-item dropdown">
                                                            <a class="nav-link dropdown-toggle" href="#!" id="bydepartment" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="icofont icofont-home"></i> <?php echo $departmentFilter; ?>
                                                            </a>
                                                            <div class="dropdown-menu" aria-labelledby="bydepartment">
                                                                <a class="dropdown-item <?php echo ($selectedDepartmentName === 'Xem Tất Cả') ? 'active' : ''; ?>" href="?department=Xem Tất Cả">Xem Tất Cả</a>
                                                                <div class="dropdown-divider"></div>
                                                                <?php
                                                                $departmentLookup = [];
                                                                $departmentQuery = mysqli_query($conn, "SELECT id, department_name FROM tbldepartments");
                                                                if ($departmentQuery && mysqli_num_rows($departmentQuery) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($departmentQuery)) {
                                                                        $departmentId = $row['id'];
                                                                        $departmentName = $row['department_name'];
                                                                        $departmentLookup[$departmentId] = $departmentName;
                                                                    }
                                                                }

                                                                foreach ($departmentLookup as $id => $name) {
                                                                    $isActive = ($selectedDepartmentName === $name) ? 'active' : '';
                                                                    echo '<a class="dropdown-item ' . $isActive . '" href="?department=' . $name . '">' . $name . '</a>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="nav-item nav-grid">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm ở đây ...">
                                                            <span class="input-group-addon" id="basic-addon1"><i class="icofont icofont-search"></i></span>
                                                        </div>
                                                    </div>
                                                    <!-- end of by priority dropdown -->
                                                </nav>
                                            </div>
                                        </div>
                                        <!-- rounded staff card start -->
                                        <div id="staffContainer" class="row users-card">
                                        </div>
                                        <!-- Rounded staff card end -->
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                            </div>
                            <!-- Main body end -->
                            <div >

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Jquery -->
    <?php include('../includes/scripts.php') ?>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Event listener for "Delete" buttons with class "delete-staff"
            $(document).on('click', '.delete-staff', function(event) {
                event.preventDefault();
                const staffId = $(this).data('id');
                console.log(staffId)
                (async () => {
                    const {
                        value: formValues
                    } = await Swal.fire({
                        title: 'Bạn chắc chắn chưa?',
                        text: "Bạn sẽ không thể hoàn tác hành động này!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Có, xóa đi!'
                    });

                    if (formValues) {
                        var data = {
                            id: staffId,
                            action: "delete-staff"
                        };

                        $.ajax({
                            url: 'staff_functions.php',
                            type: 'post',
                            data: data,
                            success: function(response) {
                                const responseObject = JSON.parse(response);
                                if (response && responseObject.status === 'success') {
                                    // Show success message
                                    Swal.fire({
                                        icon: 'success',
                                        html: responseObject.message,
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
                                        text: responseObject.message,
                                        confirmButtonColor: '#eb3422',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log("AJAX error: " + error);
                                Swal.fire('Error!', 'Xóa thất bại', 'error');
                            }
                        });
                    }
                })();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Truy xuất giá trị bộ lọc bộ phận ban đầu
            var selectedDepartment = '<?php echo $selectedDepartmentName; ?>';
            // Chức năng tìm nạp và hiển thị nhân viên đã lọc
            function fetchStaff() {
                var searchQuery = $('#searchInput').val(); // Get the search query
                var departmentFilter = (selectedDepartment === 'Xem Tất Cả') ? '' : selectedDepartment; // Lấy giá trị bộ lọc bộ phận
                // Thực hiện yêu cầu AJAX để tìm nạp nhân viên đã lọc
                $.ajax({
                    url: 'staff_functions.php', 
                    type: 'POST',
                    data: {
                        searchQuery: searchQuery,
                        departmentFilter: departmentFilter
                    },
                    success: function(response) {
                        // Xóa thẻ nhân viên hiện có
                        $('#staffContainer').empty();

                        // Gắn thẻ nhân viên đã tìm nạp vào container
                        $('#staffContainer').append(response);
                    }
                });
            }
            // Event listener for search input field
            $('#searchInput').on('keyup', function() {
                fetchStaff();
            });

            // Event listener for department filter dropdown
            $('#bydepartment .dropdown-item').on('click', function(event) {
                event.preventDefault();
                // Update the selected department variable and dropdown text
                selectedDepartment = $(this).text().trim();
                $('#bydepartment').text(selectedDepartment);

                // Fetch the staff based on the updated filter
                fetchStaff();
            });

            // Fetch the initial staff based on the default filter
            fetchStaff();
        });
    </script>

</body>

</html>