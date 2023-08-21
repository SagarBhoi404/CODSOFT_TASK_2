<?php
require('includes/conn.php');
session_start();
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
</head>

<body>
    <?php require('includes/header.php') ?>

    <div class="container mb-5">
        <div class="px-4 py-5 my-5 text-center">
            <img class="d-block mx-auto mb-4" src="images/logo.png" alt="" width="72" height="57">
            <h1 class="display-5 fw-bold text-body-emphasis">Embark on Seamless Journeys with Our Flight Travel Booking Services!</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Discover the world with ease through our advanced flight travel booking platform. Whether you're planning a spontaneous getaway or a meticulously planned itinerary, we've got you covered. Our user-friendly interface lets you effortlessly search, compare, and book flights to your dream destinations.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="#searchBox" class="btn custom-btn">Let's Search Flight</a>
                </div>
            </div>
        </div>
        <div class="bookingCard bg-light shadow" id="searchBox">
            <div class="p-3">
                <ul class="nav nav-underline mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" id="round_trip_btn" type="button" onclick="tab_change('one_way')">Round Trip</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="one_way_btn" type="button" onclick="tab_change('round_trip')">One Way</a>
                    </li>
                </ul>
            </div>
            <div id="round_trip">
                <form action="round_trip.php" method="post">
                    <div class="container">
                        <div class="row p-3">
                            <div class="col">
                                <h5>From</h5>
                                <select class="form-select" name="from" aria-label="Default select example" required>
                                    <option value="" selected="" disabled="">Departure</option>
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
                                <select class="form-select" name="to" aria-label="Default select example" required>
                                    <option value="" selected="" disabled="">Arrival</option>
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
                    </div>
                    <div class="container">
                        <div class="row p-3">
                            <div class="col">
                                <h5>Depart</h5>
                                <input type="date" name="depart" class="form-control" required> 
                            </div>
                            <div class="col">
                                <h5>Return</h5>
                                <input type="date" name="return" class="form-control" required>
                            </div>
                            <div class="col">
                                <h5>Class</h5>
                                <select class="form-select" name="class" aria-label="Default select example" required>
                                    <option value="E">Economy</option>
                                    <option value="B">Business</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row p-3">
                            <div class="col">
                                <h5>Passenger</h5>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-secondary" onclick="passenger_value_decrease_RT()">-</button>
                                    <input type="text" readonly class="form-control mx-3 text-center" id="passenger" value="1" name="passenger" style="width: 70px;">
                                    <button type="button" class="btn btn-secondary" onclick="passenger_value_increase_RT()">+</button>
                                </div>
                            </div>
                            <div class="col d-flex align-self-end justify-self-end">
                                <button type="submit" class="btn custom-btn rounded-0 w-100 ms-auto">Search Flights</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="one_way" hidden>
                <form action="one_way.php" method="post">
                    <div class="container">
                        <div class="row p-3">
                            <div class="col">
                                <h5>From</h5>
                                <select class="form-select" name="from" required>
                                    <option value="" selected="" disabled="">Departure</option>
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
                                <select class="form-select" name="to" required>
                                    <option value="" selected="" disabled="">Arrival</option>
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
                    </div>
                    <div class="container">
                        <div class="row p-3">
                            <div class="col">
                                <h5>Depart</h5>
                                <input type="date" name="depart" class="form-control" required>
                            </div>
                            <div class="col">
                                <h5>Class</h5>
                                <select class="form-select" name="class" required>
                                    <option value="E">Economy</option>
                                    <option value="B">Business</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row p-3">
                            <div class="col">
                                <h5>Passenger</h5>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-secondary" onclick="passenger_value_decrease_OW()">-</button>
                                    <input type="text" readonly class="form-control mx-3 text-center" id="passenger1" value="1" name="passenger" style="width: 70px;" required>
                                    <button type="button" class="btn btn-secondary" onclick="passenger_value_increase_OW()">+</button>
                                </div>
                            </div>
                            <div class="col d-flex align-self-end justify-self-end">
                                <button type="submit" class="btn custom-btn rounded-0 w-100 ms-auto">Search Flights</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <?php require('includes/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script src="main.js"></script>
</body>

</html>