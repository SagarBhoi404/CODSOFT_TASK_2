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
        <h3 class="text-center mb-4">E-TICKETS</h3>
        <?php
        $getTicketsSql = "SELECT * FROM ticket WHERE user_id =" . $_SESSION['user_id'];
        $getTicketsResult = mysqli_query($conn, $getTicketsSql);
        while ($row = mysqli_fetch_assoc($getTicketsResult)) {
            $flight_id = $row['flight_id'];
            $passenger_id = $row['passenger_id'];

            $getSql = "SELECT * 
            FROM flights, passenger_profile 
            WHERE flights.id = $flight_id AND passenger_profile.id=$passenger_id";
            $getResult = mysqli_query($conn, $getSql);

            $getRow = mysqli_fetch_assoc($getResult);
        ?>
            <div id="ticket<?php echo $row['id']; ?>" class="row shadow rounded mb-1" style="background-color: #F6F4EB;">
                <div class="col-9">
                    <div>
                        <h3 class="text-center">Online Flight Booking</h3>
                        <hr>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <p>AIRLINE</p>
                            <h5><?php echo $getRow['airline']; ?></h5>
                        </div>
                        <div class="col">
                            <p>FROM</p>
                            <h5><?php echo $getRow['source']; ?></h5>
                        </div>
                        <div class="col">
                            <p>TO</p>
                            <h5><?php echo $getRow['Destination']; ?></h5>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <p>PASSENGER</p>
                            <h5><?php echo $getRow['f_name'] . " " . $getRow['m_name'] . " " . $getRow['l_name']; ?></h5>
                        </div>
                        <div class="col">
                            <p>CLASS</p>
                            <h5><?php echo $row['class'] == 'E' ? 'Economy' : 'Business'; ?></h5>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <p>DEPARTURE</p>
                            <h5><?php echo $getRow['departure']; ?></h5>
                        </div>
                        <div class="col">
                            <p>ARRIVAL</p>
                            <h5><?php echo $getRow['arrivale']; ?></h5>
                        </div>
                        <div class="col">
                            <p>SEAT</p>
                            <h5><?php echo $row['seat_no']; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-3 rounded-end d-flex flex-column justify-content-center aligns-items-center" style="background-color: #4682A9;">
                    <div class="text-center text-white">
                        <img src=".//images/logo.png" alt="" width="100" height="100">
                        <h4>Online Travel Booking</h4>
                    </div>
                </div>

            </div>
            <div class="text-end">
                <button class="mb-5 btn btn-success" onclick="print_ticket(<?php echo $row['id']; ?>)">Download Ticket <i class="bi bi-download"></i></button>
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