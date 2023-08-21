<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('../includes/conn.php');
    $today = date("Y-m-d");
} else {
    header('location: login.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Online Travel Booking </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <?php require('includes/header.php') ?>

    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3 mt-3 col-12">
                <div class="text-center rounded shadow-sm p-2" style="background: lightgoldenrodyellow;">
                    <i class="bi bi-person-fill" style="font-size: xxx-large;"></i>
                    <h5>Total Passengers</h5>
                    <p class="fw-bold">
                        <?php
                        $passenSql = "SELECT COUNT(*) AS Total FROM `passenger_profile`";
                        $passenResult = mysqli_query($conn, $passenSql);
                        $row = mysqli_fetch_array($passenResult);
                        echo $row['Total'];
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-3 mt-3 col-12">
                <div class="text-center rounded shadow-sm p-2" style="background: lightpink;">
                    <i class="bi bi-currency-rupee" style="font-size: xxx-large;"></i>
                    <h5>Amount</h5>
                    <p class="fw-bold">
                        <?php
                        $passenSql = "SELECT sum(cost) AS Total FROM `ticket`";
                        $passenResult = mysqli_query($conn, $passenSql);
                        $row = mysqli_fetch_array($passenResult);
                        echo $row['Total'];
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-3 mt-3 col-12">
                <div class="text-center rounded shadow-sm p-2" style="background: lightblue;">
                    <i class="bi bi-airplane-engines-fill" style="font-size: xxx-large;"></i>
                    <h5>Flights</h5>
                    <p class="fw-bold">
                        <?php
                        $passenSql = "SELECT COUNT(*) AS Total FROM `flights`";
                        $passenResult = mysqli_query($conn, $passenSql);
                        $row = mysqli_fetch_array($passenResult);
                        echo $row['Total'];
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-3 mt-3 col-12">
                <div class="text-center rounded shadow-sm p-2" style="background: lightsteelblue;">
                    <i class="bi bi-airplane-fill" style="font-size: xxx-large;"></i>
                    <h5>Available Airlines</h5>
                    <p class="fw-bold">
                        <?php
                        $passenSql = "SELECT COUNT(*) AS Total FROM `airline`";
                        $passenResult = mysqli_query($conn, $passenSql);
                        $row = mysqli_fetch_array($passenResult);
                        echo $row['Total'];
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="my-5 p-3 shadow">
            <h3 class="text-secondary">Today's Flights</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Arrival</th>
                        <th scope="col">Departure</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Source</th>
                        <th scope="col">Airlines</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `flights` WHERE `departure` LIKE '$today%' AND `status` IS NULL";
                    $result = mysqli_query($conn,$sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                        <th scope="row">'.$row['id'].'</th>
                        <td>'.$row['arrivale'].'</td>
                        <td>'.$row['departure'].'</td>
                        <td>'.$row['Destination'].'</td>
                        <td>'.$row['source'].'</td>
                        <td>'.$row['airline'].'</td>
                        <td>
                            <a href="api/api_utils.php?id='.$row['id'].'&status=departed" class="btn btn-danger btn-sm">Departed</a>
                        </td>
                    </tr>';
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>

        <div class="my-5 p-3 shadow">
            <h3 class="text-secondary">Flights Departed Today</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Arrival</th>
                        <th scope="col">Departure</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Source</th>
                        <th scope="col">Airlines</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `flights` WHERE `departure` LIKE '$today%' AND `status` = 'departed'";
                    $result = mysqli_query($conn,$sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                        <th scope="row">'.$row['id'].'</th>
                        <td>'.$row['arrivale'].'</td>
                        <td>'.$row['departure'].'</td>
                        <td>'.$row['Destination'].'</td>
                        <td>'.$row['source'].'</td>
                        <td>'.$row['airline'].'</td>
                        <td>
                            <a href="api/api_utils.php?id='.$row['id'].'&status=arrived" class="btn btn-danger btn-sm">Arrived</a>
                        </td>
                    </tr>';
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>

        <div class="my-5 p-3 shadow">
            <h3 class="text-secondary">Flights Arrived Today</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Arrival</th>
                        <th scope="col">Departure</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Source</th>
                        <th scope="col">Airlines</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `flights` WHERE `departure` LIKE '$today%' AND `status` = 'arrived'";
                    $result = mysqli_query($conn,$sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                        <th scope="row">'.$row['id'].'</th>
                        <td>'.$row['arrivale'].'</td>
                        <td>'.$row['departure'].'</td>
                        <td>'.$row['Destination'].'</td>
                        <td>'.$row['source'].'</td>
                        <td>'.$row['airline'].'</td>
                    </tr>';
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>

    <?php require('includes/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script src="main.js"></script>
</body>

</html>