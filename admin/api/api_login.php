<?php
require('../../includes/conn.php');

if (isset($_POST['email'])) {
    $email = mysqli_escape_string($conn, $_POST['email']);
    $password = mysqli_escape_string($conn, $_POST['password']);

    $fetchDataSql = "SELECT * FROM users WHERE email= '$email' ";
    $fdresult = mysqli_query($conn, $fetchDataSql);
    $row = mysqli_fetch_array($fdresult);
    if ($row == null) {
        session_start();
        $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Invalid Credentials.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        header('location: ../login.php');
    } else {
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['logged'] = true;
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];
            header('location: ../index.php');
        } else {
            session_start();
            $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> Invalid Credentials.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
            header('location: ../login.php');
        }
    }
}
