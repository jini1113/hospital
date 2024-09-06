<?php
include("../connection.php");
include("header.php");
session_start();
if (
    !isset($_SESSION["admin"]) || $_SESSION['admin'] == NULL ||
    $_SESSION["admin"] == ""
) {
    header("Location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- add-appointment24:07-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System</title>
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
                            $query = mysqli_query($cnn, "select * from out_patient where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3  ">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update Out-Patients ";
                                } else {
                                    echo "Add Out-Patients ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-75 ">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['id'];
                                                } ?>" hidden />
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

                                        <div class="col-sm-6">
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
                                                <label>Ward</label>
                                                <select class="select" id="txtWard" name="txtWard">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $query_ward = mysqli_query($cnn, "SELECT * FROM ward");
                                                    while ($row_ward = mysqli_fetch_array($query_ward)) {
                                                        echo "<option value='" . $row_ward['id'] . "'>" . $row_ward['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Bed No.</label>
                                                <select id="txtBno" name="txtBno" class="form-control">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admit-Date</label>
                                                <input type="date" class="form-control" id="txtAdate" name="txtAdate"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['a_date'];
                                                    } ?>">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Discharge-Date</label>
                                                <input type="date" class="form-control" id="txtDate" name="txtDate"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['d_date'];
                                                    } ?>">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admit-Time</label>
                                                <input type="time" class="form-control" id="txtAtime" name="txtAtime"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['a_time'];
                                                    } ?>" onchange="calculateHours()">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Discharge-Time</label>
                                                <input type="time" class="form-control" id="txtTime" name="txtTime"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['d_time'];
                                                    } ?>" onchange="calculateHours()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Number of Hours <span class="text-danger">*</span></label>
                                                <input class="form-control" readonly type="text" id="txtHour"
                                                    name="txtHour">
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
                            <!-- insert code -->
                            <?php
                            if (isset($_POST['btnSubmit'])) {
                                $patient = $_POST['txtPatient'];
                                $doctor = $_POST['txtDoc'];
                                $bed_no = $_POST['txtBno'];
                                $ward = $_POST['txtWard'];
                                $a_date = $_POST['txtAdate'];
                                $d_date = $_POST['txtDate'];
                                $a_time = $_POST['txtAtime'];
                                $d_time = $_POST['txtTime'];

                                // Calculate the number of hours
                                $startDateTime = new DateTime("$a_date $a_time");
                                $endDateTime = new DateTime("$d_date $d_time");
                                $interval = $startDateTime->diff($endDateTime);
                                $hour = $interval->h + ($interval->days * 24); // Total hours
                            
                                // Set the value of txtHour directly
                                echo "<script>document.getElementById('txtHour').value = '$hour';</script>";

                                $cols = "patient_id,doctor_id,ward_id,a_date,d_date,a_time,d_time,hours,status";
                                $values = "'$patient','$doctor','$ward','$a_date','$d_date','$a_time','$d_time','$hour','Admit'";

                                if (!empty($bed_no)) {
                                    $cols .= ", bed_id";
                                    $values .= ", '" . $bed_no . "'";
                                } else {
                                    $cols .= ", bed_id";
                                    $values .= ", '0'";
                                }

                                // Insert the data into the database
                                $query = mysqli_query($cnn, "INSERT INTO out_patient ($cols) VALUES ($values)");

                                if ($query) {
                                    echo "<script>window.location.replace('out_patient.php');</script>";
                                } else {
                                    echo "<script>alert('Some error occurred. Please try again.');</script>";
                                }
                            }
                            // update code
                            // if (isset($_POST['btnUpdate'])) {
                            //     $id = $_POST['txtUId'];
                            //     $name = $_POST['txtPatient'];
                            //     $email = $_POST['txtMail'];
                            //     $phone = $_POST['txtPhone'];
                            //     $department = $_POST['txtDep'];
                            //     $doctor = $_POST['txtDoc'];
                            //     $date = $_POST['txtDate'];
                            //     $time = $_POST['txtTime'];
                            //     $msg = $_POST['txtMsg'];
                            



                            //     $cols .= "patient_id='" . $name . "',phone_no='" . $phone . "',date='" . $date . "',time='" . $time . "',doctor_id='" . $doctor . "',department_id='" . $department . "',message='" . $msg . "'";
                            //     $query = mysqli_query($cnn, "update appointment set " . $cols . " where id=" . $id . "");
                            //     if ($query > 0) {
                            //         echo "<script>window.location.replace('appointments.php');</script>";
                            //     } else {
                            //         echo "<script>alert('Some error occured.Please try again');</script>";
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
            <script src="assets/js/app.js"></script>
            <script src="assets/js/moment.min.js"></script>
            <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
            <?php include("included_js.php"); ?>
            <script src="../newjs/b_patients.js"></script>
            <script>
                function calculateHours() {
                    const admitDate = document.getElementById('txtAdate').value;
                    const dischargeDate = document.getElementById('txtDate').value;
                    const admitTime = document.getElementById('txtAtime').value;
                    const dischargeTime = document.getElementById('txtTime').value;

                    if (admitDate && dischargeDate && admitTime && dischargeTime) {
                        const startDateTime = new Date(`${admitDate}T${admitTime}`);
                        const endDateTime = new Date(`${dischargeDate}T${dischargeTime}`);
                        const interval = (endDateTime - startDateTime) / (1000 * 60 * 60); // Convert milliseconds to hours

                        // Update the txtHour field with the calculated hours
                        document.getElementById('txtHour').value = interval >= 0 ? Math.floor(interval) : 0; // Ensure no negative hours
                    } else {
                        document.getElementById('txtHour').value = ''; // Clear the field if inputs are incomplete
                    }
                }
            </script>
</body>


<!-- add-appointment24:07-->

</html>