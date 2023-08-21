<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
  require('../../includes/conn.php');
} else {
  header('location: login.php');
}


if (isset($_GET['id'])) {
  $id = mysqli_escape_string($conn, $_GET['id']);
  $status = mysqli_escape_string($conn, $_GET['status']);
  $addDataSql = "UPDATE `flights` SET `status`='$status' WHERE id= $id";
  $adresult = mysqli_query($conn, $addDataSql);
  if ($adresult) {
    header('location: ../index.php');
  }
}
