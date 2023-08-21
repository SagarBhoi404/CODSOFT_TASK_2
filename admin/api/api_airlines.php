<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('../../includes/conn.php');
} else {
    header('location: login.php');
}

if (isset($_POST['airline_name'])) {
    $airline_name = mysqli_escape_string($conn, $_POST['airline_name']);
    $total_seats = mysqli_escape_string($conn, $_POST['total_seats']);
    $business_seats = mysqli_escape_string($conn, $_POST['business_seats']);
    $economy_seats = mysqli_escape_string($conn, $_POST['economy_seats']);

    $addDataSql = "INSERT INTO airline (`name`,`seats`,`business_seats`,`economy_seats`) VALUES ('$airline_name','$total_seats','$business_seats','$economy_seats')";
    $adresult = mysqli_query($conn, $addDataSql);
    if ($adresult) {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>success!</strong> Airline Added Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../airlines.php');
    } else {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Something went wrong!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../airlines.php');
    }
}


if (isset($_GET['del'])) {
    $del = mysqli_escape_string($conn, $_GET['del']);
    $addDataSql = "DELETE FROM `airline` WHERE id = $del";
    $adresult = mysqli_query($conn, $addDataSql);
    if ($adresult) {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>success!</strong> Airline Deleted Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../airlines.php');
    } else {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Something went wrong!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../airlines.php');
    }
}
