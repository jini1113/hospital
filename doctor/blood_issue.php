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
                        <h4 class="page-title">Blood Donor</h4>
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-edit-schedule.php" class="btn btn btn-primary btn-rounded float-right"><i
                                class="fa fa-plus"></i> Add Schedule</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table  mb-0 m-auto text-center " id="tbl_schedule">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Doctor Name</th>
                                        <th>Days</th>
                                        <th>From_Time</th>
                                        <th>To_Time</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                               
                                 
                                   
                                   $query_user = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $_SESSION['admin'] . "'");
                                   $row_user = mysqli_fetch_array($query_user);
                                   $doctor_id = $row_user['id'];
                                   
                                   $query = mysqli_query($cnn, "SELECT * FROM d_schedule WHERE doctor_id='$doctor_id'");
                                   $cnt = 1;
                                   while ($row = mysqli_fetch_array($query)) {
                                       echo "<tr>";
                                       echo "<td>" . $cnt . "</td>";
                                       echo "<td>" . $row_user['name'] . "</td>"; // Use $row_user['name'] instead of querying again
                                       echo "<td>" . $row['days'] . "</td>";
                                       echo "<td>" . $row['from_time'] . "</td>";
                                       echo "<td>" . $row['to_time'] . "</td>";
                                       echo "<td>" . $row['message'] . "</td>";
                                       if ($row['status'] == 'Active') {
                                        // echo "<td>" . $row['id'] . "</td>";
                                        echo "<td><button type='button' id='btnActive' name='btnActive' class='btn btn-success active_block'  style='border-radius:4px;' data-id=" . $row['id'] . ">Active</button></td>";
                                    } else {
                                        echo "<td><button type='button' id='btnBlock' name='btnBlock' class='btn btn-danger block_active' style='border-radius:4px;' data-id='" . $row['id'] . "'>Block</button></td>";
                                    }
                                       echo "<td><a href='add-edit-schedule.php?id=" . $row['id'] . "'><button type='button' id='btnEdit' name='btnEdit' title='Edit' class='btn btn-link'><i class='fa fa-pencil-square-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a>";
                                       echo "<a href='delete-schedule.php?id=" . $row['id'] . "'><button type='button' id='btnDelete' name='btnDelete' title='Delete' class='btn btn-link' data-target='#delete-modal' data-toggle='modal'><i class='fa fa-trash-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a></td>";

                                       echo "</tr>";
                                       $cnt++;
                                   }
                               
                                    ?>


                                    </tr>
                                </tbody>
                                <!-- <tfoot>
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
                                        <th></th>
                                    </tr>
                                </tfoot> -->
                            </table>
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
    <script type="text/javascript" src="../newjs/add-edit-schedule.js"></script>
    <script>
        $(document).ready(function () {
            $('#tbl_schedule').DataTable({
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