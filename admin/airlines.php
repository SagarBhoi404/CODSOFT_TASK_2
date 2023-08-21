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
    <title>Airlines - Online Travel Booking</title>
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
                <i class="bi bi-plus-lg"></i> Add Airlines
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Airline</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="api/api_airlines.php" method="post">
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" class="form-control" name="airline_name" placeholder="Airline name" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" name="total_seats" placeholder="Total seats" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" class="form-control" name="business_seats" placeholder="Business Seats" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" name="economy_seats" placeholder="Economy Seats" required>
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
            <h4 class="text-center">Airlines List</h4>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Seats</th>
                        <th scope="col">Business</th>
                        <th scope="col">Economy</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fetchDataSql = "SELECT * FROM airline";
                    $fdresult = mysqli_query($conn, $fetchDataSql);
                    $sr = 1;
                    while ($row = mysqli_fetch_array($fdresult)) {
                        echo '<tr>
                        <th scope="row">'.$sr.'</th>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['seats'].'</td>
                        <td>'.$row['business_seats'].'</td>
                        <td>'.$row['economy_seats'].'</td>
                        <td><a class="text-danger" href="api/api_airlines.php?del='.$row['id'].'"><h5><i class="bi bi-trash"></i></h5></a></td>
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