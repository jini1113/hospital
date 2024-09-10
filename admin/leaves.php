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
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
                    <div class="col-sm-8 col-6">
                        <h4 class="page-title">Leave Request</h4>
                    </div>
                    <!-- <div class="col-sm-4 col-6 text-right m-b-30">
                        <a href="add-edit-leave.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Leave</a>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 m-auto text-center" id="tbl_leave">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Department(Role)</th>
                                        <th>Type of Leave</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>No. of Days</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($cnn, "SELECT l.*,d.name AS department_name,doc.name AS doctor_name FROM `leaves` AS l
                                            JOIN
                                                department AS d ON l.department_id = d.id
                                            JOIN
                                                staff AS doc ON l.name_id = doc.id");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($query)) {
                                        // $query_dep = mysqli_query($cnn, "SELECT * FROM department WHERE id='" . $row['department_id'] . "'");
                                        // $row_dep = mysqli_fetch_array($query_dep);

                                        echo "<tr>";
                                        echo "<td>" . $cnt . "</td>";
                                        echo "<td>" . $row['doctor_name'] . "</td>";
                                        echo "<td>" . $row['department_name'] . "</td>";
                                        echo "<td>" . $row['type'] . "</td>";
                                        echo "<td>" . $row['from_date'] . "</td>";
                                        echo "<td>" . $row['to_date'] . "</td>";
                                        echo "<td>" . $row['days'] . "</td>";
                                        echo "<td>" . $row['reason'] . "</td>";
                                        echo "<td>";
                                        echo "<div class='dropdown'>
                                            <button class='btn dropdown-toggle status-btn' type='button' id='statusDropdown{$row['id']}' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-status='{$row['status']}'>
                                                {$row['status']}
                                            </button>
                                            <div class='dropdown-menu' aria-labelledby='statusDropdown{$row['id']}'>
                                                <a class='dropdown-item status-option' href='#' data-id='{$row['id']}' data-status='Pending'>Pending</a>
                                                <a class='dropdown-item status-option' href='#' data-id='{$row['id']}' data-status='Approved'>Approve</a>
                                                <a class='dropdown-item status-option' href='#' data-id='{$row['id']}' data-status='Declined'>Decline</a>
                                            </div>
                                          </div>";
                                        echo "</td>";
                                        echo "<td><a href='add-edit-leave.php?id=" . $row['id'] . "'><button type='button' id='btnEdit' name='btnEdit' title='Edit' class='btn btn-link'>
                                            <i class='fa fa-pencil-square-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a></td>";
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
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>
    <?php include("included_js.php"); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#tbl_leave").DataTable();

            $('.status-option').on('click', function(e) {
                e.preventDefault();
                var leaveId = $(this).data('id');
                var newStatus = $(this).data('status');
                var button = $(this).closest('.dropdown').find('.status-btn');

                // AJAX call to update status
                $.ajax({
                    url: 'leaves.php',
                    method: 'POST',
                    data: { action: 'update_status', id: leaveId, status: newStatus },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update button text and class
                            button.text(newStatus);
                            button.removeClass('btn-warning btn-success btn-danger');

                            switch (newStatus) {
                                case 'Approved':
                                    button.addClass('btn-success');
                                    break;
                                case 'Declined':
                                    button.addClass('btn-danger');
                                    break;
                                case 'Pending':
                                    button.addClass('btn-warning');
                                    break;
                            }

                            // Update data-status attribute
                            button.attr('data-status', newStatus);
                        } else {
                            alert('Failed to update status. Please try again.');
                            console.error(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            // Set initial button colors
            $('.status-btn').each(function() {
                var status = $(this).data('status');
                $(this).removeClass('btn-warning btn-success btn-danger');
                switch (status) {
                    case 'Approved':
                        $(this).addClass('btn-success');
                        break;
                    case 'Declined':
                        $(this).addClass('btn-danger');
                        break;
                    case 'Pending':
                        $(this).addClass('btn-warning');
                        break;
                }
            });
        });
    </script>
</body>

</html>