<?php
session_start();
require('../includes/conn.php');

if(isset($_POST['email'])){
    $name = mysqli_escape_string($conn,$_POST['name']);
    $email = mysqli_escape_string($conn,$_POST['email']);
    $password = mysqli_escape_string($conn,$_POST['password']);
    $hashPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `users` (`name`,`email`,`password`) VALUES('$name','$email','$hashPassword')";
    $result = mysqli_query($conn,$sql);
    if($result){
        $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Registered</strong> Account created successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      header('location: ../registration.php');
    }


}else{
    echo "Invalid Request. Refill From & Try Again.";
}
?>