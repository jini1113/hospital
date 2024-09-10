<?php
include("../connection.php");
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System - Holidays</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <style>
        .btn-rounded {
            background-color: #4a4998 !important;
        }
    </style>
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <style>
        .holiday-disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-5 col-5">
                        <h4 class="page-title">Holidays 2024</h4>
                    </div>
                    <div class="col-sm-7 col-7 text-right m-b-30">
                        <a href="add-edit-holiday.php" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i>
                            Add
                            Holiday</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 text-center" id="tbl_holiday">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Day</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($cnn, "SELECT * FROM holidays");
                                    $cnt = 1;
                                    $today = new DateTime();
                                    $tomorrow = new DateTime('tomorrow');
                                    while ($row = mysqli_fetch_array($query)) {
                                        $date = new DateTime($row['date']);
                                        $dayOfWeek = $date->format('l'); // Get the full name of the day
                                        $isDisabled = $date < $tomorrow ? 'holiday-disabled' : '';

                                        echo "<tr class='$isDisabled'>";
                                        echo "<td>" . $cnt . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $date->format('d-m-Y') . "</td>";
                                        echo "<td>" . $dayOfWeek . "</td>";
                                        if ($row['status'] == 'Active') {
                                            echo "<td><button type='button' id='btnActive' name='btnActive' class='btn custom-badge status-green active_block' style='border-radius:4px;' data-id=" . $row['id'] . ">Active</button></td>";
                                        } else {
                                            echo "<td><button type='button' id='btnBlock' name='btnBlock' class='btn custom-badge status-red block_active' style='border-radius:4px;' data-id='" . $row['id'] . "'>Block</button></td>";
                                        }
                                        if ($isDisabled) {
                                            echo "<td><button type='button' class='btn btn-link' disabled><i class='fa fa-pencil-square-o' aria-hidden='true' style='font-size:22px;font-weight:600;color:gray;'></i></button></td>";
                                        } else {
                                            echo "<td><a href='add-edit-holiday.php?id=" . $row['id'] . "'><button type='button' id='btnEdit' name='btnEdit' title='Edit' class='btn btn-link'><i class='fa fa-pencil-square-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a></td>";
                                        }
                                        echo "</tr>";
                                        $cnt++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- DataTables JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../newjs/holiday.js"></script>
    <script>
        $(document).ready(function () {
            $('#tbl_holiday').DataTable({
                "pageLength": 10,
                "searching": true,
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "zeroRecords": "No holidays found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ holidays",
                    "infoEmpty": "Showing 0 to 0 of 0 holidays",
                    "infoFiltered": "(filtered from _MAX_ total holidays)"
                }
            });
        });
    </script>
        <?php include("included_js.php"); ?>

</body>

</html>