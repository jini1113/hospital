<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($cnn, "DELETE FROM d_schedule WHERE id='$id'");
    if ($query) {
        header('location:schedule.php');
    }
}