<?php
include("../connection.php");
session_start();
include("header.php");
if (
    !isset($_SESSION["admin"]) || $_SESSION['admin'] == NULL ||
    $_SESSION["admin"] == ""
) {
    header("Location:../login.php");
}
if (isset($_GET['id'])) {
    $query = mysqli_query($cnn, "select * from d_schedule where id=" . $_GET['id'] . "");
    $row = mysqli_fetch_array($query);
    $availableDays = explode(", ", $row['days']);
} else {
    $availableDays = []; // Initialize if not updating
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- add-schedule24:07-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System - Holidays</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <?php
                        if (isset($_GET['id'])) {
                            $query = mysqli_query($cnn, "select * from d_schedule where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                            $availableDays = explode(", ", $row['days']);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3  ">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update Doctor-Schedule";
                                } else {
                                    echo "Add Doctor-Schedule ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-75 ">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <form method="POST" id="frm">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['id'];
                                                } ?>" hidden />

                                                <label>Doctor Name</label>
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
                                                <label>Available Days</label>
                                                <select class="select" multiple name="txtDays[]" id="txtDays">
                                                    <option value="">Select Days</option>
                                                    <?php
                                                    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                                    foreach ($days as $day) {
                                                        $selected = in_array($day, $availableDays) ? 'selected' : '';
                                                        echo "<option value='$day' $selected>$day</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>From(time) </label>
                                                <input class="form-control" type="time" name="txtFtime" id="txtFtime"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['from_time'];
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>To(time) </label>
                                                <input class="form-control" type="time" name="txtTotime" id="txtTotime"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['to_time'];
                                                    } ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea cols="30" rows="4" class="form-control" id="txtMsg" name="txtMsg"><?php if (isset($_GET['id'])) {
                                            echo $row['message'];
                                        } ?></textarea>
                                    </div>
                                    <div class="m-t-20 text-center">
                                        <button type="button"
                                            name="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                                            id="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                                            class="btn btn-primary submit-btn">Save
                                            changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- insert code -->
                    <?php
                    // if (isset($_POST['btnSubmit'])) {
                    //     $doctor = $_POST['txtDoc'];
                    //     $days = implode(", ", $_POST['txtDays']);
                    //     $from = date('H:i', strtotime($_POST['txtFtime']));
                    //     $to = date('H:i', strtotime($_POST['txtTotime']));
                    //     $msg = $_POST['txtMsg'];
                    


                    //     $cols = "doctor_id,days,from_time,to_time,message,status";
                    //     $values = "'$doctor','$days', '$from', '$to','$msg','Active'";
                    



                    //     $query = mysqli_query($cnn, "INSERT INTO d_schedule ($cols) VALUES ($values)");
                    
                    //     if ($query) {
                    //         echo "<script>window.location.replace('schedule.php');</script>";
                    //     } else {
                    //         echo "<script>alert('Some error occurred. Please try again.');</script>";
                    //     }
                    // }
                    
                    // update code
                    // if (isset($_POST['btnUpdate'])) {
                    //     $id = mysqli_real_escape_string($cnn, $_POST['txtUId']);
                    //     $doctor = mysqli_real_escape_string($cnn, $_POST['txtDoc']);
                    
                    //     // Check if txtDays is set and is an array
                    //     if (isset($_POST['txtDays']) && is_array($_POST['txtDays'])) {
                    //         $days = implode(", ", $_POST['txtDays']);
                    //     } else {
                    //         $days = ""; // Set to empty string if no days are selected
                    //     }
                    
                    //     $from = mysqli_real_escape_string($cnn, date('H:i', strtotime($_POST['txtFtime'])));
                    //     $to = mysqli_real_escape_string($cnn, date('H:i', strtotime($_POST['txtTotime'])));
                    //     $msg = mysqli_real_escape_string($cnn, $_POST['txtMsg']);
                    
                    //     $query = mysqli_query($cnn, "UPDATE d_schedule SET 
                    //         doctor_id = '$doctor',
                    //         days = '$days',
                    //         from_time = '$from',
                    //         to_time = '$to',
                    //         message = '$msg'
                    //         WHERE id = '$id'");
                    
                    //     if ($query) {
                    //         echo "<script>window.location.replace('schedule.php');</script>";
                    //     } else {
                    //         echo "<script>alert('Some error occurred. Please try again');</script>";
                    //     }
                    // }
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
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        $(function () {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
            $('#datetimepicker4').datetimepicker({
                format: 'LT'
            });
        });
        </script>
        <?php include("included_js.php"); ?>
            <script src = "../newjs/add-edit-schedule.js" ></script>
</body>


<!-- add-schedule24:07-->

</html>