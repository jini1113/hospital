<?php
include("../connection.php");
session_start();
if (
    !isset($_SESSION["admin"]) || $_SESSION['admin'] == NULL ||
    $_SESSION["admin"] == ""
) {
    header("Location:../login.php");
}

if (isset($_GET['id'])) {
    $query = mysqli_query($cnn, "SELECT i.*, t.percentage AS tax_percentage FROM invoice i LEFT JOIN tax t ON i.tax_id = t.id WHERE i.id=" . $_GET['id']);
    $row = mysqli_fetch_array($query);
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
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
                    <div class="col-sm-12">
                        <?php
                        if (isset($_GET['id'])) {
                            $query = mysqli_query($cnn, "select * from invoice where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3  ">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update Invoice ";
                                } else {
                                    echo "Add Invoice ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-100 ">
                        <div class="row">
                            <div class="col-lg-10 offset-lg-1">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-6 col-md-3">
                                            <div class="form-group">
                                                <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['id'];
                                                } ?>" hidden />
                                                <label>Patient Name</label>
                                                <select class="select" id="txtPatient" name="txtPatient">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $query_patient = mysqli_query($cnn, "SELECT * FROM patients");
                                                    while ($row_patient = mysqli_fetch_array($query_patient)) {
                                                        echo "<option value='" . $row_patient['id'] . "'";
                                                        if (isset($_GET['id'])) {
                                                            // Assuming $row is defined earlier and contains the data of the item being edited
                                                            if ($row['patient_id'] == $row_patient['id']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">" . $row_patient['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Tax</label>
                                                <select class="select" id="txtTax" name="txtTax"
                                                    onchange="fetchTaxPercentage()">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $query_tax = mysqli_query($cnn, "SELECT * FROM tax");
                                                    while ($row_tax = mysqli_fetch_array($query_tax)) {
                                                        echo "<option value='" . $row_tax['id'] . "' data-percentage='" . $row_tax['percentage'] . "'";
                                                        if (isset($_GET['id'])) {
                                                            if ($row['tax_id'] == $row_tax['id']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">" . $row_tax['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Invoice date <span class="text-danger">*</span></label>

                                                <input class="form-control " type="date" id="txtDate" name="txtDate"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['date'];
                                                    } ?>">

                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label>Due Date <span class="text-danger">*</span></label>

                                                <input class="form-control " type="date" id="txtDue" name="txtDue"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['due'];
                                                    } ?>">

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Patient Address</label>
                                                <textarea type="text" name="txtAdd" id="txtAdd" class="form-control"><?php if (isset($_GET['id'])) {
                                                    echo $row['address'];
                                                } ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-white text-center">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20px">#</th>
                                                            <th class="col-sm-2">Item</th>
                                                            <th class="col-md-6">Description</th>
                                                            <th>Fees</th>
                                                            <th> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>
                                                                <input class="form-control" type="text"
                                                                    style="min-width:150px">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text"
                                                                    style="min-width:200px" id="txtDes" name="txtDes"
                                                                    value="<?php if (isset($_GET['id'])) {
                                                                        echo $row['des'];
                                                                    } ?>">
                                                            </td>

                                                            <td>
                                                                <input class="form-control" style="width:220px"
                                                                    oninput="calculateTotal()" type="text" id="txtFee"
                                                                    name="txtFee" value="<?php if (isset($_GET['id'])) {
                                                                        echo $row['fee'];
                                                                    } ?>">
                                                            </td>
                                                            <td><a href="javascript:void(0)" class="text-success"
                                                                    style="font-size:30px;margin-right:8px;" title="Add"
                                                                    onclick="addRow()"><i class="fa fa-plus"></i></a>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover table-white">
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-right">Total</td>
                                                            <td
                                                                style="text-align: right; padding-right: 30px;width: 230px">
                                                                <input class="form-control text-right form-amt" value="<?php if (isset($_GET['id'])) {
                                                                    echo $row['total'];
                                                                } ?>" id="txtTotal" name="txtTotal" readonly=""
                                                                    type="text">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" class="text-right">Tax</td>
                                                            <td
                                                                style="text-align: right; padding-right: 30px;width: 230px">
                                                                <input class="form-control text-right form-amt" value="<?php if (isset($_GET['id'])) {
                                                                    echo $row['tax'];
                                                                } ?>" id="txtPer" name="txtPer" readonly type="text">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5"
                                                                style="text-align: right; font-weight: bold">
                                                                Grand Total</td>
                                                            <td
                                                                style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px;width: 230px">
                                                                <input class="form-control text-right form-amt" value="<?php if (isset($_GET['id'])) {
                                                                    echo $row['g_total'];
                                                                } ?>" id="grandTotal" name="grandTotal" readonly
                                                                    type="text">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="text-center m-t-20">
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
                                $patient = $_POST['txtPatient'];
                                $tax = $_POST['txtTax'];
                                $date = $_POST['txtDate'];
                                $due = $_POST['txtDue'];
                                $address = $_POST['txtAdd'];
                                $des = $_POST['txtDes'];
                                $fee = $_POST['txtFee'];
                                $total = $_POST['txtTotal'];
                                $g_total = $_POST['grandTotal'];

                                $cols = "patient_id,tax_id,date,due,address,des,fee,total,g_total, status";
                                $values = "'$patient', '$tax','$date','$due','$address','$des','$fee','$total','$g_total','Pending'";
                                $query = mysqli_query($cnn, "INSERT INTO invoice ($cols) VALUES ($values)");

                                if ($query) {
                                    echo "<script>window.location.replace('invoices.php');</script>";
                                } else {
                                    echo "<script>alert('Some error occurred. Please try again.');</script>";
                                }
                            }
                            // update code
                            if (isset($_POST['btnUpdate'])) {
                                $id = $_POST['txtUId'];
                                $patient = $_POST['txtPatient'];
                                $tax = $_POST['txtTax'];
                                $date = $_POST['txtDate'];
                                $due = $_POST['txtDue'];
                                $address = $_POST['txtAdd'];
                                $des = $_POST['txtDes'];
                                $fee = $_POST['txtFee'];
                                $total = $_POST['txtTotal'];
                                $per = $_POST['txtPer'];
                                $g_total = $_POST['grandTotal'];

                                $cols = "patient_id='" . $patient . "',tax_id=" . $tax . ",date='" . $date . "',due='" . $due . "',
                                address='" . $address . "',des='" . $des . "',fee='" . $fee . "',total='" . $total . "',tax='" . $per . "',g_total='" . $g_total . "'";


                                $query = mysqli_query($cnn, "update invoice set " . $cols . " where id=" . $id . "");
                                if ($query > 0) {
                                    echo "<script>window.location.replace('invoices.php');</script>";
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
            <script src="assets/js/moment.min.js"></script>
            <script src="assets/js/select2.min.js"></script>
            <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
            <script src="assets/js/app.js"></script>
            <script>
                function fetchTaxPercentage() {
                    var taxSelect = document.getElementById('txtTax');
                    var selectedOption = taxSelect.options[taxSelect.selectedIndex];
                    var taxPercentage = selectedOption ? selectedOption.getAttribute('data-percentage') : '';
                    document.getElementById('txtPer').value = taxPercentage;
                    calculateTotal();
                }

                // Call this function on page load to set the initial tax percentage
                document.addEventListener('DOMContentLoaded', function () {
                    fetchTaxPercentage();
                });

                function calculateTotal() {
                    var feeInputs = document.querySelectorAll('input[name="txtFee"]');
                    var total = 0;
                    feeInputs.forEach(function (input) {
                        total += parseFloat(input.value) || 0;
                    });
                    document.getElementById('txtTotal').value = total.toFixed(2);

                    var taxPercentage = parseFloat(document.getElementById('txtPer').value) || 0;
                    var taxAmount = (total * taxPercentage) / 100;
                    var grandTotal = total + taxAmount;
                    document.getElementById('grandTotal').value = grandTotal.toFixed(2);
                }
                function addRow(button) {
                    var table = document.querySelector('.table-hover tbody');
                    var rowCount = table.rows.length;
                    var row = table.insertRow(rowCount);
                    row.innerHTML = `
            <td>${rowCount + 1}</td>
            <td><input class="form-control" type="text" style="min-width:150px"></td>
            <td><input class="form-control" type="text" style="min-width:200px"></td>
            <td><input class="form-control " type="text" name="txtFee" style="width:220px" oninput="calculateTotal()"></td>
            <td>
                <a href="javascript:void(0)" class="text-success mt-3" style="font-size:30px;margin-right:10px;" title="Add" onclick="toggleButton(this)"><i class="fa fa-plus"></i></a>
            </td>
        `;
                }

                function toggleButton(button) {
                    if (button.classList.contains('text-success')) {
                        // Change the plus button to a delete button
                        button.innerHTML = '<i class="fa fa-trash"></i>';
                        button.classList.remove('text-success');
                        button.classList.add('text-danger');
                        button.setAttribute('title', 'Delete');
                        button.setAttribute('onclick', 'deleteRow(this)');
                        // Add a new row
                        addRow();
                    } else {
                        // Delete the row
                        deleteRow(button);
                    }
                }

                function deleteRow(button) {
                    var row = button.parentNode.parentNode;
                    row.parentNode.removeChild(row);
                    calculateTotal();
                }

                document.addEventListener('DOMContentLoaded', function () {
                    // Initialize the first row's plus button
                    var firstPlusButton = document.querySelector('.table-hover tbody tr td a');
                    if (firstPlusButton) {
                        firstPlusButton.setAttribute('onclick', 'toggleButton(this)');
                    }
                });
            </script>
</body>

</html>