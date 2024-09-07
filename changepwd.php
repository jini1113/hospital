<?php
include("connection.php");
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


<!-- login23:11-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="admin/assets/img/favicon.ico">
    <title>Hospital Management System</title>
    <link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="admin/assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="admin/assets/css/style.css">
    <style>
        .input-icon-right {
            position: relative;
        }

        .input-icon-right input {
            padding-right: 2.5rem;
        }

        .input-icon-right .icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .field-icon {
            font-size: 19px;
            float: right;
            margin-right: 8px !important;
            margin-bottom: 25px !important;
            /* / margin-left: -25px; / */
            margin-top: -33px;
            position: relative;
            z-index: 2;
            cursor: pointer;
        }

        .inpt {
            border-top: 0;
            border-left: 0;
            border-right: 0;
            border-radius: 0;
            border-bottom: 2px solid #0DB8DE;
        }

        .account-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .account-row {
            display: flex;
            width: 100%;
            max-width: 1200px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .image-column,
        .form-column {
            flex: 1;
            padding: 30px;
        }

        .image-column img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin-left: 8%;
        }

        .account-box {
            border: none;
        }

        .account-logo img {
            background-color: #f0f0f0;
            /* Change this to your desired color */
            padding: 15px;
            border-radius: 5px;
        }


        @media (max-width: 768px) {
            .account-row {
                flex-direction: column;
            }
        }
    </style>
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

    <body class="frm">
    <div class="main-wrapper account-wrapper">
        <div class="account-row">
            <div class="image-column">
                <img src="admin/assets/img/img7.jpg" alt="Hospital Image" />
            </div>
            <div class="form-column">
                <div class="account-box">
                    <form id="frm" class="loginfrm">
                        <div class="account-logo ">
                            <a href="index-2.html"><i class=" hospital-alt"></i>
                                <h3 style="color:#4a4998;">Change Password</h3>
                            </a>
                        </div>
                        <div class="form-group">
                            <label><b style="color:#4a4998;">Old Password</b></label>
                            <input type="password" id="txtFCur" name="txtFCur" class="form-control"  placeholder="**********">
                            <span toggle="#txtFCur" class="fa fa-fw fa-eye-slash field-icon toggle-oldpassword"></span>
                            <span id="errPass"></span>
                        </div>
                        <div class="input-icon-right">
                            <label><b style="color:#4a4998;">New Password</b></label>
                            <input type="password" name="txtFNew" id="txtFNew" class="form-control form-control-lg mb-2"
                                    placeholder="**********" />
                            <span toggle="#txtFNew" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                            <span id="errPass"></span>
                        </div><br>
                        <div class="input-icon-right">
                            <label><b style="color:#4a4998;">Confirm Password</b></label>
                            <input type="password" name="txtFCon" id="txtFCon" class="form-control form-control-lg mb-2"
                                    placeholder="**********" />
                                <span toggle="#txtFCon" class="fa fa-fw fa-eye-slash field-icon toggle-confirmpassword"></span>
                            <span id="errPass"></span>
                        </div><br>
                        <!-- <div class="form-group  ">
                            <a href="forgot-password.html">Forgot your password?</a>
                        </div> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-center">
                                    <button type="button" class="btn account-btn" id="changpwd" name="changpwd"
                                        style="background-color:#4a4998;color:#fff;">Change</button>
                                </div>
                            </div>
                       
                        <div class="col-md-6">
                        <div class="form-group text-center">
                            <button class="btn account-btn" id="cancelButton"
                                style="background-color:#A8A7D5;color:#fff;">Cancel</button>
                        </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- <script src="admin/assets/js/jquery-3.2.1.min.js"></script> -->
    <script src="admin/assets/js/popper.min.js"></script>
    <script src="admin/assets/js/bootstrap.min.js"></script>
    <script src="admin/assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            $('#cancelButton').click(function() {
                window.location.href = 'doctor/index.php';
            });
        }); 
        $(".toggle-password").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-oldpassword").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-confirmpassword").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        </script>
    <script src="newjs/change_password.js"></script>
    <?php include("admin/included_js.php"); ?>
</body>


<!-- login23:12-->

</html>