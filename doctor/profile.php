<?php
include("../connection.php");
// session_start();
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
    <link rel="shortcut icon" type="image/x-icon" href="../admin/assets/img/favicon.ico">
    <title>Hospital Management System - Holidays</title>
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
                        if (isset($_SESSION['admin'])) {
                            $query = mysqli_query($cnn, "select * from staff where email='" . $_SESSION['admin'] . "'");
                            $row = mysqli_fetch_array($query);
                            // $query_role=mysqli_query($cnn,"select * from role where id=".$row['role_id']."");
                            // $row_role=mysqli_fetch_array($query_role);
                        }
                        ?>
                        
                        <div class="title ">
                            <h2 class="h3  ">
                            Profile
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-75 ">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <form method="post" enctype="multipart/form-data" id="frm">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                    echo $row['id'];
                                } ?>" hidden />
                                <label>Role:</label>
                                <input type='text' name='role' id="role" class="form-control" readonly
                                    value="<?php if (isset($_SESSION['admin'])) {
                                        echo $row['role'];
                                    } ?>">
                            </div>

                            <div class="form-group">
                                <label>Name :</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php if (isset($_SESSION['admin'])) {
                                    echo $row
                                    ['name'];
                                } ?>" />
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="imgBox">
                                <img src="<?php
                                if (isset($_SESSION['admin'])) {
                                    // Check if image is set and not empty
                                    if (!empty($row['image'])) {
                                        echo "../image/" . $row['image'];
                                    } else {
                                        echo "../image/defult.png"; // Default image
                                    }
                                } else {
                                    echo "../image/defult.png style='width:50%'"; // Default image
                                }
                                ?>" id="txtImport" name="txtImport" width="50%" name="50%" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email-id:</label>
                                <input type="email" id="email" name="email" readonly class="form-control" value="<?php if (isset($_SESSION['admin'])) {
                                    echo $row['email'];

                                } ?>" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Image :</label>
                                <input type="file" id="image" name="image" accept="image/*" width="200%" height="200%"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea type="text" name="address" id="address" class="form-control"><?php if (isset($_SESSION['admin'])) {
                                    echo $row['address'];
                                } ?></textarea>
                            </div>
                        </div>
                        <div class=" col-sm-6">
                            <div class="form-group">
                                <label>Phone No :</label>
                                <input type="number" id="phone_no" name="phone_no" class="form-control" value="<?php if (isset($_SESSION['admin'])) {
                                    echo $row['phone_no'];
                                } ?>" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary submit-btn">Save</button>
                        <a href="index.php" class="btn btn-primary submit-btn" style="background-color:#A8A7D5; color:#fff;margin-left:20px;">Back</a>
                    </div>
                                </form>
                                <?php
                // update code
                if (isset($_POST['btnSubmit'])) {
                    $role = $_POST['role'];
                    $name = $_POST['name'];
                    $address = $_POST['address'];
                    $email = $_POST['email'];
                    $phone_no = $_POST['phone_no'];
                    $cols = "name='" . $name . "',phone_no=" . $phone_no . ",address='" . $address . "'";
                    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                        $query_chk = mysqli_query($cnn, "select * from staff where email='" . $email . "'");
                        $row_chk = mysqli_fetch_array($query_chk);
                        if (!empty($row_chk['image']) && $row_chk['image'] != "" && file_exists("../image/" . $row_chk['image'])) {
                            unlink('../image/' . $row_chk['image']);
                        }
                        move_uploaded_file($_FILES['image']['tmp_name'], "../image/" . $_FILES['image']['name']);
                        $cols .= ",image='" . $_FILES['image']['name'] . "'";
                    }

                    $query = mysqli_query($cnn, "update staff set " . $cols . " where email='" . $email . "'");
                    if ($query > 0) {
                        echo "<script>window.location.replace('index.php');</script>";
                    } else {
                        echo "<script>alert('Some error occured.Please try agaian');</script>";
                    }
                }

                                ?>
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
            <script src="../admin/assets/js/moment.min.js"></script>
            <script src="../admin/assets/js/bootstrap-datetimepicker.min.js"></script>
            <script src="../admin/assets/js/app.js"></script>
            <script>
                $(document).ready(function() {
                    $('#cancelButton').click(function() {
                        window.location.href = 'index.php';
                    });
                });
            </script>
                <script src="../newjs/profile_doctor.js"></script>
                <?php include("../admin/included_js.php"); ?>
</body>


<!-- add-schedule24:07-->

</html>