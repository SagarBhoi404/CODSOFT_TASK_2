<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('includes/conn.php');
} else {
    header('location: login.php');
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Travel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>
    <?php require('includes/header.php') ?>

    <div class="container my-5">
        <h3 class="text-center mb-4">My Flights</h3>
        <?php
        $getTicketsSql = "SELECT DISTINCT flight_id FROM `ticket` WHERE `user_id` =" . $_SESSION['user_id'];
        $getTicketsResult = mysqli_query($conn, $getTicketsSql);
        while ($row = mysqli_fetch_assoc($getTicketsResult)) {
            $flight_id = $row['flight_id'];
            $sql = "SELECT * FROM flights WHERE id = $flight_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="row text-center shadow p-4" style="background-color: #ecf2fd;">
                <div class="col-3">
                    <h3><?php echo $row['source'] ?></h3>
                    <h6>Scheduled Departure:</h6>
                    <h5><?php echo $row['departure'] ?></h5>
                </div>
                <div class="col-3 d-flex justify-content-center align-items-center">
                    <?php
                    if ($row['status'] == NULL) {
                        echo '
                        <i class="bi bi-airplane-fill fs-2 text-primary" style="transform: rotate(90deg);"></i>
                        <hr class="w-100 bg-dark" style="height: 2px;">
                        <span><i class="bi bi-circle-fill"></i></span>
                        ';
                    } else if ($row['status'] == 'departed') {
                        echo '
                        <i class="bi bi-airplane-fill fs-2 text-primary" style="transform: rotate(90deg);"></i>
                        <hr class="w-100 bg-dark" style="height: 2px;">
                        <span><i class="bi bi-circle-fill"></i></span>
                        ';
                    } else if ($row['status'] == 'arrived') {
                        echo '<span><i class="bi bi-circle-fill text-success"></i></span>
                        <hr class="w-100 bg-dark text-success" style="height: 2px;">
                        <i class="bi bi-airplane-fill fs-2 text-success" style="transform: rotate(90deg);"></i>';
                    }
                    ?>
            
                </div>
                <div class="col-3">
                    <h3><?php echo $row['Destination'] ?></h3>
                    <h6>Scheduled Arrival:</h6>
                    <h5><?php echo $row['arrivale'] ?></h5>
                </div>
                <div class="col-3 d-flex justify-content-center align-items-center">
                    <?php
                    if ($row['status'] == NULL) {
                        echo '<div class="alert alert-primary w-100 fw-bold" role="alert">
                       Not yet Departed
                     </div>';
                    } else if ($row['status'] == 'departed') {
                        echo '<div class="alert alert-info w-100 fw-bold" role="alert">
                        Departed
                      </div>';
                    } else if ($row['status'] == 'arrived') {
                        echo '<div class="alert alert-success w-100 fw-bold" role="alert">
                        Arrived
                      </div>';
                    }
                    ?>

                </div>
            </div>

        <?php
        }
        ?>
    </div>

    <?php require('includes/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="main.js"></script>
</body>

</html>