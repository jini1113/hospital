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


<!-- add-asset24:09-->

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
        .imgBox {
            border: 2px solid black;
            width: 155px;
            height: 155px;
        }
    </style>
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
                            $query = mysqli_query($cnn, "select * from assets where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3  ">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update Asset ";
                                } else {
                                    echo "Add Asset ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-75 ">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['id'];
                                                } ?>" hidden />
                                                <label>Asset Name</label>
                                                <input type="text" id="txtName" name="txtName" class="form-control"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['name'];
                                                    } ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Serial Number</label>
                                                <input class="form-control" type="number" id="txtS_no" name="txtS_no"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['serial_no'];
                                                    } ?>">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Purchase Date</label>
                                                <input class="form-control" type="date" id="txtP_dte" name="txtP_dte"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['pur_date'];
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Purchase From</label>
                                                <input class="form-control" type="text" id="txtP_from" name="txtP_from"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['pur_from'];
                                                    } ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Manufacturer</label>
                                                <input class="form-control" type="text" id="txtMan" name="txtMan" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['manufacture'];
                                                } ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Model</label>
                                                <input class="form-control" type="text" id="txtModel" name="txtModel"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['model'];
                                                    } ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <input class="form-control" type="text" id="txtSupplier"
                                                    name="txtSupplier" value="<?php if (isset($_GET['id'])) {
                                                        echo $row['supplier'];
                                                    } ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Warranty(Months)</label>
                                                <input class="form-control" type="number" id="txtWar" name="txtWar"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['warranty'];
                                                    } ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input class="form-control" type="number" id="txtPrice" name="txtPrice"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['price'];
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

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" id="txtDes" name="txtDes"><?php if (isset($_GET['id'])) {
                                                    echo $row['description'];
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
                            <!-- insert code -->
                            <?php
                            if (isset($_POST['btnSubmit'])) {
                                $name = $_POST['txtName'];
                                $serial = $_POST['txtS_no'];
                                $pur_date = $_POST['txtP_dte'];
                                $pur_from = $_POST['txtP_from'];
                                $manufacture = $_POST['txtMan'];
                                $model = $_POST['txtModel'];
                                $supplier = $_POST['txtSupplier'];
                                $warranty = $_POST['txtWar'];
                                $price = $_POST['txtPrice'];
                                $description = $_POST['txtDes'];

                                $cols = "name,serial_no,pur_date,pur_from,manufacture, model, supplier, warranty, price, description ,status";
                                $values = "'$name','$serial', '$pur_date', '$pur_from', '$manufacture', '$model', '$supplier','$warranty', '$price', '$description', 'Active'";

                                if (isset($_FILES['txtImg']) && $_FILES['txtImg']['name'] != "") {
                                    $image_name = $_FILES['txtImg']['name'];
                                    move_uploaded_file($_FILES['txtImg']['tmp_name'], '../image/' . $image_name);
                                    $cols .= ", image";
                                    $values .= ", '$image_name'";
                                }

                                $query = mysqli_query($cnn, "INSERT INTO assets ($cols) VALUES ($values)");

                                if ($query) {
                                    echo "<script>window.location.replace('assets.php');</script>";
                                } else {
                                    echo "<script>alert('Some error occurred. Please try again.');</script>";
                                }

                            }
                            // update code
                            if (isset($_POST['btnUpdate'])) {
                                $id = $_POST['txtUId'];
                                $name = $_POST['txtName'];
                                $serial = $_POST['txtS_no'];
                                $pur_date = $_POST['txtP_dte'];
                                $pur_from = $_POST['txtP_from'];
                                $manufacture = $_POST['txtMan'];
                                $model = $_POST['txtModel'];
                                $supplier = $_POST['txtSupplier'];
                                $warranty = $_POST['txtWar'];
                                $price = $_POST['txtPrice'];
                                $description = $_POST['txtDes'];

                                $cols = "name='" . $name . "',serial_no='" . $serial . "',pur_date='" . $pur_date . "',pur_from='" . $pur_from . "',manufacture='" . $manufacture . "',model='" . $model . "'
                                ,supplier='" . $supplier . "',warranty='" . $warranty . "',price='" . $price . "',description='" . $description . "'";

                                if (isset($_FILES['txtImg']) && !empty($_FILES['txtImg']['name'])) {
                                    $query_chk = mysqli_query($cnn, "select * from staff where id=" . $id . "");
                                    $row_chk = mysqli_fetch_array($query_chk);
                                    if (!empty($row_chk['image']) && $row_chk['image'] != "" && file_exists("../image/" . $row_chk['image'])) {
                                        unlink('../image/' . $row_chk['image']);
                                    }
                                    move_uploaded_file($_FILES['txtImg']['tmp_name'], "../image/" . $_FILES['txtImg']['name']);
                                    $cols .= ",image='" . $_FILES['txtImg']['name'] . "'";
                                }
                                $query = mysqli_query($cnn, "update assets set " . $cols . " where id=" . $id . "");
                                if ($query > 0) {
                                    echo "<script>window.location.replace('assets.php');</script>";
                                } else {
                                    echo "<script>alert('Some error occured.Please try again');</script>";
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
            <script src="assets/js/moment.min.js"></script>
            <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
            <script src="assets/js/app.js"></script>
            <?php include("included_js.php"); ?>
        <script src="../newjs/asset.js"></script>
</body>


<!-- add-asset24:09-->

</html>