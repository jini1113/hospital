<?php
include("connection.php");
session_start();

//admin-registration
if ($_GET['what'] == "admin_registration") {
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    // $phone = $_POST['phone'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $query_chk = mysqli_query($cnn, "select count(*) from staff where email='" . $mail . "' ");
    $row_chk = mysqli_fetch_array($query_chk);

    if ($row_chk[0] > 0) {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >This Email-id already registred.Please register with new email-id.</span";
    } else {
        $resonse['success'] = true;

        $query = mysqli_query($cnn, "insert into staff (name,email,password,role,status) values ('" . $name . "','" . $mail . "','" . $pass . "','Admin','Active')");
        if ($query > 0) {
            $response['success'] = true;
            $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Registration successfully</span>";
        } else {
            $response['success'] = false;
            $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
        }
    }

    echo json_encode($response);
}
//admin-login
if ($_GET['what'] == "admin_login") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $query = mysqli_query($cnn, "SELECT count(*) FROM staff WHERE email='" . $email . "'");
    $row = mysqli_fetch_array($query);

    if ($row[0] > 0) {
        $response['success'] = true;
        $query_chk = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $email . "'");
        $row_chk = mysqli_fetch_array($query_chk);
        $check = password_verify($pass, $row_chk['password']);

        if ($check) {
            $query_status = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $email . "'");
            $row_status = mysqli_fetch_array($query_status);

            if ($row_status['status'] == "Active") {
                $response['success'] = true;
                $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;'>Login successfully.</span>";
                $response['role'] = $row_status['role'];
                $_SESSION['admin'] = $row_status['email'];
            } else {
                $response['success'] = false;
                $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;'>Your account has been block.</span>";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;'>Password not match.</span>";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;'>Email not found.</span>";
    }

    echo json_encode($response);
}
//get city
if ($_GET['what'] == "getInsCityV") {
    $state = $_POST['state'];
    $response = [];
    $query = mysqli_query($cnn, "select * from city where state_id=" . $state . "");
    while ($row = mysqli_fetch_array($query)) {
        array_push($response, $row);
    }
    echo json_encode($response);
}

// get insert city update staff
if ($_GET['what'] == "retUCity") {
    $id = $_POST['id'];
    $main = $_POST['main'];
    $response = [];
    $query_select = mysqli_query($cnn, "select * from staff where id=" . $main . " and state_id=" . $id . "");
    $row_select = mysqli_fetch_array($query_select);
    $query = mysqli_query($cnn, "select * from city where state_id=" . $id . "");
    while ($row = mysqli_fetch_array($query)) {
        array_push($response, $row);
    }
    if (isset($row_select['city_id'])) {
        $response = ["city_id" => $row_select['city_id'], "city" => $response];
    } else {
        $response = ["city" => $response];
    }
    echo json_encode($response);
}
//get bed_no
if ($_GET['what'] == "getInBed") {
    $wardId = $_POST['wardId'];
    $response = [];
    $query = mysqli_query($cnn, "SELECT * FROM bed WHERE ward_id = '" . $wardId . "'");
    while ($row = mysqli_fetch_assoc($query)) {
        array_push($response, $row);
    }
    echo json_encode($response);
}
// get insert city update staff
if ($_GET['what'] == "getUpBed") {
    $id = $_POST['id']; // Ward ID
    $main = $_POST['main']; // Patient ID
    $response = [];

    // Fetch the patient's current bed information
    $query_select = mysqli_query($cnn, "SELECT * FROM b_patients WHERE id=" . $main);
    $row_select = mysqli_fetch_array($query_select);

    // Fetch beds for the selected ward
    $query = mysqli_query($cnn, "SELECT * FROM bed WHERE ward_id=" . $id);
    $beds = [];
    while ($row = mysqli_fetch_array($query)) {
        $beds[] = [
            "id" => $row['id'], // Make sure to fetch bed ID
            "name" => $row['name'] // Make sure to fetch bed name
        ];
    }

    // Include the current bed ID in the response
    $response = [
        "bed_id" => isset($row_select['bed_id']) ? $row_select['bed_id'] : null, // Ensure bed_id is set
        "beds" => $beds
    ];

    // Return the response as JSON
    echo json_encode($response);
}
// =============================================
// add b_patient 
if ($_GET['what'] == "b_patientadd") {

    $patient = $_POST['txtPatient'];
    $bed_no = $_POST['txtBno'];
    $ward = $_POST['txtWard'];
    $a_date = $_POST['txtAdate'];
    $d_date = $_POST['txtDate'];



    $cols = "patient_id,ward_id,a_date,d_date,status";
    $values = "'$patient','$ward','$a_date','$d_date','Admit'";

    if (!empty($bed_no)) {
        $cols .= ", bed_id";
        $values .= ", '" . $bed_no . "'";
    } else {
        $cols .= ", bed_id";
        $values .= ", '0'";
    }

    $query = mysqli_query($cnn, "INSERT INTO b_patients ($cols) VALUES ($values)");

    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Record inserted successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
//  update b_patient 
if ($_GET['what'] == "b_patientup") {
    // Sanitize and assign inputs
    $update_id = mysqli_real_escape_string($cnn, $_POST['txtUId']); // Assuming you have a hidden input for the ID
    $patient = mysqli_real_escape_string($cnn, $_POST['txtPatient']);
    $bed_no = mysqli_real_escape_string($cnn, $_POST['txtBno']);
    $ward = mysqli_real_escape_string($cnn, $_POST['txtWard']);
    $a_date = mysqli_real_escape_string($cnn, $_POST['txtAdate']);
    $d_date = mysqli_real_escape_string($cnn, $_POST['txtDate']);

    // Construct the update query
    $update_query = "UPDATE b_patients SET 
                     patient_id='$patient', 
                     ward_id='$ward', 
                     bed_id='" . (!empty($bed_no) ? $bed_no : '0') . "', 
                     a_date='$a_date', 
                     d_date='$d_date'
                    
                     WHERE id='$update_id'";

    // Execute the update query
    if (mysqli_query($cnn, $update_query)) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Record updated successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Some error occurred. Please try again</span>";
    }
    echo json_encode($response);
}


// active role
if ($_GET['what'] == "blockDepartment") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update department set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Department Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block role
if ($_GET['what'] == "activeDepartment") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update department set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Department Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active employee
if ($_GET['what'] == "blockEmp") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update staff set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Employee Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block employee
if ($_GET['what'] == "activeEmp") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update staff set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Employee Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active patient
if ($_GET['what'] == "blockPatient") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update patients set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Patient Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block patient
if ($_GET['what'] == "activePatient") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update patients set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Patient Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active asset
if ($_GET['what'] == "blockAsset") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update assets set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Asset Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block asset
if ($_GET['what'] == "activeAsset") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update assets set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Asset Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active appointment
if ($_GET['what'] == "blockApp") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update appointment set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Appointment Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block asset
if ($_GET['what'] == "activeApp") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update appointment set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Appointment Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active schedule
if ($_GET['what'] == "blockSchedule") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update d_schedule set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Schedule Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block schedule
if ($_GET['what'] == "activeSchedule") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update d_schedule set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Schedule Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active tax
if ($_GET['what'] == "blockTax") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update tax set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Tax Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block tax
if ($_GET['what'] == "activeTax") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update tax set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Tax Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active donor
if ($_GET['what'] == "blockDonor") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update donor set status='Re-Donate' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Donor Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block donor
if ($_GET['what'] == "activeDonor") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update donor set status='Donate' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Donor Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active ward
if ($_GET['what'] == "blockWard") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update ward set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Ward Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block ward
if ($_GET['what'] == "activeWard") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update ward set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Ward Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active bed
if ($_GET['what'] == "blockBed") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update bed set status='Booked' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Bed Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// block ward
if ($_GET['what'] == "activeBed") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update bed set status='Avaliable' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Bed Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// chnage password 
if ($_GET['what'] == "sendChangePwd") {
    // Ensure required fields are present in $_POST
    if (!isset($_POST['old']) || !isset($_POST['pwd'])) {
        $response['success'] = false;
        $response['message'] = "Missing old or new password.";
        echo json_encode($response);
        exit;
    }

    // Sanitize and assign POST variables
    $old = mysqli_real_escape_string($cnn, $_POST['old']);
    $new_pwd = mysqli_real_escape_string($cnn, $_POST['pwd']);
    $email = $_SESSION['admin'];

    // Fetch user data based on email
    $query_user = mysqli_query($cnn, "SELECT * FROM staff WHERE email='" . $email . "'");

    // Check if user exists and only one user is found
    if ($query_user || mysqli_num_rows($query_user) != 1) {
        $row_user = mysqli_fetch_array($query_user);

        // Verify old password
        if (!password_verify($old, $row_user['password'])) {
            $response['success'] = false;
            $response['message'] = "Old Password incorrect. Please try again.";
            echo json_encode($response);
            exit;
        }

        // Hash new password
        $pwd = password_hash($new_pwd, PASSWORD_DEFAULT);

        // Update password in database
        $update_query = "UPDATE staff SET password='" . $pwd . "' WHERE email='" . $email . "'";
        $query = mysqli_query($cnn, $update_query);

        if ($query) {
            // Fetch role information
            $response['role'] = $row_user['role']; // Assuming 'role' column stores role name directly

            $response['success'] = true;
            $response['message'] = "Password updated successfully";
        } else {
            $response['success'] = false;
            $response['message'] = "Failed to update password. Please try again.";
        }



    } else {
        $response['success'] = false;
        $response['message'] = "User not found or multiple users found.";
        echo json_encode($response);
        exit;
    }


    // Return JSON response
    echo json_encode($response);
}
// add schedule
if ($_GET['what'] == "addschedule") {
    // Sanitize inputs
    $doctor_id = mysqli_real_escape_string($cnn, $_POST['txtDoc']);
    $days = isset($_POST['txtDays']) ? implode(", ", $_POST['txtDays']) : '';
    $from_time = mysqli_real_escape_string($cnn, $_POST['txtFtime']);
    $to_time = mysqli_real_escape_string($cnn, $_POST['txtTotime']);
    $message = mysqli_real_escape_string($cnn, $_POST['txtMsg']);

    // Construct the query
    $query = "INSERT INTO d_schedule (doctor_id, days, from_time, to_time, message, status) 
              VALUES ('$doctor_id', '$days', '$from_time', '$to_time', '$message', 'Active')";

    // Execute the query
    if (mysqli_query($cnn, $query)) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Record inserted successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Error: " . mysqli_error($cnn) . "</span>";
    }

    echo json_encode($response);
}
// update schedule
if ($_GET['what'] == "updateschedule") {
    // Sanitize inputs
    $schedule_id = mysqli_real_escape_string($cnn, $_POST['txtUId']);
    $doctor_id = mysqli_real_escape_string($cnn, $_POST['txtDoc']);
    $days = isset($_POST['txtDays']) ? implode(", ", $_POST['txtDays']) : '';
    $from_time = mysqli_real_escape_string($cnn, $_POST['txtFtime']);
    $to_time = mysqli_real_escape_string($cnn, $_POST['txtTotime']);
    $message = mysqli_real_escape_string($cnn, $_POST['txtMsg']);

    // Construct the update query
    $query = "UPDATE d_schedule SET 
                doctor_id = '$doctor_id', 
                days = '$days', 
                from_time = '$from_time', 
                to_time = '$to_time', 
                message = '$message'
              WHERE id = '$schedule_id'";

    // Execute the query
    if (mysqli_query($cnn, $query)) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Schedule Updated successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Error: " . mysqli_error($cnn) . "</span>";
    }

    echo json_encode($response);
}
// add salary
if ($_GET['what'] == "addsalary") {
    // Sanitize inputs
    $emp_id = mysqli_real_escape_string($cnn, $_POST['txtEmp']);
    $amount = mysqli_real_escape_string($cnn, $_POST['txtAmt']);
    $type = mysqli_real_escape_string($cnn, $_POST['txtType']);
    // $pdate = mysqli_real_escape_string($cnn, $_POST['txtDate']);
    $des = mysqli_real_escape_string($cnn, $_POST['txtDes']);

    // Construct the query
    $query = "INSERT INTO salary (emp_id, amount, type,des, status) 
              VALUES ('$emp_id', '$amount', '$type','$des', 'Pending')";

    // Execute the query
    if (mysqli_query($cnn, $query)) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Record Inserted Successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Error: " . mysqli_error($cnn) . "</span>";
    }

    echo json_encode($response);
}
// update salary 
if ($_GET['what'] == "updatesalary") {
    // Sanitize inputs
    $salary_id = mysqli_real_escape_string($cnn, $_POST['txtUId']);
    $emp_id = mysqli_real_escape_string($cnn, $_POST['txtEmp']);
    $amount = mysqli_real_escape_string($cnn, $_POST['txtAmt']);
    $type = mysqli_real_escape_string($cnn, $_POST['txtType']); // Ensure this is sanitized
    // $pdate = mysqli_real_escape_string($cnn, $_POST['txtDate']);
    $des = mysqli_real_escape_string($cnn, $_POST['txtDes']);

    // Check if type is selected
    if (empty($type)) {
        $response['success'] = false;
        $response['message'] = "Please select a type.";
        echo json_encode($response);
        exit;
    }

    // Construct the update query
    $query = "UPDATE salary SET 
                emp_id = '$emp_id', 
                amount = '$amount', 
                type = '$type', 
                des = '$des'
              WHERE id = '$salary_id'";

    // Execute the query
    if (mysqli_query($cnn, $query)) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Salary Updated Successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Error: " . mysqli_error($cnn) . "</span>";
    }

    echo json_encode($response);
}
//paid salary
if ($_GET['what'] == "salPaid") {
    $id = $_POST['id'];
    $dte = $_POST['date']; // Ensure this is being captured
    $query = mysqli_query($cnn, "UPDATE salary SET status='Paid', pdate='" . mysqli_real_escape_string($cnn, $dte) . "' WHERE id=" . intval($id));

    if ($query) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Record paid successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Some error occurred. Please try again</span>";
    }

    echo json_encode($response);
}
//unpaid salary
if ($_GET['what'] == "salUnPaid") {
    $id = $_POST['id'];

    $query = mysqli_query($cnn, "update salary set status='Pending' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Record Unpaid  successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }

    echo json_encode($response);
}
if ($_GET['what'] == "salId") {
    $id = $_POST['id'];
    $response = $id;
    echo json_encode($response);
}

// Reject appointment
if ($_GET['what'] == "rejectApp") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update appointment set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Appointment Approved successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// approve appointment
if ($_GET['what'] == "approveApp") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update appointment set status='Rejected' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Appointment Rejected successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// active  Doctor appointment
if ($_GET['what'] == "active_app") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update appointment set status='Active' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Appointment Active successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// Block doctor  appointment
if ($_GET['what'] == "block_App") {
    // $name = $_POST['name'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $query = mysqli_query($cnn, "update appointment set status='Block' where id=" . $id . "");
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Appointment Block successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span  style='font-weight:100;color:black;font-size:15px;' >Some error occured.Please try again</span>";
    }
    echo json_encode($response);
}
// add app
if ($_GET['what'] == "addappoi") {
    // Sanitize inputs
    $patient_id = $_POST['txtPatient'];
    $phone_no = $_POST['txtPhone'];
    $email = $_POST['txtMail'];
    $doctor_id = $_POST['txtDoc'];
    $date = $_POST['txtDate'];
    $time = $_POST['txtTime'];
    $message = $_POST['txtMsg'];

    $cols = "patient_id,phone_no,email,doctor_id,date,time, message, status";
    $values = "'$patient_id', '$phone_no', '$email', '$doctor_id', '$date', '$time', '$message', 'Active'";
    // Construct the query
    $query = mysqli_query($cnn, "INSERT INTO  appointment ($cols) VALUES ($values)");

    // Execute the query
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Record Inserted Successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Error:</span>";
    }

    echo json_encode($response);
}
if ($_GET['what'] == "upappoi") {
    // Sanitize inputs
    $id = $_POST['txtUId'];
    $patient_id = $_POST['txtPatient'];
    $phone_no = $_POST['txtPhone'];
    $email = $_POST['txtMail'];
    $doctor_id = $_POST['txtDoc'];
    $date = $_POST['txtDate'];
    $time = $_POST['txtTime'];
    $message = $_POST['txtMsg'];

    $query = mysqli_query($cnn, "UPDATE appointment SET 
    patient_id = '$patient_id', 
    phone_no = '$phone_no', 
    email = '$email', 
    doctor_id = '$doctor_id', 
    date = '$date', 
    time = '$time', 
    message = '$message' 
    WHERE id = '$id'");

    // Execute the query
    if ($query > 0) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Record Updated Successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Error:</span>";
    }

    echo json_encode($response);
}
// update app 
if ($_GET['what'] == "updatesalary") {
    // Sanitize inputs
    $salary_id = mysqli_real_escape_string($cnn, $_POST['txtUId']);
    $emp_id = mysqli_real_escape_string($cnn, $_POST['txtEmp']);
    $amount = mysqli_real_escape_string($cnn, $_POST['txtAmt']);
    $type = mysqli_real_escape_string($cnn, $_POST['txtType']); // Ensure this is sanitized
    // $pdate = mysqli_real_escape_string($cnn, $_POST['txtDate']);
    $des = mysqli_real_escape_string($cnn, $_POST['txtDes']);

    // Check if type is selected
    if (empty($type)) {
        $response['success'] = false;
        $response['message'] = "Please select a type.";
        echo json_encode($response);
        exit;
    }

    // Construct the update query
    $query = "UPDATE salary SET 
                emp_id = '$emp_id', 
                amount = '$amount', 
                type = '$type', 
                des = '$des'
              WHERE id = '$salary_id'";

    // Execute the query
    if (mysqli_query($cnn, $query)) {
        $response['success'] = true;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Salary Updated Successfully</span>";
    } else {
        $response['success'] = false;
        $response['message'] = "<span style='font-weight:100;color:black;font-size:15px;'>Error: " . mysqli_error($cnn) . "</span>";
    }

    echo json_encode($response);
}
?>