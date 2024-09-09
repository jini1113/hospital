<?php
include("../connection.php");
include("header.php");
// session_start();
// print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">


<!-- schedule23:20-->

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
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/dataTables.bootstrap4.min.css">
    <style>
        .btn-rounded {
            background-color: #4a4998 !important;
        }
        .txt_header {
            font-size: 15px;
            font-weight: 600;
            color: #72849a !important;
        }

        .txt1 {
            color: black !important;
            border-bottom: 2px solid #3f87f5;
            font-weight: 700;
            border-radius: 0;
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
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Appointment</h4>
                    </div>
                   
                    <!-- <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-edit-schedule.php" class="btn btn btn-primary btn-rounded float-right"><i
                                class="fa fa-plus"></i> Add Schedule</a>
                    </div> -->
                </div>
                <div>
                <table class="travel_tbl">
                    <tr>
                        <td><a id="requeted" class="btn txt1 ">Requested Appointment</a></td>
                        <td><a id="active" class="btn  txt_header">Accpted Appointment</a></td>

                    </tr>
                </table>
            </div><br />
                <div class="row" id="view1"  hidden>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table  mb-0 m-auto text-center " id="tbl_app1">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Doctor Name</th>
                                        <th>Patient Name</th>
                                        <th>Patient Email</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Patient Number</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                               
                                 
                                   
                                   $query_user = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $_SESSION['admin'] . "'");
                                   $row_user = mysqli_fetch_array($query_user);
                                   $doctor_id = $row_user['id'];
                                   
                                   $query = mysqli_query($cnn, "SELECT d.name AS doctor_name,p.name AS patient_name,p.email As patient_email,p.phone_no As patient_number,a.* FROM appointment AS a
                                            JOIN
                                                staff AS d ON a.doctor_id = d.id
                                            JOIN
                                                patients AS  p ON a.patient_id = p.id WHERE doctor_id='$doctor_id' AND a.status IN ('Active', 'Block');");
                                   $cnt = 1;
                                   while ($row = mysqli_fetch_array($query)) {
                                       echo "<tr>";
                                       echo "<td>" . $cnt . "</td>";
                                       echo "<td>" . $row_user['name'] . "</td>"; // Use $row_user['name'] instead of querying again
                                       echo "<td>" . $row['patient_name'] . "</td>";
                                       echo "<td>" . $row['patient_email'] . "</td>";
                                       echo "<td>" . $row['date'] . "</td>";
                                       echo "<td>" . $row['time'] . "</td>";
                                       echo "<td>" . $row['patient_number'] . "</td>";
                                       echo "<td>" . $row['message'] . "</td>";
                                       if ($row['status'] == 'Active') {
                                           echo "<td><button type='button' id='btnActive' name='btnActive' class='btn custom-badge status-green active_block' style='border-radius:4px;' data-id=" . $row['id'] . ">Active</button></td>";
                                        } else {
                                           echo "<td><button type='button' id='btnBlock' name='btnBlock' class='btn custom-badge status-red block_active' style='border-radius:4px;' data-id='" . $row['id'] . "'>Block</button></td>";
                                        
                                       }
                                    //    echo "<td><a href='add-edit-schedule.php?id=" . $row['id'] . "'><button type='button' id='btnEdit' name='btnEdit' title='Edit' class='btn btn-link'><i class='fa fa-pencil-square-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a>";
                                    //    echo "<td><a href='delete-schedule.php?id=" . $row['id'] . "'><button type='button' id='btnDelete' name='btnDelete' title='Delete' class='btn btn-link'><i class='fa fa-trash-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a></td>";

                                       echo "</tr>";
                                       $cnt++;
                                   }
                               
                                    ?>


                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <!-- <th></th> -->
                                        <!-- <th></th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" id="view2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table  mb-0 m-auto text-center " id="tbl_app2">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Doctor Name</th>
                                        <th>Patient Name</th>
                                        <th>Patient Email</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Patient Number</th>
                                        <th>Message</th>
                                        <th>Accepetd request</th>
                                        <th>Rejected request</th>
                                        <!-- <th>fgt</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                               
                                   $query_user = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $_SESSION['admin'] . "'");
                                   $row_user = mysqli_fetch_array($query_user);
                                   $doctor_id = $row_user['id'];
                                   
                                   $query = mysqli_query($cnn, "SELECT d.name AS doctor_name,p.name AS patient_name,p.email As patient_email,p.phone_no As patient_number,a.* FROM appointment AS a
                                            JOIN
                                                staff AS d ON a.doctor_id = d.id
                                            JOIN
                                                patients AS  p ON a.patient_id = p.id WHERE doctor_id='$doctor_id' AND a.status='Pending'");
                                   $cnt = 1;
                                   while ($row = mysqli_fetch_array($query)) {
                                       echo "<tr>";
                                       echo "<td>" . $cnt . "</td>";
                                       echo "<td>" . $row_user['name'] . "</td>"; // Use $row_user['name'] instead of querying again
                                       echo "<td>" . $row['patient_name'] . "</td>";
                                       echo "<td>" . $row['patient_email'] . "</td>";
                                       echo "<td>" . $row['date'] . "</td>";
                                       echo "<td>" . $row['time'] . "</td>";
                                       echo "<td>" . $row['patient_number'] . "</td>";
                                       echo "<td>" . $row['message'] . "</td>";
                                       if ($row['status'] == 'Pending') {
                                           echo "<td><button type='button' id='btnActive' name='btnActive' class='btn custom-badge status-green active_block' style='border-radius:4px;' data-id=" . $row['id'] . ">Approved</button></td>";
                                           echo "<td><button type='button' id='btnBlock' name='btnBlock' class='btn custom-badge status-red block_active' style='border-radius:4px;' data-id='" . $row['id'] . "'>Rejected</button></td>";
                                       } else {
                                        
                                       }
                                    //    echo "<td><a href='add-edit-schedule.php?id=" . $row['id'] . "'><button type='button' id='btnEdit' name='btnEdit' title='Edit' class='btn btn-link'><i class='fa fa-pencil-square-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a>";
                                    //    echo "<td><a href='delete-schedule.php?id=" . $row['id'] . "'><button type='button' id='btnDelete' name='btnDelete' title='Delete' class='btn btn-link'><i class='fa fa-trash-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a></td>";

                                       echo "</tr>";
                                       $cnt++;
                                   }
                               
                                    ?>


                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <!-- <th></th> -->
                                    </tr>
                                </tfoot>
                            </table>
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
        <div id="delete_schedule" class="modal fade delete-modal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="../admin/assets/img/sent.png" alt="" width="50" height="46">
                        <h3>Are you sure want to delete this Schedule?</h3>
                        <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
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
    <script src="../admin/assets/js/jquery.dataTables.min.js"></script>
    <script src="../admin/assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../admin/assets/js/app.js"></script>
    <?php include("included_js.php"); ?>
    <script type="text/javascript" src="../newjs/view_app.js"></script>
    <script>
        $(document).ready(function () {
            $('#tbl_app1').DataTable({
                "pageLength": 10,
                "searching": true,
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "zeroRecords": "No Entry found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 Entry",
                    "infoFiltered": "(filtered from _MAX_ total entries)"
                }
            });
        });
        $(document).ready(function () {
            $('#tbl_app2').DataTable({
                "pageLength": 10,
                "searching": true,
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "zeroRecords": "No Entry found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 Entry",
                    "infoFiltered": "(filtered from _MAX_ total entries)"
                }
            });
        });
        
    </script>
    
</body>


<!-- schedule23:21-->

</html>