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
    </head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Salary</h4>
                    </div>
                    <!-- <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-edit-schedule.php" class="btn btn btn-primary btn-rounded float-right"><i
                                class="fa fa-plus"></i> Add Schedule</a>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table  mb-0 m-auto text-center " id="tbl_salary">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Employee Name</th>
                                        <th>Amount</th>
                                        <th>Payment Type</th>
                                        <th>Payment Date</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $query_user = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $_SESSION['admin'] . "'");
                                     $row_user = mysqli_fetch_array($query_user);
                                     $doctor_id = $row_user['id'];
                                    $query = mysqli_query($cnn, "select * from salary WHERE emp_id='$doctor_id'");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($query)) {

                                        $query_emp = mysqli_query($cnn, "select * from staff where  id=" . $row['emp_id'] . "");
                                        $row_emp = mysqli_fetch_array($query_emp);

                                        echo "<tr>";
                                        echo "<td>" . $cnt . "</td>";
                                        echo "<td>" . $row_emp['name'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        echo "<td>" . $row['type'] . "</td>";
                                        echo "<td>" . $row['pdate'] . "</td>";
                                        echo "<td>" . $row['des'] . "</td>";
                                        if ($row['status'] == 'Pending') {
                                            echo "<td><button type='button' id='btnBlock' name='btnBlock' class='btn btn-warning block_active' data-toggle='modal' data-target='#paidModal' style='border-radius:4px;' data-id=" . $row['id'] . ">Pending</button></td>";
                                            // echo "<td>" . $row['id'] . "</td>";
                                    
                                        } else {
                                            echo "<td><button type='button' id='btnActive' name='btnActive' class='btn btn-success active_block' style='border-radius:4px;' data-id=" . $row['id'] . ">Paid</button></td>";
                                        }
                                        // echo "<td><a href='add-edit-salary.php?id=" . $row['id'] . "'><button type='button' id='btnEdit' name='btnEdit' title='Edit'  class='btn btn-link'>
                                        // <i class='fa fa-pencil-square-o' aria-hidden='true' style='font-size:22px;font-weight:600;'></i></button></a></td>";
                                        // echo "<td><button type='button' id='btnView' name='btnView' title='View' data-toggle='modal' data-target='#viewModal'  class='btn view viewModal'  data-id=" . $row['id'] . " ><i class='icon-copy bi bi-eye-fill' style='font-weight:bold;' title='View'></i></button></td>";
                                    



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
<!--Unpaid Modal -->
<div class="modal fade" id="paidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="frm">
                                <div class="fomr-group">
                                    <input id="txtUId" name="txtUId" hidden />
                                    <label>Paid Date :</label>
                                    <input type="date" class="form-control" id="txtDte" name="txtDte" />
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSave" name="btnSave" class="btn btn-primary submit-btn">Save changes</button>
                            <button type="button" class="btn btn-primary submit-btn" style="background-color:#A8A7D5; color:#fff;margin-left:20px;" data-dismiss="modal">Close</button>
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
    <script type="text/javascript" src="../newjs/salary_doctor.js"></script>
    <script>
        $(document).ready(function () {
            $('#tbl_salary').DataTable({
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
