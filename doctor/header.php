<?php
session_start();

include("../connection.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <style>
        li a {
            font-weight: 500;
        }
    </style>
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="header" style="background-color:#7D9FE6;">
        <div class="header-left">
            <a href="index.php" class="logo">
                <img src="../admin/assets/img/logo.png" width="35" height="35" alt=""> <span>Preclinic</span>
            </a>
        </div>
        <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
        <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu float-right">
            <li class="nav-item dropdown d-none d-sm-block">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i>
                    <span class="badge badge-pill bg-danger float-right">3</span></a>
                <div class="dropdown-menu notifications">
                    <div class="topnav-dropdown-header">
                        <span>Notifications</span>
                    </div>
                    <div class="drop-scroll">
                        <ul class="notification-list">
                            <li class="notification-message">
                                <a href="activities.html">
                                    <div class="media">
                                        <span class="avatar">
                                            <img alt="John Doe" src="assets/img/user.jpg" class="img-fluid">
                                        </span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">John Doe</span> added
                                                new task <span class="noti-title">Patient appointment booking</span>
                                            </p>
                                            <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-message">
                                <a href="activities.html">
                                    <div class="media">
                                        <span class="avatar">V</span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">Tarah Shropshire</span>
                                                changed the task name <span class="noti-title">Appointment booking
                                                    with payment gateway</span></p>
                                            <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-message">
                                <a href="activities.html">
                                    <div class="media">
                                        <span class="avatar">L</span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">Misty Tison</span>
                                                added <span class="noti-title">Domenic Houston</span> and <span
                                                    class="noti-title">Claire Mapes</span> to project <span
                                                    class="noti-title">Doctor available module</span></p>
                                            <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-message">
                                <a href="activities.html">
                                    <div class="media">
                                        <span class="avatar">G</span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">Rolland Webber</span>
                                                completed task <span class="noti-title">Patient and Doctor video
                                                    conferencing</span></p>
                                            <p class="noti-time"><span class="notification-time">12 mins ago</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-message">
                                <a href="activities.html">
                                    <div class="media">
                                        <span class="avatar">V</span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span>
                                                added new task <span class="noti-title">Private chat module</span>
                                            </p>
                                            <p class="noti-time"><span class="notification-time">2 days ago</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="activities.html">View all Notifications</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown d-none d-sm-block">
                <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i
                        class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right">8</span></a>
            </li>
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                    <!-- <span>
                        <?php

                        if (isset($_SESSION['admin'])) {
                            $admin = $_SESSION['admin'];
                            $query_user = mysqli_query($cnn, "select * from staff where email='" . $_SESSION['admin'] . "'");
                            $row_user = mysqli_fetch_array($query_user);

                            echo $row_user['name'];
                        } else {
                            echo "Admin";
                        }


                        ?>
                    </span> -->
                    <span class="user-icon rounded-circle">
                        <?php
                        $query_cnt = mysqli_query($cnn, "select * from staff where email='" . $_SESSION['admin'] . "'");
                        $row_cnt = mysqli_fetch_array($query_cnt);
                        ?>
                        <?php
                        if ($row_cnt['image'] != NULL && $row_cnt['image'] != "") { ?>
                            <img src="../image/<?php echo $row_cnt['image']; ?>" alt="" style="height: 50px;"
                                class="rounded-circle p-1" />
                            <?php
                        } else {
                            ?>
                            <img src="assets/img/user.jpg" alt="" style="height: 50px;" class="rounded-circle p-1" />

                            <?php
                        }
                        ?>
                        <!-- <img class="rounded-circle" src="assets/img/user.jpg" width="24" alt="Admin"> -->
                        <!-- <span class="status online"></span> -->
                    </span>

                </a>
                <div class="dropdown-menu p-3">
                    <!-- <a class="dropdown-item" href="profile.html">My Profile</a> -->
                    <a class="dropdown-item p-2 " style="font-size:16px;" href="profile.php"> <i
                            class="fa fa-pencil-square-o mr-2" style="font-size:20px;font-weight:bold;"></i>Edit
                        Profile</a>
                    <a class="dropdown-item p-2" style="font-size:16px;" href="../changepwd.php"><i class="fa fa-lock mr-3"
                            style="font-size:20px;font-weight:bold;"></i>Change-Password</a>
                    <a class="dropdown-item p-2" style="font-size:16px;" href="logout.php"><i
                            class="fa fa-sign-out mr-2" style="font-size:20px;font-weight:bold;"></i>Logout</a>
                </div>
            </li>
        </ul>
        <!-- <div class="dropdown mobile-user-menu float-right">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                    class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="profile.html">My Profile</a>
                <a class="dropdown-item" href="edit-profile.php">Edit Profile</a>
                <a class="dropdown-item" href="settings.html">Settings</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div> -->
    </div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll" style="background-color:#F6F6F6;">
            <div id="sidebar-menu" class="sidebar-menu p-2 ">
                <ul>
                <li style="background-color:#e5ebfa;">
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                        <a href="schedule.php"><i class="fa fa-calendar"></i> <span>Schedule</span></a>
                    </li>
                    <!-- <li>
                        <a href="schedule.php"><i class="fa fa-calendar-check-o"></i> <span>Doctor
                                Schedule</span></a>
                    </li> -->
                    <!-- <li class="submenu">
                        <a href="#"><i class="fa fa-user"></i> <span> Employees </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="employees.php">Employees List</a></li>
                            <li><a href="leaves.php">Leaves</a></li>
                            <li><a href="holidays.php">Holidays</a></li>
                        </ul>
                    </li> -->
                    <li>
                        <a href="view_app.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                    </li>
                    <li class="submenu">
                            <a href="#"><i class="	fa fa-tint"></i> <span>IPD/OPD</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="view_ipd.php">IPD Patients </a></li>
                                <li><a href="view_opd.php"> OPD Patients </a></li>
                            </ul>
                        </li>
                    <li>
                        <a href="operation.php"><i class="fa fa-calendar"></i> <span>Operations</span></a>
                    </li>
                    <li>
                        <a href="department.php"><i class="fa fa-hospital-o"></i> <span>Appointments</span></a>
                    </li>
                    <!-- <li>
                        <a href="appointments.php"><i class="fa fa-calendar"></i> <span>Bed List</span></a>
                    </li> -->
                        <!-- <li class="submenu">
                            <a href="#"><i class="	fa fa-tint"></i> <span> Blood Bank </span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="donors.php">Blood Donor </a></li>
                                <li><a href="blood-issue.php"> Blood Issue </a></li>
                            </ul>
                        </li> -->
                        <li class="submenu">
                            <a href="#"><i class="	fa fa-bed"></i> <span> Management</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="ward.php">Ward Status</a></li>
                                <li><a href="bed.php">Bed Status</a></li>
                                <li><a href="blood-issue.php"> Blood Issue </a></li>
                            </ul>
                        </li>
                        <li>
                        <a href="leave.php"><i class="fa fa-calendar"></i> <span>Leave</span></a>
                    </li>
                    <li>
                        <a href="holidays.php"><i class="fa fa-calendar"></i> <span>Holidays</span></a>
                    </li>


                </ul>
            </div>
        </div>
    </div>

</body>

</html>