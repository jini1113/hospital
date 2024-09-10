<?php
include("../connection.php");
include("header.php");
session_start();
if (
    !isset($_SESSION["admin"]) || $_SESSION['admin'] == NULL ||
    $_SESSION["admin"] == ""
) {
    header("Location:../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- add-doctor24:06-->

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
                            $query = mysqli_query($cnn, "select * from staff where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3  ">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update Doctor ";
                                } else {
                                    echo "Add Doctor ";
                                }
                                ?>
                    </div>
                </div>
                <div class="card pt-5 pb-5 m-auto w-75 ">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 m-auto">
                            <form class="" method="post" enctype="multipart/form-data" id="frm">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                        <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['id'];
                                                } ?>" hidden />
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input type="text" id="txtName" name="txtName" class="form-control"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['name'];
                                                    } ?>" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input class="form-control" type="email" id="txtMail" name="txtMail" value="<?php if (isset($_GET['id'])) {
                                                        echo $row['email'];

                                                    } ?>" <?php if (isset($_GET['id'])) {
                                                         echo "readonly";

                                                     } ?>>
                                        </div>
                                    </div>
                                    <div class=" col-6">
                                        <div class="form-group">
                                            <label>Gender:</label>
                                            <select id="txtGen" name="txtGen" class="form-control">
                                                <option value="">Select</option>
                                                <option value="male" <?php if (isset($_GET['id']) && $row['gender'] == "male") {
                                                    echo " selected";
                                                } ?>>Male</option>
                                                <option value="female" <?php if (isset($_GET['id']) && $row['gender'] == "female") {
                                                    echo " selected";
                                                } ?>>Female</option>
                                                <option value="other" <?php if (isset($_GET['id']) && $row['gender'] == "other") {
                                                    echo " selected";
                                                } ?>>Other</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone </label>
                                            <input class="form-control" type="text" id="txtPhone" name="txtPhone"  value="<?php if (isset($_GET['id'])) {
                                                        echo $row['phone_no'];
                                                    } ?>" >
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" class="form-control " name="txtDob" id="txtDob" value="<?php if (isset($_GET['id'])) {
                                                        echo $row['dob'];
                                                    } ?>" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select id="txtDep" name="txtDep"class="form-control" >
                                                <option value="">Select</option>
                                                <?php
                                                $query_dep = mysqli_query($cnn, "SELECT * FROM department");
                                                while ($row_dep = mysqli_fetch_array($query_dep)) {
                                                    echo "<option value='" . $row_dep['id'] . "'";
                                                    if (isset($_GET['id'])) {
                                                        // Assuming $row is defined earlier and contains the data of the item being edited
                                                        if ($row['department_id'] == $row_dep['id']) {
                                                            echo " selected";
                                                        }
                                                    }
                                                    echo ">" . $row_dep['name'] . "</option>";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea type="text" name="txtAdd" id="txtAdd" class="form-control"><?php if (isset($_GET['id'])) {
                                                    echo $row['address'];
                                                } ?></textarea>
                                                </div>
                                            </div>
                                            <div class=" col-sm-6">
                                                <div class="form-group">
                                                    <label>State :</label>
                                                    <select id="txtState" name="txtState" class="form-control">
                                                        <option value="">Select</option>
                                                        <?php
                                                        $query_cat = mysqli_query($cnn, "select * from tbl_states ");
                                                        while ($row_cat = mysqli_fetch_array($query_cat)) {
                                                            echo "<option value=" . $row_cat['id'] . "";
                                                            if (isset($_GET['id'])) {
                                                                if ($row['state_id'] == $row_cat['id']) {
                                                                    echo " selected";
                                                                }
                                                            }
                                                            echo " >" . $row_cat['name'] . "</option>";
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>City :</label>
                                                    <select id="txtCity" name="txtCity" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Joining Date <span class="text-danger">*</span></label>
                                                    <input class="form-control " type="date" name="txtJob" id="txtJob" value="<?php if (isset($_GET['id'])) {
                                                        echo $row['job'];
                                                    } ?>">

                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Avatar</label>
                                                    <div class="profile-upload">
                                                        <div class="upload-img">
                                                            <img alt="" src="assets/img/user.jpg">
                                                        </div>
                                                        <div class="upload-input">
                                                            <input type="file" class="form-control" id="txtImg"
                                                                name="txtImg" accept="image/*">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6"></div>
                                        <div class="col-sm-6">
                                            <div class="imgBox">
                                                <img src="<?php if (isset($_GET['id'])) {
                                                    echo "../image/" . $row['image'];
                                                } ?>" id="txtImport" name="txtImport" width="150px" name="100px" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                        <div class="m-t-20 text-center">
                                        <button type="submit"
                                            name="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                                            id="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                                            class="btn btn-primary submit-btn">Save
                                            changes</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <!-- insert code -->
                        <?php
                        if (isset($_POST['btnSubmit'])) {
                            $name = $_POST['txtName'];
                            $department = $_POST['txtDep'];
                            $add = $_POST['txtAdd'];
                            $state = $_POST['txtState'];
                            $city = $_POST['txtCity'];
                            $gen = $_POST['txtGen'];
                            $dob = $_POST['txtDob'];
                            $job = $_POST['txtJob'];
                            $email = $_POST['txtMail'];
                            $phone = $_POST['txtPhone'];

                            // Generate random password
                            $str_pass = "ABCDEFGHIJKLMNOPQRSTUSVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                            $pass = "";
                            for ($i = 0; $i < 7; $i++) {
                                $rd = rand(0, strlen($str_pass) - 1);
                                $pass .= $str_pass[$rd];
                            }
                            $str_password = $pass;

                            $chk_user = mysqli_query($cnn, "SELECT COUNT(*) FROM staff WHERE email = '$email'");
                            $row_user = mysqli_fetch_array($chk_user);

                            if ($row_user[0] > 0) {
                                echo "<script>alert('This email id is already registered. Please register with a new email id');</script>";
                            } else {
                                $enc_pass = password_hash($pass, PASSWORD_DEFAULT);

                                $cols = "role,department_id,name, email, password, phone_no, dob,job, address, state_id, gender, status";
                                $values = "'Doctor','$department','$name', '$email', '$enc_pass', '$phone', '$dob', '$job','$add', '$state', '$gen', 'Active'";

                                if (isset($_FILES['txtImg']) && $_FILES['txtImg']['name'] != "") {
                                    $image_name = $_FILES['txtImg']['name'];
                                    move_uploaded_file($_FILES['txtImg']['tmp_name'], '../image/' . $image_name);
                                    $cols .= ", image";
                                    $values .= ", '$image_name'";
                                }

                                if (!empty($city)) {
                                    $cols .= ", city_id";
                                    $values .= ", '$city'";
                                } else {
                                    $cols .= ", city_id";
                                    $values .= ", '0'";
                                }

                                $query = mysqli_query($cnn, "INSERT INTO staff ($cols) VALUES ($values)");

                                if ($query) {
                                    $to = $email;
                                    $subject = "Login Details";
                                    $message = "<p>Dear $name,</p>
                                                <p>You are registered as a Doctor in our portal successfully.</p>
                                                <p>Your credential details for login to the Hospital Management System portal are below:</p>
                                                <p><table border='2'><tr><td style='padding:3px;'>Email:</td><td style='padding:3px;'>$email</td></tr><tr><td style='padding:3px;'>Password:</td><td style='padding:3px;'>$str_password</td></tr></table></p>";
                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                    $headers .= "From: Hospital Management System";

                                    mail($to, $subject, $message, $headers);

                                    echo "<script>window.location.replace('doctors.php');</script>";
                                } else {
                                    echo "<script>alert('Some error occurred. Please try again.');</script>";
                                }
                            }
                        }
                        // update code
                        if (isset($_POST['btnUpdate'])) {
                            $id = $_POST['txtUId'];
                            $name = $_POST['txtName'];
                            $department = $_POST['txtDep'];
                            $add = $_POST['txtAdd'];
                            $state = $_POST['txtState'];
                            $city = $_POST['txtCity'];
                            $gen = $_POST['txtGen'];
                            $dob = $_POST['txtDob'];
                            $job = $_POST['txtJob'];
                            $email = $_POST['txtMail'];
                            $phone = $_POST['txtPhone'];

                            $cols = "name='" . $name . "',phone_no=" . $phone . ",department_id=" . $department . "";
                            if (isset($_FILES['txtImg']) && !empty($_FILES['txtImg']['name'])) {
                                $query_chk = mysqli_query($cnn, "select * from staff where id=" . $id . "");
                                $row_chk = mysqli_fetch_array($query_chk);
                                if (!empty($row_chk['image']) && $row_chk['image'] != "" && file_exists("../image/" . $row_chk['image'])) {
                                    unlink('../image/' . $row_chk['image']);
                                }
                                move_uploaded_file($_FILES['txtImg']['tmp_name'], "../image/" . $_FILES['txtImg']['name']);
                                $cols .= ",image='" . $_FILES['txtImg']['name'] . "'";
                            }
                            $cols .= ",address='" . $add . "',state_id=" . $state . "";

                            if ((isset($_POST['txtCity'])) && (!empty($_POST['txtCity']))) {
                                $cols .= ",city_id=" . $city . "";
                            } else {
                                $cols .= ",city_id='0'";
                            }
                            $cols .= ",gender='" . $gen . "',dob='" . $dob . "',job='" . $job . "'";
                            $query = mysqli_query($cnn, "update staff set " . $cols . " where id=" . $id . "");
                            if ($query > 0) {
                                echo "<script>window.location.replace('doctors.php');</script>";
                            } else {
                                echo "<script>alert('Some error occured.Please try again');</script>";
                            }
                        }
                        ?>
                    </div>
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
                                        <span class="message-content">Lorem ipsum dolor sit amet, consectetur
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
    <?php include("included_js.php"); ?>
    <script src="../newjs/doctor.js"></script>
</body>


<!-- add-doctor24:06-->

</html>