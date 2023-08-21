<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    require('../includes/conn.php');
} else {
    header('location: ../login.php');
}

if (isset($_POST['type']) && $_POST['type'] == 'one_way') {
    $class = mysqli_escape_string($conn, $_POST['class']);
    $passenger = mysqli_escape_string($conn, $_POST['passenger']);
    $flight_id = mysqli_escape_string($conn, $_POST['flight_id']);
    $razorpay_payment_id = mysqli_escape_string($conn, $_POST['razorpay_payment_id']);
    $airline = mysqli_escape_string($conn, $_POST['airline']);

    $cost = mysqli_escape_string($conn, $_POST['cost']);
    $user_id = mysqli_escape_string($conn, $_SESSION['user_id']);

    $getSql = "SELECT seat_no FROM ticket WHERE ticket.flight_id = $flight_id AND ticket.class='$class'";
    $getResult = mysqli_query($conn, $getSql);
    $getRow = mysqli_fetch_array($getResult);

    $TotalBookedSeats = $getRow == null ? [] : $getRow;

    $getClassTotalSeatsSql = "SELECT * FROM airline WHERE name = '$airline'";
    $getClassTotalSeatResult = mysqli_query($conn, $getClassTotalSeatsSql);
    $getClassTotalSeatRow = mysqli_fetch_array($getClassTotalSeatResult);

    $TotalSeats = 0;
    if ($class == 'E') {
        $TotalSeats = $getClassTotalSeatRow['economy_seats'];
    } else {
        $TotalSeats = $getClassTotalSeatRow['business_seats'];
    }
    $couterTemp = 1;
    for ($i = 0; $i < $passenger; $i++) {
        $seatNO = getSeatID($TotalSeats);
        if (!in_array($seatNO, $TotalBookedSeats)) {
            $f_name = mysqli_escape_string($conn, $_POST['f_name' . $i]);
            $m_name = mysqli_escape_string($conn, $_POST['m_name' . $i]);
            $l_name = mysqli_escape_string($conn, $_POST['l_name' . $i]);
            $mobile = mysqli_escape_string($conn, $_POST['mobile' . $i]);
            $dob = mysqli_escape_string($conn, $_POST['dob' . $i]);

            $passengerSql = "INSERT INTO `passenger_profile`(`user_id`, `flight_id`, `mobile`, `dob`, `f_name`, `m_name`, `l_name`) VALUES ('$user_id','$flight_id','$mobile','$dob','$f_name','$m_name','$l_name')";
            $passengerResult = mysqli_query($conn, $passengerSql);
            if ($passengerResult) {
                $passenger_id = mysqli_insert_id($conn);
                $ticketSql = "INSERT INTO `ticket`(`user_id`, `passenger_id`, `flight_id`, `seat_no`, `cost`, `class`, `payment_id`, `payment_status`) VALUES ('$user_id','$passenger_id','$flight_id','$seatNO','$cost','$class','$razorpay_payment_id','SUCCESS')";
                $ticketResult = mysqli_query($conn, $ticketSql);
                $couterTemp++;
            }
        }
        if ($couterTemp == $passenger) {
            echo 1;
        }
    }
} else {
    $class = mysqli_escape_string($conn, $_POST['class']);
    $passenger = mysqli_escape_string($conn, $_POST['passenger']);
    $flight_id =  explode(',', $_POST['flight_id']);
    $razorpay_payment_id = mysqli_escape_string($conn, $_POST['razorpay_payment_id']);
    $airlines = json_decode($_POST['airline']);

    $cost = mysqli_escape_string($conn, $_POST['cost']);
    $user_id = mysqli_escape_string($conn, $_SESSION['user_id']);

    $couterTemp = 1;
    for ($j = 0; $j < count($flight_id); $j++) {

        $getSql = "SELECT seat_no FROM ticket WHERE ticket.flight_id = $flight_id[$j] AND ticket.class='$class'";
        $getResult = mysqli_query($conn, $getSql);
        $getRow = mysqli_fetch_array($getResult);

        $TotalBookedSeats = $getRow == null ? [] : $getRow;

        $getClassTotalSeatsSql = "SELECT * FROM airline WHERE name = '$airlines[$j]'";
        $getClassTotalSeatResult = mysqli_query($conn, $getClassTotalSeatsSql);
        $getClassTotalSeatRow = mysqli_fetch_array($getClassTotalSeatResult);

        $TotalSeats = 0;
        if ($class == 'E') {
            $TotalSeats = $getClassTotalSeatRow['economy_seats'];
        } else {
            $TotalSeats = $getClassTotalSeatRow['business_seats'];
        }
        for ($i = 0; $i < $passenger; $i++) {
            $seatNO = getSeatID($TotalSeats);
            if (!in_array($seatNO, $TotalBookedSeats)) {
                $f_name = mysqli_escape_string($conn, $_POST['f_name' . $i]);
                $m_name = mysqli_escape_string($conn, $_POST['m_name' . $i]);
                $l_name = mysqli_escape_string($conn, $_POST['l_name' . $i]);
                $mobile = mysqli_escape_string($conn, $_POST['mobile' . $i]);
                $dob = mysqli_escape_string($conn, $_POST['dob' . $i]);

                $passengerSql = "INSERT INTO `passenger_profile`(`user_id`, `flight_id`, `mobile`, `dob`, `f_name`, `m_name`, `l_name`) VALUES ('$user_id','$flight_id[$j]','$mobile','$dob','$f_name','$m_name','$l_name')";
                $passengerResult = mysqli_query($conn, $passengerSql);
                if ($passengerResult) {
                    $passenger_id = mysqli_insert_id($conn);
                    $ticketSql = "INSERT INTO `ticket`(`user_id`, `passenger_id`, `flight_id`, `seat_no`, `cost`, `class`, `payment_id`, `payment_status`) VALUES ('$user_id','$passenger_id','$flight_id[$j]','$seatNO','$cost','$class','$razorpay_payment_id','SUCCESS')";
                    $ticketResult = mysqli_query($conn, $ticketSql);
                    if ($couterTemp == $passenger) {
                        echo 1;
                    }
                }
            }
        }
        $couterTemp++;
    }
}





function getSeatID($numberofseats)
{
    $numberofseats = $numberofseats;
    $businessArray = [];
    $Col = ['A', 'B', 'C', 'D', 'E', 'F'];
    $TotalCol = 6;
    $temp = 1;
    for ($j = 0; $j < floor($numberofseats / $TotalCol); $j++) {
        for ($i = 0; $i < $TotalCol; $i++) {
            $businessArray[] = $temp . $Col[$i];
            $temp++;
        }
    }
    return $businessArray[rand(0, $numberofseats)];
}
