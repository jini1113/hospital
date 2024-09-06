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
                $_SESSION['role'] = $row_status['role'];
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
//get bed_no
if ($_GET['what'] == "getInBed") {
    $wardId = $_POST['wardId'];
    $response = [];
    $query = mysqli_query($cnn, "SELECT bed_no FROM bed WHERE ward_id = " . $wardId);
    while ($row = mysqli_fetch_assoc($query)) {
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


?>