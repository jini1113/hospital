<?php
include("../connection.php");
session_start(); // Move this to the very top of the file


if (!isset($_SESSION["admin"]) || $_SESSION['admin'] == NULL || $_SESSION["admin"] == "") {
    header("Location:../login.php");
    exit; // Ensure to exit after redirect
}

// Add this block to handle AJAX request for fetching blood group
if (isset($_GET['donor_id'])) {
    $donor_id = $_GET['donor_id'];
    $query = mysqli_query($cnn, "SELECT b_group FROM donor WHERE id = '$donor_id'");
    if ($row = mysqli_fetch_assoc($query)) {
        echo $row['b_group'];
    } else {
        echo "";
    }
    exit; // Ensure the script stops here when fetching blood group
}
// include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<!-- add-department24:07-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
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
    <div class="main-wrapper">
        <div class="header" style="background-color:#7D9FE6;">
            <div class="header-left">
                <a href="index-2.html" class="logo">
                    <img src="assets/img/logo.png" width="35" height="35" alt=""> <span>Preclinic</span>
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
                            class="fa fa-comment-o"></i> <span
                            class="badge badge-pill bg-danger float-right">8</span></a>
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
                        <a class="dropdown-item p-2 " style="font-size:16px;" href="edit-profile.php"> <i
                                class="fa fa-pencil-square-o mr-2" style="font-size:20px;font-weight:bold;"></i>Edit
                            Profile</a>
                        <a class="dropdown-item p-2" style="font-size:16px;" href="settings.html"><i
                                class="fa fa-lock mr-3" style="font-size:20px;font-weight:bold;"></i>Change-Password</a>
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
                    <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                    <a class="dropdown-item" href="settings.html">Settings</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div> -->
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll" style="background-color:#F6F6F6;">
                <div id="sidebar-menu" class="sidebar-menu p-2">
                    <ul>
                        <!-- <li class="menu-title">Main</li> -->
                        <li style="background-color:#e5ebfa;">
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user-md"></i> <span>Doctors</span><span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="doctors.php">Doctors List</a></li>
                                <li><a href="schedule.php"> Schedule</a></li>

                            </ul>
                        </li>
                        <!-- <li>
                        <a href="schedule.php"><i class="fa fa-calendar-check-o"></i> <span>Doctor
                                Schedule</span></a>
                    </li> -->
                        <li class="submenu">
                            <a href="#"><i class="fa fa-user"></i> <span> Employees </span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="employees.php">Employees List</a></li>
                                <li><a href="leaves.php">Leaves</a></li>
                                <li><a href="holidays.php">Holidays</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="patients.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                        </li>
                        <li>
                            <a href="appointments.php"><i class="fa fa-calendar"></i> <span>Appointments</span></a>
                        </li>
                        <li>
                            <a href="department.php"><i class="fa fa-hospital-o"></i> <span>Department</span></a>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="	fa fa-tint"></i> <span> Blood Bank </span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="donors.php">Blood Donor </a></li>
                                <li><a href="blood-issue.php"> Blood Issue </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="	fa fa-bed"></i> <span> Management</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="ward.php">Ward Status</a></li>
                                <li><a href="bed.php">Bed Status</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="	fa fa-bed"></i> <span> IPD/OPD</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="in_patient.php">In Patient</a></li>
                                <li><a href="out_patient.php">Out Patient</a></li>
                                <!-- <li><a href="bed.php">Bed Status</a></li>
                            <li><a href="b_patients.php">Bed Allotment</a></li>
                            <li><a href="blood-issue.php"> Blood Issue </a></li> -->
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="#"><i class="fa fa-money"></i> <span> Accounts </span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="invoices.php">Invoices</a></li>
                                <li><a href="payments.html">Payments</a></li>
                                <!-- <li><a href="expenses.html">Expenses</a></li> -->
                                <li><a href="taxes.php">Taxes</a></li>
                                <!-- <li><a href="provident-fund.html">Provident Fund</a></li> -->
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-book"></i> <span> Payroll </span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="salary.php"> Employee Salary </a></li>
                                <li><a href="salary-view.html"> Payslip </a></li>
                            </ul>
                        </li>
                        <!-- <li class="submenu">
                            <a href="#"><i class="fa fa-commenting-o"></i> <span> Blog</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog-details.html">Blog View</a></li>
                                <li><a href="add-blog.html">Add Blog</a></li>
                                <li><a href="edit-blog.html">Edit Blog</a></li>
                            </ul>
                        </li> -->
                        <li>
                            <a href="assets.php"><i class="fa fa-cube"></i> <span>Assets</span></a>
                        </li>

                        <!-- <li>
                            <a href="settings.html"><i class="fa fa-cog"></i> <span>Settings</span></a>
                        </li> -->

                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <?php
                        if (isset($_GET['id'])) {
                            $query = mysqli_query($cnn, "select * from b_issue where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3  ">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update Blood Issue ";
                                } else {
                                    echo "Add  Blood Issue ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-75 ">
                        <div class="row">   
                            <div class="col-lg-8 offset-lg-2">
                                <form method="post" enctype="multipart/form-data" id="frm">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['id'];
                                                } ?>" hidden />
                                                <label>Issue Date</label>
                                                <input type="date" class="form-control " name="txtDate" id="txtDate"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['date'];
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Patient Name</label>
                                                <select class="select" id="txtPatient" name="txtPatient">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $query_patient = mysqli_query($cnn, "SELECT * FROM patients");
                                                    while ($row_patient = mysqli_fetch_array($query_patient)) {
                                                        echo "<option value='" . $row_patient['id'] . "'";
                                                        if (isset($_GET['id'])) {
                                                            // Assuming $row is defined earlier and contains the data of the item being edited
                                                            if ($row['patient_id'] == $row_patient['id']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">" . $row_patient['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Doctor</label>
                                                <select class="select" id="txtDoc" name="txtDoc">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $query_doctor = mysqli_query($cnn, "SELECT * FROM staff where role='Doctor'");
                                                    while ($row_doctor = mysqli_fetch_array($query_doctor)) {
                                                        echo "<option value='" . $row_doctor['id'] . "'";
                                                        if (isset($_GET['id'])) {
                                                            // Assuming $row is defined earlier and contains the data of the item being edited
                                                            if ($row['doctor_id'] == $row_doctor['id']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">" . $row_doctor['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Donor Name</label>
                                                <select class="select" id="txtDonor" name="txtDonor"
                                                    onchange="fetchDonorBloodGroup()">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $query_donor = mysqli_query($cnn, "SELECT * FROM donor");
                                                    while ($row_donor = mysqli_fetch_array($query_donor)) {
                                                        echo "<option value='" . $row_donor['id'] . "'";
                                                        if (isset($_GET['id'])) {
                                                            // Assuming $row is defined earlier and contains the data of the item being edited
                                                            if ($row['donor_id'] == $row_donor['id']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">" . $row_donor['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Blood Group</label>
                                                <input class="form-control" type="text" id="txtGrp" name="txtGrp" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['group'];
                                                } ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Amount <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="txtAmt" name="txtAmt" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['amount'];
                                                } ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Usage</label>
                                                <textarea type="text" name="txtUse" id="txtUse" class="form-control"><?php if (isset($_GET['id'])) {
                                                    echo $row['des'];
                                                } ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-t-20 text-center">
                                        <button type="submit"
                                            name="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                                            id="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                                            class="btn btn-primary submit-btn">Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- insert code -->
                        <?php

                        // update code
                        if (isset($_POST['btnUpdate'])) {
                            $id = $_POST['txtUId'];
                            $date = $_POST['txtDate'];
                            $patient = $_POST['txtPatient'];
                            $doctor = $_POST['txtDoc'];
                            $donor = $_POST['txtDonor'];
                            $group = $_POST['txtGrp'];
                            $amount = $_POST['txtAmt'];
                            $use = $_POST['txtUse'];

                            $cols = "date='$date', patient_id='$patient', doctor_id='$doctor', donor_id='$donor', `group`='$group', amount='$amount', des='$use'";

                            $query = mysqli_query($cnn, "UPDATE b_issue SET $cols WHERE id=$id");
                            if ($query) {
                                echo "<script>window.location.replace('blood-issue.php');</script>";
                            } else {
                                echo "<script>alert('Some error occurred. Please try again');</script>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="notification-box">
                    <div class="msg-sidebar notifications msg-noti">
                        <div class="topnav-dropdown-header">
                            <span>Messages</span>
                        </div>
                        <div class="drop-scroll msg-list-scroll" id="msg_list">
                            <ul class="list-box">
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">R</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">Richard Miles </span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item new-message">
                                            <div class="list-left">
                                                <span class="avatar">J</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">John Doe</span>
                                                <span class="message-time">1 Aug</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">T</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author"> Tarah Shropshire </span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">M</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">Mike Litorus</span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">C</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author"> Catherine Manseau </span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">D</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author"> Domenic Houston </span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">B</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author"> Buster Wigton </span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">R</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author"> Rolland Webber </span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">C</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author"> Claire Mapes </span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">M</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">Melita Faucher</span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">J</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">Jeffery Lalor</span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">L</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">Loren Gatlin</span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">T</span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">Tarah Shropshire</span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet,
                                                    consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="chat.html">See all messages</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/app.js"></script>
        <?php include("included_js.php"); ?>
        <script src="../newjs/issue.js"></script>
        <script>
            function fetchDonorBloodGroup() {
                var donorId = document.getElementById('txtDonor').value;
                if (donorId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'add-edit-issue.php?donor_id=' + donorId, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById('txtGrp').value = xhr.responseText;
                        }
                    };
                    xhr.send();
                } else {
                    document.getElementById('txtGrp').value = '';
                }
            }
        </script>
</body>

</html>