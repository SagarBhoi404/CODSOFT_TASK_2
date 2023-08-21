<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('../../includes/conn.php');
} else {
    header('location: login.php');
}

if (isset($_POST['departure_date'])) {
    $departure_date = mysqli_escape_string($conn, $_POST['departure_date']);
    $departure_time = mysqli_escape_string($conn, $_POST['departure_time']);
    $arrival_date = mysqli_escape_string($conn, $_POST['arrival_date']);
    $arrival_time = mysqli_escape_string($conn, $_POST['arrival_time']);
    $from = mysqli_escape_string($conn, $_POST['from']);
    $to = mysqli_escape_string($conn, $_POST['to']);
    $duration = mysqli_escape_string($conn, $_POST['duration']);
    $price = mysqli_escape_string($conn, $_POST['price']);
    $airline = mysqli_escape_string($conn, $_POST['airline']);

    $seatSql = "SELECT seats FROM airline WHERE name = '$airline'";
    $seatResult = mysqli_query($conn,$seatSql);
    $row = mysqli_fetch_assoc($seatResult);
    $seats = $row['seats'];

    $addDataSql = "INSERT INTO `flights`(`arrivale`, `departure`, `Destination`, `source`, `airline`, `Seats`, `duration`, `Price`, `status`) VALUES ('$arrival_date $arrival_time','$departure_date $departure_time','$to','$from','$airline','$seats','$duration','$price',NULL)";
    $adresult = mysqli_query($conn, $addDataSql);
    if ($adresult) {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>success!</strong> Flight Added Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../flight.php');
    } else {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Something went wrong!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../flight.php');
    }
}

if (isset($_GET['del'])) {
    $del = mysqli_escape_string($conn, $_GET['del']);
    $addDataSql = "DELETE FROM `flights` WHERE id = $del";
    $adresult = mysqli_query($conn, $addDataSql);
    if ($adresult) {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>success!</strong> Flight Deleted Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../flight.php');
    } else {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Something went wrong!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../flight.php');
    }
}
