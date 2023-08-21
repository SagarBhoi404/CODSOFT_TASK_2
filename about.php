<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Online Travel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <?php require('includes/header.php') ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h4>About Us</h4>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugiat sed iusto voluptates? Nesciunt aliquam optio maiores impedit quas delectus perspiciatis numquam ab at deleniti ratione nam nisi aliquid odit sit pariatur est saepe, consectetur quo quasi nobis similique amet molestiae. Iusto at doloribus, quo provident ipsam maiores, aut consequuntur odio illum ipsa assumenda enim itaque, eius veritatis ratione soluta corrupti possimus dolores eaque quaerat eum molestiae. Et ullam quasi nobis, natus odit perspiciatis vel id minus aperiam earum vitae eius, repellendus nisi veritatis ad maxime distinctio corporis, at esse. Illum repudiandae eveniet consequatur tenetur tempora! Maxime dolorem facere mollitia quae.</p>
            </div>
            <div class="col-lg-4 my-auto h-100">
                <img class="img-fluid" src="images/plane.jpg" alt="plane">
            </div>
        </div>
    </div>


    <?php require('includes/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>