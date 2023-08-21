<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('includes/conn.php');
} else {
    header('location: login.php');
}

if (isset($_GET['type']) && $_GET['type'] == "one_way") {
    $flight_id = mysqli_escape_string($conn, $_POST['flight_id']);
    $class = mysqli_escape_string($conn, $_POST['class']);
    $passenger = mysqli_escape_string($conn, $_POST['passenger']);
} else {
    if (isset($_POST['flight_Id'])) {
        $flight_id = $_POST['flight_Id'];
        $class = mysqli_escape_string($conn, $_POST['class']);
        $passenger = mysqli_escape_string($conn, $_POST['passenger']);
    } else {
        echo "<script>
        alert('Please Select Flights')
        window.location = './index.php'
    </script>";
    }
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
</head>

<body>
    <?php require('includes/header.php') ?>

    <div class="container my-5">
        <div class="bookingCard bg-light p-3 shadow">
            <h2 class="text-center">Passenger Details</h2>
            <hr>
            <form action="payment.php" method="post">
                <?php
                for ($i = 0; $i < $passenger; $i++) {

                ?>
                    <div class="container">
                        <div class="row p-3">
                            <div class="col">
                                <h5>First Name</h5>
                                <input type="text" name="f_name<?php echo $i; ?>" class="form-control" placeholder="Enter First Name" required>
                            </div>
                            <div class="col">
                                <h5>Middle Name</h5>
                                <input type="text" name="m_name<?php echo $i; ?>" class="form-control" placeholder="Enter Middle Name" required>
                            </div>
                            <div class="col">
                                <h5>Last Name</h5>
                                <input type="text" name="l_name<?php echo $i; ?>" class="form-control" placeholder="Enter Last Name" required>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col">
                                <h5>Contact Number</h5>
                                <input type="text" name="mobile<?php echo $i; ?>" class="form-control" placeholder="Contact Number" pattern="[0-9]{10}" required>
                            </div>
                            <div class="col">
                                <h5>DOB</h5>
                                <input type="date" name="dob<?php echo $i; ?>" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php
                }
                ?>
                <?php
                if ($_GET['type'] == "one_way") {
                    echo '<input type="text" name="flight_id" value="' . $flight_id . '" hidden readonly>';
                } else {
                    foreach ($flight_id as $value) {
                        echo '<input type="text" name="flight_id[]" value="' . $value . '" hidden readonly>';
                    }
                }
                ?>

                <input type="text" name="class" value="<?php echo $class; ?>" hidden readonly>
                <input type="text" name="passenger" value="<?php echo $passenger; ?>" hidden readonly>
                <input type="text" name="type" value="<?php echo $_GET['type']; ?>" hidden readonly>
                <div class="row p-3">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary rounded-0">Proceed <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require('includes/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script src="main.js"></script>
</body>

</html>