<?php
include("../connection.php");

// Handle AJAX requests
if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Sanitize inputs to prevent SQL injection
    $id = mysqli_real_escape_string($cnn, $id);
    $status = mysqli_real_escape_string($cnn, $status);

    // Update query to change the status
    $query = mysqli_query($cnn, "UPDATE leaves SET status = '$status' WHERE id = $id");

    if ($query) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($cnn)]);
    }
    exit;
}

include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="../admin/assets/img/favicon.ico">
    <title>Hospital Management System</title>
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/assets/css/style.css">
    <style>
        .btn-rounded {
            background-color: #4a4998 !important;
        }
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
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Holidays</h4>
                    </div>
                   
                    
                </div>
               <br>
            <!-- Active-block -->
       
                <!-- Requested-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table  mb-0 m-auto text-center " id="tbl_app2">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Day</th>
                                        <!-- <th>fgt</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                               
                                //    $query_user = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $_SESSION['admin'] . "'");
                                //    $row_user = mysqli_fetch_array($query_user);
                                //    $doctor_id = $row_user['id'];
                                   
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
                                        <!-- <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
   
</head>
<div class="sidebar-overlay" data-reff=""></div>
    <script src="../admin/assets/js/jquery-3.2.1.min.js"></script>
    <script src="../admin/assets/js/popper.min.js"></script>
    <script src="../admin/assets/js/bootstrap.min.js"></script>
    <script src="../admin/assets/js/jquery.dataTables.min.js"></script>
    <script src="../admin/assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../admin/assets/js/jquery.slimscroll.js"></script>
    <script src="../admin/assets/js/select2.min.js"></script>
    <script src="../admin/assets/js/moment.min.js"></script>
    <script src="../admin/assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../admin/assets/js/app.js"></script>
    <?php include("../admin/included_js.php"); ?>