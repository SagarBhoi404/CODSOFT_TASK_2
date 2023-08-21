<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('includes/conn.php');
} else {
    header('location: login.php');
}
if (isset($_POST['type']) && $_POST['type'] == 'one_way') {
    $flight_id = mysqli_escape_string($conn, $_POST['flight_id']);
    $class = mysqli_escape_string($conn, $_POST['class']);
    $passenger = mysqli_escape_string($conn, $_POST['passenger']);

    $flightFetchSql = "SELECT * FROM flights WHERE id= $flight_id";
    $flightResult = mysqli_query($conn, $flightFetchSql);
    $row = mysqli_fetch_array($flightResult);
} else {
    $class = mysqli_escape_string($conn, $_POST['class']);
    $passenger = mysqli_escape_string($conn, $_POST['passenger']);
    $flight_id = $_POST['flight_id'];
    $allFlights = array();
    foreach ($flight_id as $value) {
        $flightFetchSql = "SELECT * FROM flights WHERE id= $value";
        $flightResult = mysqli_query($conn, $flightFetchSql);
        $row = mysqli_fetch_array($flightResult);
        $allFlights[] = $row;
    }
    $flightsTotalprice = 0;
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
            <h2 class="text-center">Pay Invoice</h2>
            <hr>
            <?php
            if ($_POST['type'] == 'one_way') {
            ?>
                <div>
                    <div class="row text-center mt-4">
                        <div class="col">
                            <div>
                                <h5 class="">Class </h5><span class="fs-5"><?php
                                                                            if ($class == "E") {
                                                                                echo "Economy";
                                                                            } else {
                                                                                echo "Business";
                                                                            } ?></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <h5 class="">Passenger </h5><span class="fs-5"><?php echo $passenger ?></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <h5 class="">Airline </h5><span class="fs-5"><?php echo $row['airline'] ?></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center mt-4">
                        <div class="col">
                            <div>
                                <h5 class="">From </h5><span class="fs-5"><?php echo $row['source'] ?></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <h5 class="">To </h5><span class="fs-5"><?php echo $row['Destination'] ?></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center mt-4">
                        <div class="col">
                            <div>
                                <h5 class="">Price </h5><span class="fs-5">
                                    <?php
                                    $total = $row['Price'] * $passenger;
                                    echo '<i class="bi bi-currency-rupee"></i>' . $total
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center mt-4">
                        <div class="col">
                            <button id="rzp-button1" class="btn btn-success rounded-0">Pay <i class="bi bi-lock-fill"></i></button>
                        </div>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div>
                    <div class="row text-center mt-4">
                        <div class="col">
                            <div>
                                <h5 class="">Class </h5><span class="fs-5"><?php
                                                                            if ($class == "E") {
                                                                                echo "Economy";
                                                                            } else {
                                                                                echo "Business";
                                                                            } ?></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <h5 class="">Passenger </h5><span class="fs-5"><?php echo $passenger ?></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                    for ($i = 0; $i < count($allFlights); $i++) {
                        $flightsTotalprice = $flightsTotalprice +  $allFlights[$i]['Price'];
                    ?>
                        <div class="row text-center mt-4">
                            <div class="col">
                                <div>
                                    <h5 class="">Airline </h5><span class="fs-5"><?php echo $allFlights[$i]['airline'] ?></span>
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <h5 class="">From </h5><span class="fs-5"><?php echo $allFlights[$i]['source'] ?></span>
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <h5 class="">To </h5><span class="fs-5"><?php echo $allFlights[$i]['Destination'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <hr>
                    <div class="row text-center mt-4">
                        <div class="col">
                            <div>
                                <h5 class="">Price </h5><span class="fs-5">
                                    <?php
                                    $total = $flightsTotalprice * $passenger;
                                    echo '<i class="bi bi-currency-rupee"></i>' . $total
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center mt-4">
                        <div class="col">
                            <button id="rzp-button1" class="btn btn-success rounded-0">Pay <i class="bi bi-lock-fill"></i></button>
                            <button onclick="paytest()" class="btn btn-success rounded-0">Pay Test<i class="bi bi-lock-fill"></i></button>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php require('includes/footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="main.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "Enter Your Razorpay Key ID", // Enter the Key ID generated from the Dashboard
            "amount": "<?php
                        if ($_POST['type'] == 'one_way') {
                            echo ($row['Price'] * $passenger);
                        } else {
                            echo ($flightsTotalprice * $passenger);
                        }
                        ?>00", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            "currency": "INR",
            "name": "Online Travel Booking",
            "description": "Online Travel Booking - Developed by Sagar Bhoi.",
            "image": "images/logo.png",
            "notes": {
                "address": "Online Travel Booking"
            },
            "theme": {
                "color": "#3399cc"
            },
            "handler": function(response) {
                $.ajax({
                    url: "api/ticket_book.php",
                    type: "POST",
                    data: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        <?php
                        for ($i = 0; $i < $passenger; $i++) {

                            echo ' f_name' . $i . ': "' . $_POST['f_name' . $i] . '",
                            m_name' . $i . ': "' . $_POST['m_name' . $i] . '",
                            l_name' . $i . ': "' . $_POST['l_name' . $i] . '",
                            mobile' . $i . ': "' . $_POST['mobile' . $i] . '",
                            dob' . $i . ': "' . $_POST['dob' . $i] . '",';
                        }
                        ?>
                        flight_id: "<?php
                                    if ($_POST['type'] == 'one_way') {
                                        echo $flight_id;
                                    } else {
                                        echo implode(',', $flight_id);
                                    }
                                    ?>",
                        class: "<?php echo $class ?>",
                        passenger: "<?php echo $passenger ?>",
                        cost: "<?php echo ($row['Price'] * $passenger); ?>",
                        airline: '<?php
                                    if ($_POST['type'] == 'one_way') {
                                        echo $row['airline'];
                                    } else {
                                        $airlines = array();
                                        for ($i = 0; $i < count($allFlights); $i++) {
                                            $airlines[] = $allFlights[$i]['airline'];
                                        }
                                        echo json_encode($airlines);
                                    }
                                    ?>',
                        type: "<?php echo $_POST['type'] ?>"
                    },
                    success: function(result) {
                        window.location = "./my_tickets.php";
                    }
                });
            }

        };
        var rzp1 = new Razorpay(options);
        document.getElementById('rzp-button1').onclick = function(e) {
            rzp1.open();
            e.preventDefault();
        }
    </script>


    <script>
        function paytest() {

            $.ajax({
                url: "api/ticket_book.php",
                type: "POST",
                data: {
                    <?php
                    for ($i = 0; $i < $passenger; $i++) {

                        echo ' f_name' . $i . ': "' . $_POST['f_name' . $i] . '",
                            m_name' . $i . ': "' . $_POST['m_name' . $i] . '",
                            l_name' . $i . ': "' . $_POST['l_name' . $i] . '",
                            mobile' . $i . ': "' . $_POST['mobile' . $i] . '",
                            dob' . $i . ': "' . $_POST['dob' . $i] . '",';
                    }
                    ?>
                    flight_id: "<?php
                                if ($_POST['type'] == 'one_way') {
                                    echo $flight_id;
                                } else {
                                    echo implode(',', $flight_id);
                                }
                                ?>",
                    class: "<?php echo $class ?>",
                    passenger: "<?php echo $passenger ?>",
                    cost: "<?php echo ($row['Price'] * $passenger); ?>",
                    airline: '<?php
                                if ($_POST['type'] == 'one_way') {
                                    echo $row['airline'];
                                } else {
                                    $airlines = array();
                                    for ($i = 0; $i < count($allFlights); $i++) {
                                        $airlines[] = $allFlights[$i]['airline'];
                                    }
                                    echo json_encode($airlines);
                                }
                                ?>',
                    type: "<?php echo $_POST['type'] ?>"
                },
                success: function(result) {
                   console.log(result);
                }
            });
        }
    </script>
</body>

</html>