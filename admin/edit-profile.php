<?php
include("../connection.php");
session_start();
if (
    !isset($_SESSION["admin"]) || $_SESSION['admin'] == NULL ||
    $_SESSION["admin"] == ""
) {
    header("Location:../login.php");
}
if (isset($_GET['what']) && $_GET['what'] == "retUCity") {
    include("../connection.php"); // Make sure this path is correct
    $state_id = $_POST['id'];
    $admin_id = $_POST['main'];

    $response = array('cities' => array(), 'selected_city_id' => null);

    // Fetch cities for the given state
    $query = mysqli_query($cnn, "SELECT * FROM city WHERE state_id = $state_id");
    while ($row = mysqli_fetch_assoc($query)) {
        $response['cities'][] = $row;
    }

    // Fetch the admin's current city_id
    $query_admin = mysqli_query($cnn, "SELECT city_id FROM staff WHERE id = $admin_id");
    if ($row_admin = mysqli_fetch_assoc($query_admin)) {
        $response['selected_city_id'] = $row_admin['city_id'];
    }

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- edit-profile23:03-->

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
    <?php include("header.php"); ?>

    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <?php
                if (isset($_SESSION['admin'])) {
                    $query = mysqli_query($cnn, "select * from staff where email='" . $_SESSION['admin'] . "'");
                    $row = mysqli_fetch_array($query);
                }
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Edit Profile</h4>
                    </div>
                </div>
                <form method="POST" id="frm" enctype="multipart/form-data">
                    <div class="card-box">
                        <h3 class="card-title">Basic Informations</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap imgBox">
                                    <img src="<?php
                                    if (isset($_SESSION['admin'])) {
                                        // Check if image is set and not empty
                                        if (!empty($row['image'])) {
                                            echo "../image/" . $row['image'];
                                        } else {
                                            echo "assets/img/user.jpg"; // Default image
                                        }
                                    } else {
                                        echo "assets/img/user.jpg style='width:50%'"; // Default image
                                    }
                                    ?>" id="txtImport" name="txtImport" width="200%" />
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input class="upload" type="file" id="image" name="image" accept="image/*">
                                    </div>
                                </div>
                                <!-- <div class="profile-img-wrap">
                                    <img class="inline-block" src="assets/img/user.jpg" alt="user">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input class="upload" type="file">
                                    </div>
                                </div> -->
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['id'];
                                                } ?>" hidden />
                                                <label>Role</label>
                                                <input type="text" id="txtRole" name="txtRole" class="form-control"
                                                    readonly value="<?php if (isset($_SESSION['admin'])) {
                                                        echo $row['role'];
                                                    } ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" id="txtName" name="txtName" class="form-control"
                                                    value="<?php if (isset($_SESSION['admin'])) {
                                                        echo $row
                                                        ['name'];
                                                    } ?>" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label>Date of Birth</label>
                                                <input type="date" class="form-control " name="txtDob" id="txtDob"
                                                    value="<?php if (isset($_SESSION['admin'])) {
                                                        echo $row
                                                        ['dob'];
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select id="txtGen" name="txtGen" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-box">
                        <h3 class="card-title">Contact Informations</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="focus-label">Address</label>
                                    <textarea type="text" name="address" id="address" class="form-control"><?php if (isset($_SESSION['admin'])) {
                                        echo $row['address'];
                                    } ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>State </label>
                                    <select id="txtState" name="txtState" class="form-control">
                                        <option value="">Select</option>
                                        <?php
                                        $query_cat = mysqli_query($cnn, "select * from tbl_states");
                                        while ($row_cat = mysqli_fetch_array($query_cat)) {
                                            echo "<option value='" . $row_cat['id'] . "'";
                                            if (isset($_SESSION['admin'])) {
                                                if ($row['state_id'] == $row_cat['id']) {
                                                    echo " selected";
                                                }
                                            }
                                            echo ">" . $row_cat['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>City </label>
                                    <select id="txtCity" name="txtCity" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" id="txtMail" name="txtMail" readonly class="form-control" value="<?php if (isset($_SESSION['admin'])) {
                                        echo $row['email'];

                                    } ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Phone </label>
                                    <input type="number" id="txtPhone" name="txtPhone" class="form-control" value="<?php if (isset($_SESSION['admin'])) {
                                        echo $row['phone_no'];
                                    } ?>" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" name="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                            id="<?php echo isset($_GET['id']) ? 'btnUpdate' : 'btnSubmit'; ?>"
                            class="btn btn-primary submit-btn">Save
                            changes</button>
                    </div>
                </form>
            </div>
            <?php
            // update code
            if (isset($_POST['btnSubmit'])) {
                $id = $_POST['txtUId'];
                $role = $_POST['txtRole'];
                $name = $_POST['txtName'];
                $dob = $_POST['txtDob'];
                $gender = $_POST['txtGen'];
                $address = $_POST['address'];
                $email = $_POST['txtMail'];
                $phone_no = $_POST['txtPhone'];
                $state = $_POST['txtState'];
                $city = $_POST['txtCity'];
                $cols = "name='" . $name . "', phone_no='" . $phone_no . "', address='" . $address . "', dob='" . $dob . "', gender='" . $gender . "', state_id='" . $state . "', city_id='" . $city . "'";

                // Handle image upload
                if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                    $query_chk = mysqli_query($cnn, "select * from staff where email='" . $email . "'");
                    $row_chk = mysqli_fetch_array($query_chk);
                    if (!empty($row_chk['image']) && $row_chk['image'] != "" && file_exists("../image/" . $row_chk['image'])) {
                        unlink('../image/' . $row_chk['image']);
                    }
                    move_uploaded_file($_FILES['image']['tmp_name'], "../image/" . $_FILES['image']['name']);
                    $cols .= ",image='" . $_FILES['image']['name'] . "'";
                }

                // Check and set city_id
                if (!empty($city)) {
                    $cols .= ", city_id='" . $city . "'";
                } else {
                    $cols .= ", city_id='0'";
                }

                // Update the staff record
                $query = mysqli_query($cnn, "UPDATE staff SET " . $cols . " WHERE email='" . $email . "'");
                if ($query) {
                    echo "<script>window.location.replace('index.php');</script>";
                } else {
                    echo "<script>alert('Some error occurred. Please try again.')</script>";
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
    <script>
        var adminId = <?php echo json_encode($row['id']); ?>;
        var currentGender = <?php echo json_encode($row['gender']); ?>;
    </script>
    <?php include("included_js.php"); ?>
    <script src="../newjs/profile.js"></script>

</body>


<!-- edit-profile23:05-->

</html>