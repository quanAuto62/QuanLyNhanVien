<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <?php if ($session_role == 'Manager'  || $session_role == 'Admin') : ?>
            <div class="pcoded-navigatio-lavel">Điều hướng</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="<?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                    <a href="index.php">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Tổng Quan</span>
                    </a>
                </li>
            </ul>
            <div class="pcoded-navigatio-lavel">Chức năng</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="<?php echo ($page_name == 'department') ? 'active' : ''; ?>">
                    <a href="department.php">
                        <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                        <span class="pcoded-mtext">Phòng Ban</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu <?php echo ($page_name == 'staff' || $page_name == 'new_staff' || $page_name == 'staff_list') ? 'active pcoded-trigger' : ''; ?>">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                        <span class="pcoded-mtext">Quản Lý Nhân Viên</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="<?php echo ($page_name == 'new_staff') ? 'active' : ''; ?>">
                            <a href="new_staff.php">
                                <span class="pcoded-mtext">Thêm Nhân Viên</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'staff_list') ? 'active' : ''; ?>">
                            <a href="staff_list.php">
                                <span class="pcoded-mtext">Danh Sách Nhân Viên</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu <?php echo ($page_name == 'task' || $page_name == 'new_task' || $page_name == 'task_list') ? 'active pcoded-trigger' : ''; ?>">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                        <span class="pcoded-mtext">Quản Lý Nhiệm Vụ</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="<?php echo ($page_name == 'new_task') ? 'active' : ''; ?>">
                            <a href="new_task.php">
                                <span class="pcoded-mtext">Thêm Nhiệm Vụ</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'task_list') ? 'active' : ''; ?>">
                            <a href="task_list.php">
                                <span class="pcoded-mtext">Danh sách Nhiệm Vụ</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        <?php endif; ?>   
        <?php if ($session_role == 'Staff') : ?>
            <div class="pcoded-navigatio-lavel">Điều hướng</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="<?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                    <a href="index.php">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Tổng Quan</span>
                    </a>
                </li>
            </ul>
            <div class="pcoded-navigatio-lavel">Chức năng</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="<?php echo ($page_name == 'department') ? 'active' : ''; ?>">
                    <a href="department.php">
                        <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                        <span class="pcoded-mtext">Phòng Ban</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu <?php echo ($page_name == 'staff' || $page_name == 'staff_list') ? 'active pcoded-trigger' : ''; ?>">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                        <span class="pcoded-mtext">Danh sách Nhân Viên</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="<?php echo ($page_name == 'staff_list') ? 'active' : ''; ?>">
                            <a href="staff_list.php">
                                <span class="pcoded-mtext">Danh sách nhân viên</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="pcoded-hasmenu <?php echo ($page_name == 'leave' || $page_name == 'apply_leave'|| $page_name == 'my_leave'|| $page_name == 'supervisee_leave_request') ? 'active pcoded-trigger' : ''; ?>">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="feather icon-shuffle"></i></span>
                        <span class="pcoded-mtext">Leave</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="<?php echo ($page_name == 'apply_leave') ? 'active' : ''; ?>">
                            <a href="apply_leave.php">
                                <span class="pcoded-mtext">Apply Leave</span>
                            </a>
                        </li>
                         <li class="<?php echo ($page_name == 'my_leave') ? 'active' : ''; ?>">
                            <a href="my_leave.php">
                                <span class="pcoded-mtext">My Leave</span>
                            </a>
                        </li>
                        <?php if ($session_role == 'Staff' && $session_supervisor == '1') : ?>
                            <li class="<?php echo ($page_name == 'supervisee_leave_request') ? 'active' : ''; ?>">
                                <a href="supervisee_leave_request.php?leave_status=0">
                                    <span class="pcoded-mtext">Supervisee Request</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li> -->
                <li class="pcoded-hasmenu <?php echo ($page_name == 'task' || $page_name == 'new_task' || $page_name == 'my_task_list') ? 'active pcoded-trigger' : ''; ?>">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                        <span class="pcoded-mtext">Quản Lý Nhiệm Vụ</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <?php if ($session_role == 'Staff' && $session_supervisor == '1') : ?>
                         <li class="<?php echo ($page_name == 'new_task') ? 'active' : ''; ?>">
                            <a href="new_task.php">
                                <span class="pcoded-mtext">Thêm Nhiệm Vụ</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="<?php echo ($page_name == 'my_task_list') ? 'active' : ''; ?>">
                            <a href="my_task_list.php">
                                <span class="pcoded-mtext">Nhiệm Vụ Của Tôi</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        <?php endif; ?>    
        <div class="pcoded-navigatio-lavel">Hỗ Trợ</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="https://www.facebook.com/profile.php?id=100010630025884">
                    <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                    <span class="pcoded-mtext">Facebook</span>
                </a>
            </li>
            <li class="">
                <a href="index.php">
                    <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                    <span class="pcoded-mtext">CyberFort</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
