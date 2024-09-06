<?php
include("../connection.php");
session_start();
if (
    !isset($_SESSION["admin"]) || $_SESSION['admin'] == NULL ||
    $_SESSION["admin"] == ""
) {
    header("Location:../login.php");
}

// Add this block to handle AJAX request for fetching blood group
if (isset($_GET['donor_id'])) {
    $donor_id = $_GET['donor_id'];
    $query = mysqli_query($cnn, "SELECT b_group FROM donor WHERE id = '$donor_id'");
    if ($row = mysqli_fetch_assoc($query)) {
        echo $row['b_group'];
    } else {
        echo "";
    }
    exit; // Ensure the script stops here when fetching blood group
}
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<!-- add-department24:07-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
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
                    <div class="col-lg-8 offset-lg-2">
                        <?php
                        if (isset($_GET['id'])) {
                            $query = mysqli_query($cnn, "select * from b_issue where id=" . $_GET['id'] . "");
                            $row = mysqli_fetch_array($query);
                        }
                        ?>
                        <div class="title ">
                            <h2 class="h3  ">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo "Update Blood Issue ";
                                } else {
                                    echo "Add  Blood Issue ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="card pt-5 pb-5 m-auto w-75 ">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input id="txtUId" name="txtUId" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['id'];
                                                } ?>" hidden />
                                                <label>Issue Date</label>
                                                <input type="date" class="form-control " name="txtDate" id="txtDate"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['date'];
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
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
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Doctor</label>
                                                <select class="select" id="txtDoc" name="txtDoc">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $query_doctor = mysqli_query($cnn, "SELECT * FROM staff where role='Doctor'");
                                                    while ($row_doctor = mysqli_fetch_array($query_doctor)) {
                                                        echo "<option value='" . $row_doctor['id'] . "'";
                                                        if (isset($_GET['id'])) {
                                                            // Assuming $row is defined earlier and contains the data of the item being edited
                                                            if ($row['doctor_id'] == $row_doctor['id']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">" . $row_doctor['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Donor Name</label>
                                                <select class="select" id="txtDonor" name="txtDonor"
                                                    onchange="fetchDonorBloodGroup()">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $query_donor = mysqli_query($cnn, "SELECT * FROM donor");
                                                    while ($row_donor = mysqli_fetch_array($query_donor)) {
                                                        echo "<option value='" . $row_donor['id'] . "'";
                                                        if (isset($_GET['id'])) {
                                                            // Assuming $row is defined earlier and contains the data of the item being edited
                                                            if ($row['donor_id'] == $row_donor['id']) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">" . $row_donor['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Blood Group</label>
                                                <input class="form-control" type="text" id="txtGrp" name="txtGrp"
                                                    value="<?php if (isset($_GET['id'])) {
                                                        echo $row['group'];
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Amount <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="txtAmt" name="txtAmt" value="<?php if (isset($_GET['id'])) {
                                                    echo $row['amount'];
                                                } ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Usage</label>
                                                <textarea type="text" name="txtUse" id="txtUse" class="form-control"><?php if (isset($_GET['id'])) {
                                                    echo $row['des'];
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
                        </div>
                        <!-- insert code -->
                        <?php
                        if (isset($_POST['btnSubmit'])) {
                            $date = $_POST['txtDate'];
                            $patient = $_POST['txtPatient'];
                            $doctor = $_POST['txtDoc'];
                            $donor = $_POST['txtDonor'];
                            $group = $_POST['txtGrp'];
                            $amount = $_POST['txtAmt'];
                            $use = $_POST['txtUse'];

                            // $cols = "date,patient_id,doctor_id,donor_id,b_group,amount,usage";
                            // $values = "'$date', '$patient', '$doctor', '$donor', '$group', '$amount', '$use'";
                        
                            // Corrected SQL query
                            $query = mysqli_query($cnn, "INSERT INTO b_issue (date,patient_id,doctor_id,donor_id,`group`,amount,des) VALUES ('$date', '$patient', '$doctor', '$donor', '$group', '$amount', '$use')");

                            if ($query) {
                                echo "<script>window.location.replace('blood-issue.php');</script>";
                            } else {
                                echo "<script>alert('Some error occurred. Please try again.');</script>";
                            }
                        }
                        // update code
                        if (isset($_POST['btnUpdate'])) {
                            $id = $_POST['txtUId'];
                            $date = $_POST['txtDate'];
                            $patient = $_POST['txtPatient'];
                            $doctor = $_POST['txtDoc'];
                            $donor = $_POST['txtDonor'];
                            $group = $_POST['txtGrp'];
                            $amount = $_POST['txtAmt'];
                            $use = $_POST['txtUse'];
                        
                            $cols = "date='$date', patient_id='$patient', doctor_id='$doctor', donor_id='$donor', `group`='$group', amount='$amount', des='$use'";
                        
                            $query = mysqli_query($cnn, "UPDATE b_issue SET $cols WHERE id=$id");
                            if ($query) {
                                echo "<script>window.location.replace('blood-issue.php');</script>";
                            } else {
                                echo "<script>alert('Some error occurred. Please try again');</script>";
                            }
                        }
                        ?>
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
        <script src="assets/js/app.js"></script>
        <script>
            function fetchDonorBloodGroup() {
                var donorId = document.getElementById('txtDonor').value;
                if (donorId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'add-edit-issue.php?donor_id=' + donorId, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById('txtGrp').value = xhr.responseText;
                        }
                    };
                    xhr.send();
                } else {
                    document.getElementById('txtGrp').value = '';
                }
            }
        </script>
</body>

</html>