<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('../includes/conn.php');
} else {
    header('location: login.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flights - Online Travel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <?php require('includes/header.php') ?>

    <div class="container">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="my-3 py-3 position-relative">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary rounded-0 position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="bi bi-plus-lg"></i> Add Flights
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Flight</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="api/api_flight.php" method="post">
                            <div class="modal-body">
                                <h5>DEPARTURE</h5>
                                <div class="row p-3">
                                    <div class="col">
                                        <input type="date" class="form-control" name="departure_date" required>
                                    </div>
                                    <div class="col">
                                        <input type="time" class="form-control" name="departure_time" required>
                                    </div>
                                </div>
                                <h5>ARRIVAL</h5>
                                <div class="row p-3">
                                    <div class="col">
                                        <input type="date" class="form-control" name="arrival_date" required>
                                    </div>
                                    <div class="col">
                                        <input type="time" class="form-control" name="arrival_time" required>
                                    </div>
                                </div>
                                <div class="row p-3">
                                    <div class="col">
                                        <h5>From</h5>
                                        <select class="form-select" name="from" aria-label="Default select example">
                                            <option value="0" selected="" disabled="">Departure</option>
                                            <?php
                                            $citySql = "SELECT * FROM city ORDER BY name";
                                            $cityResult = mysqli_query($conn, $citySql);
                                            while ($row = mysqli_fetch_assoc($cityResult)) {
                                                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <h5>To</h5>
                                        <select class="form-select" name="to" aria-label="Default select example">
                                            <option selected="" disabled="">Arrival</option>
                                            <?php
                                            $citySql = "SELECT * FROM city ORDER BY name";
                                            $cityResult = mysqli_query($conn, $citySql);
                                            while ($row = mysqli_fetch_assoc($cityResult)) {
                                                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row p-3">
                                    <div class="col">
                                        <h5>Duration</h5>
                                        <input type="text" name="duration" placeholder="Duration" class="form-control" id="">
                                    </div>
                                    <div class="col">
                                        <h5>Price</h5>
                                        <input type="text" name="price" placeholder="Price" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="row p-3">
                                    <div class="col">
                                        <select class="form-select" name="airline" aria-label="Default select example">
                                            <option value="0" selected="" disabled="">Select Airline</option>
                                            <?php
                                            $airlineSql = "SELECT * FROM airline ORDER BY name";
                                            $airlineResult = mysqli_query($conn, $airlineSql);
                                            while ($row = mysqli_fetch_assoc($airlineResult)) {
                                                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success rounded-0"><i class="bi bi-plus-lg"></i> Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3">
            <h4 class="text-center">Flights List</h4>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Arrival</th>
                        <th scope="col">Departure</th>
                        <th scope="col">Source</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Airline</th>
                        <th scope="col">Seats</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fetchDataSql = "SELECT * FROM flights";
                    $fdresult = mysqli_query($conn, $fetchDataSql);
                    $sr = 1;
                    while ($row = mysqli_fetch_array($fdresult)) {
                        echo '<tr>
                        <th scope="row">' . $sr . '</th>
                        <td>' . $row['arrivale'] . '</td>
                        <td>' . $row['departure'] . '</td>
                        <td>' . $row['source'] . '</td>
                        <td>' . $row['Destination'] . '</td>
                        <td>' . $row['airline'] . '</td>
                        <td>' . $row['Seats'] . '</td>
                        <td><i class="bi bi-currency-rupee"></i>' . $row['Price'] . '</td>
                        <td><a class="text-danger" href="api/api_flight.php?del=' . $row['id'] . '"><h5><i class="bi bi-trash"></i></h5></a></td>
                    </tr>';
                        $sr++;
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