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
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($cnn, "SELECT * FROM b_patients WHERE id=" . $id);
    $patient_data = mysqli_fetch_array($query);

    // Populate form fields with current values

    $current_bed_no = $patient_data['bed_id'];
    $current_ward = $patient_data['ward_id'];
}
?>

<!DOCTYPE html>
<html lang="en">

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

</head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <?php
                        if (isset($_GET['id'])) {
                            $query = mysqli_query($cnn, "select * from b_patients where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3  ">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update Patients ";
                                } else {
                                    echo "Add Bed-Patients ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-75 ">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <form method="POST" id="frm" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input id="txtUId" name="txtUId" value="<?php echo $row['id']; ?>"
                                                    hidden />
                                                <label>Patient Name</label>
                                                <select class="select" id="txtPatient" name="txtPatient">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $patient_query = mysqli_query($cnn, "SELECT * FROM patients");
                                                    while ($patient = mysqli_fetch_array($patient_query)) {
                                                        $selected = ($current_patient == $patient['id']) ? "selected" : "";
                                                        echo "<option value='" . $patient['id'] . "' $selected>" . $patient['name'] . "</option>";
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
                                                    $wards_query = mysqli_query($cnn, "SELECT * FROM ward");
                                                    while ($ward = mysqli_fetch_array($wards_query)) {
                                                        $selected = ($current_ward == $ward['id']) ? "selected" : "";
                                                        echo "<option value='" . $ward['id'] . "' $selected>" . $ward['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Bed No.</label>
                                                <select id="txtBno" name="txtBno" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (isset($current_bed_id)) {
                                                        $bed_query = mysqli_query($cnn, "SELECT * FROM bed WHERE ward_id=" . $current_ward);
                                                        while ($bed = mysqli_fetch_array($bed_query)) {
                                                            $selected = ($current_bed_id == $bed['id']) ? "selected" : "";
                                                            echo "<option value='" . $bed['id'] . "' $selected>" . $bed['name'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Admit-Date</label>
                                                <input type="date" class="form-control" id="txtAdate" name="txtAdate"
                                                    value="<?php echo $row['a_date']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Discharge-Date</label>
                                                <input type="date" class="form-control" id="txtDate" name="txtDate"
                                                    value="<?php echo $row['d_date']; ?>">
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
                                    <!-- <div class="m-t-20 text-center">
                                        <button type="submit" name="btnSubmit"
                                            class="btn btn-primary submit-btn">Save</button>
                                    </div> -->
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

</body>


<!-- add-appointment24:07-->

</html>