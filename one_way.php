<?php
session_start();
require('includes/conn.php');

if (isset($_POST['from'])) {
    $source = mysqli_escape_string($conn, $_POST['from']);
    $Destination = mysqli_escape_string($conn, $_POST['to']);
    $departure = mysqli_escape_string($conn, $_POST['depart']);
    $class = mysqli_escape_string($conn, $_POST['class']);
    $passenger = mysqli_escape_string($conn, $_POST['passenger']);

    $searchSql = "SELECT * FROM `flights` WHERE `source` = '$source' AND `Destination` = '$Destination' AND `departure` Like '$departure%'";
    $searchResult = mysqli_query($conn, $searchSql);
}

?>

<?php
require('includes/conn.php');
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

    <div class="container my-5 text-center">
        <h3>FLIGHTS FROM:</h3>
        <h3><?php echo $source . " To " . $Destination; ?></h3>
        <div class="my-3">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Airline</th>
                        <th scope="col">Departure</th>
                        <th scope="col">Arrival</th>
                        <th scope="col">Status</th>
                        <th scope="col">Price</th>
                        <th scope="col">Buy</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($searchResult)) {
                        echo '<tr>
                        <form action="passenger_form.php?type=one_way" method="post">
                        <input type="text" name="flight_id" value="' . $row['id'] . '" hidden readonly>
                        <input type="text" name="class" value="' . $class . '" hidden readonly>
                        <input type="text" name="passenger" value="' . $passenger . '" hidden readonly>
                        <td>' . $row['airline'] . '</td>
                        <td>' . $row['departure'] . '</td>
                        <td>' . $row['arrivale'] . '</td>';
                        if ($row['status'] == NULL) {
                            echo '<td><div class="alert alert-primary m-0 p-0 fw-bold" role="alert">
                           Not yet Departed
                         </div></td>';
                        } else if ($row['status'] == 'departed') {
                            echo '<td><div class="alert alert-info m-0 p-0 fw-bold" role="alert">
                            Departed
                          </div></td>';
                        } else if ($row['status'] == 'arrived') {
                            echo '<td><div class="alert alert-success m-0 p-0 fw-bold" role="alert">
                            Arrived
                          </div></td>';
                        }

                        echo '<td><i class="bi bi-currency-rupee"></i>' . $row['Price'] . '</td>';

                        $availSql = "SELECT * FROM `flights` , `ticket` ,`airline` WHERE flights.source = '$source' AND flights.Destination = '$Destination' AND flights.departure Like '$departure%' AND airline.name ='" . $row['airline'] . "'";
                        $availResult = mysqli_query($conn, $availSql);
                        $BookSeatsTotal = 0;
                        $SeatsTotal = 0;
                        while ($availrow = mysqli_fetch_assoc($availResult)) {
                            if ($class == $availrow['class']) {
                                if ($availrow['seat_no'] != Null && $availrow['seat_no'] != '') {
                                    $BookSeatsTotal++;
                                }
                            }
                            if ($class == 'E') {
                                $SeatsTotal = $availrow['economy_seats'];
                            } else {
                                $SeatsTotal = $availrow['business_seats'];
                            }
                        }


                        if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
                            if ($row['status'] == NULL) {
                                if ((intval($SeatsTotal) - $BookSeatsTotal) <= intval($passenger) || (intval($SeatsTotal) - $BookSeatsTotal) >= intval($passenger)) {
                                    echo '<td><button type="submit" class="btn btn-danger btn-sm">Book Now</button></td>
                                </tr>';
                                } else {
                                    echo "<td class='text-danger fw-bold'>Seats Not Available</td>
                                </form>
                                ";
                                }
                            } else {
                                echo "<td class=''></td>
                                </form>
                                ";
                            }
                        } else {
                            echo "<td>Login to continue</td>
                            </form>
                            ";
                        }
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