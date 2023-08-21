<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('../../includes/conn.php');
} else {
    header('location: login.php');
}

if (isset($_POST['city_name'])) {
    $city_name = mysqli_escape_string($conn, $_POST['city_name']);
    $addDataSql = "INSERT INTO city (`name`) VALUES ('$city_name')";
    $adresult = mysqli_query($conn, $addDataSql);
    if ($adresult) {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>success!</strong> City Added Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../city.php');
    } else {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Something went wrong!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../city.php');
    }
}

if (isset($_GET['del'])) {
    $del = mysqli_escape_string($conn, $_GET['del']);
    $addDataSql = "DELETE FROM `city` WHERE id = $del";
    $adresult = mysqli_query($conn, $addDataSql);
    if ($adresult) {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>success!</strong> City Deleted Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../city.php');
    } else {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Something went wrong!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../city.php');
    }
}
