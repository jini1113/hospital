<?php
include("../connection.php");
include("header.php");
// session_start();
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
    <link rel="shortcut icon" type="image/x-icon" href="../admin/assets/img/favicon.ico">
    <title>Hospital Management System</title>
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/style.css">
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
                            $query = mysqli_query($cnn, "select * from in_patient where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update In-Patients ";
                                } else {
                                    echo "Add In-Patients ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-75 ">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <form method="post" enctype="multipart/form-data" id="frm">
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
                                        <?php
                                                $query_doctor = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $_SESSION['admin'] . "'");
                                                $row_doctor = mysqli_fetch_array($query_doctor);
                                            ?>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Doctor</label>
                                                <input type="text" class="form-control" value="<?php echo $row_doctor['name']; ?>" readonly>
                                                <input type="hidden" id="txtDoc" name="txtDoc" value="<?php echo $row_doctor['id']; ?>">
                                               
                                                <!-- <select class="select" id="txtDoc" name="txtDoc">
                                                    <option value="">Select</option>
                                                    <?php
                                                    // $query_doctor = mysqli_query($cnn, "SELECT * FROM staff where role='Doctor'");
                                                    // while ($row_doctor = mysqli_fetch_array($query_doctor)) {
                                                    //     echo "<option value='" . $row_doctor['id'] . "'";
                                                    //     if (isset($_GET['id'])) {
                                                    //         // Assuming $row is defined earlier and contains the data of the item being edited
                                                    //         if ($row['doctor_id'] == $row_doctor['id']) {
                                                    //             echo " selected";
                                                    //         }
                                                    //     }
                                                    //     echo ">" . $row_doctor['name'] . "</option>";
                                                    // }
                                                    ?>

                                                </select> -->
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
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Disease</label>
                                                <input type="text" class="form-control" id="txtDis" name="txtDis" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['disease'];
                                                } ?>" placeholder="Enter Disease">
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
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Number of Hours <span class="text-danger">*</span></label>
                                                <input class="form-control" readonly type="text" id="txtHour"
                                                    name="txtHour" value="<?php if (isset($_GET['id'])) {
                                                        echo $row['hours'];
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Surgery</label><br>
                                            <input type="radio" name="surgery" value="Yes" <?php if (isset($_GET['id']) && $row['surgery'] == "Yes") echo " checked"; ?> id="surgery_yes"><b style="margin-left: 10px;">Yes</b><br>
                                            <input type="radio" name="surgery" value="No" <?php if (isset($_GET['id']) && $row['surgery'] == "No") echo " checked"; ?> id="surgery_no"><b style="margin-left: 10px;">No</b> 
                                        </div>
                                    </div>
                                    <div class="col-md-5" id="surgery_field" style="display: none;">
                                        <div class="form-group">
                                            <label>Surgery Name</label><br>
                                            <input type="text" class="form-control" id="txtSurname" name="txtSurname" value="<?php if (isset($_GET['id'])) echo $row['surgery_name']; ?>" placeholder="Enter Surgery Name">
                                        </div>
                                    </div>

                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var surgeryYes = document.getElementById('surgery_yes');
                                        var surgeryNo = document.getElementById('surgery_no');
                                        var surgeryField = document.getElementById('surgery_field');
                                        var txtSurname = document.getElementById('txtSurname');

                                        function toggleSurgeryField() {
                                            if (surgeryYes.checked) {
                                                surgeryField.style.display = 'block';
                                            } else {
                                                surgeryField.style.display = 'none';
                                                txtSurname.value = '';
                                            }
                                        }

                                        if (surgeryYes && surgeryNo && surgeryField && txtSurname) {
                                            surgeryYes.addEventListener('click', toggleSurgeryField);
                                            surgeryNo.addEventListener('click', toggleSurgeryField);

                                            // Check initial state
                                            toggleSurgeryField();
                                        } else {
                                            console.error('Some elements are missing');
                                        }
                                    });
                                    </script>
                                    </div>


                                    <div class="m-t-20 text-center">
                                        <button type="button"
                                            name="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                                            id="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                                            class="btn btn-primary submit-btn">Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
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
            <script src="../admin/assets/js/jquery-3.2.1.min.js"></script>
            <script src="../admin/assets/js/popper.min.js"></script>
            <script src="../admin/assets/js/bootstrap.min.js"></script>
            <script src="../admin/assets/js/jquery.slimscroll.js"></script>
            <script src="../admin/assets/js/select2.min.js"></script>
            <script src="../admin/assets/js/app.js"></script>
            <script src="../admin/assets/js/moment.min.js"></script>
            <script src="../admin/assets/js/bootstrap-datetimepicker.min.js"></script>
            <?php include("../admin/included_js.php"); ?>
            <script src="../newjs/in_patients_doctor.js"></script>
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