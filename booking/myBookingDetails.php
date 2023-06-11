<?php
include '../database.php';
$route_ID = $_SESSION['bRouteID'];
$route_CarID = $_SESSION['bRouteCarID'];
$user_ID = $_SESSION['login_ID'];
$bookingID = $_SESSION['bBookingID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Route Details</title>
    <style>
        h2 {
            text-align: center;
        }

        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
        }

        #cancel {
            background-color: #a5a5a5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        #start {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        #book {
            padding-left: 45px;
            padding-right: 45px;
        }

        #overlay {
            position: fixed;
            display: none;
            align-items: center;
            justify-content: center;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30%;
            min-height: 60%;
            background-color: white;
            border-radius: 20px;
            z-index: 2;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 5),
                0 4px 8px rgba(0, 0, 0, .2),
                0 2px 4px rgba(0, 0, 0, .2);
        }

        #closeButton {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        input[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-bottom: 10px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #d2ffd3;
            border: 1px solid;
            border-radius: 15px;
            width: 80%;
            padding: 15px;
        }

        .item.reserved {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffd2bc;
            border: 1px solid;
            border-radius: 15px;
            width: 80%;
            padding: 15px;

        }

        .confirmation {
            position: fixed;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            text-align: center;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20%;
            min-height: 20%;
            background-color: white;
            border-radius: 20px;
            z-index: 2;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 5),
                0 4px 8px rgba(0, 0, 0, .2),
                0 2px 4px rgba(0, 0, 0, .2);
        }
    </style>
</head>

<body>
    <form action="submit.php" method="post">
        <?php
        $sql = "SELECT * FROM route WHERE route_ID = '$route_ID'";
        $result = $conn->query($sql);
        echo '<input type="hidden" name="route_ID" value="' . $route_ID . '">';
        while ($row = $result->fetch_assoc()) :
            $departValue = $row['route_Depart'];
            $arriveValue = $row['route_Arrival'];
            $dateValue = $row['route_Date'];
            $formattedDate = date("F d, Y", strtotime($dateValue));
            $depart = date("h:i A", strtotime($departValue));
            $arrive = date("h:i A", strtotime($arriveValue));
            $_SESSION['routeDriver'] = $row['user_ID'];
            $driver =  $row['user_ID'];
            $_SESSION['routeStatus'] = $row['route_Status'];
        ?>

            <h2>Route Details</h2>
            <table>
                <tr>
                    <td>
                        <b>Date: </b>
                    </td>
                    <td>
                        <?php echo $formattedDate ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Departure Time: </b>
                    </td>
                    <td>
                        <?php echo $depart ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Est. Arrival time: </b>
                    </td>
                    <td>
                        <?php echo $arrive ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Starting Point: </b>
                    </td>
                    <td>
                        <?php echo $row['route_Start'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Ending Point: </b>
                    </td>
                    <td>
                        <?php echo $row['route_End'] ?>
                    </td>
                </tr>
            </table>
            <br><br>
            <h2>Seat Rates</h2>
            <table>
                <tr>
                    <td>
                        <b>Front Seat Rate: </b>
                    </td>
                    <td>
                        <?php echo $row['route_FrontSeat'] . " tickets" ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Window Seat Rate: </b>
                    </td>
                    <td>
                        <?php echo $row['route_SideSeat'] . " tickets" ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Middle Seat Rate: </b>
                    </td>
                    <td>
                        <?php echo $row['route_MidSeat'] . " tickets" ?>
                    </td>
                </tr>
            </table>
            <br><br>

            <?php
            $sql = "SELECT * FROM user WHERE user_ID = '$driver'";
            $result = $conn->query($sql);
            $driverRow = $result->fetch_assoc()

            ?>
            <h2>Driver Details</h2>
            <table>
                <tr>
                    <td>
                        <b>Driver:</b>
                    </td>
                    <td>
                        <?php echo $driverRow['user_FirstName'] . " " . $driverRow['user_LastName'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Driver's License:</b>
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
            <br><br>

        <?php endwhile ?>

        <?php
        $sql = "SELECT * FROM car WHERE car_ID = '$route_CarID'";
        $result = $conn->query($sql);
        $CarRow = $result->fetch_assoc()
        ?>
        <h2>Car Details</h2>
        <table>
            <tr>
                <td>
                    <b>Make & Model:</b>
                </td>
                <td>
                    <?php echo $CarRow['car_MakeModel'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Color:</b>
                </td>
                <td>
                    <?php echo $CarRow['car_Color'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Plate No.:</b>
                </td>
                <td>
                    <?php echo $CarRow['car_PlateNumber'] ?>
                </td>
            </tr>
        </table>
        <br><br>
        <?php
        $sqlBook = "SELECT * FROM booking WHERE booking_ID = '$bookingID'";
        $resultBook = $conn->query($sqlBook);
        $bookRow = $resultBook->fetch_assoc()
        ?>
        <h1 style="color: green;"><?php echo $bookRow['booking_SeatPosition'] ?></h1>
        
        <?php
        $bookings = "SELECT * FROM booking WHERE booking_ID = $bookingID";
        $booking = $conn->query($bookings);
        $rowBooking = $booking->fetch_assoc();
        $stat = $rowBooking['booking_Status'];
        if ($stat == 'Arrived') {
                echo '<b style="text-align:center">You have arrived at your destination.</b>';
            }
            ?>
        <div style="display: flex; justify-content: space-evenly;">
            <?php
            $ID = $_SESSION['login_ID'];
            $routeDriver = $_SESSION['routeDriver'];
            unset($_SESSION['routeDriver']);


            $sql = "SELECT * FROM user WHERE user_ID = '$ID'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) :
                if ($row['user_ID'] == $ID) :
                    $user_Type =  $row['user_Type'];
                endif;
            endwhile;

            $FSeat = false;
            $RSeat = false;
            $LSeat = false;
            $MSeat = false;
            $cancellable = true;

            $bookings = "SELECT * FROM booking WHERE booking_ID = $bookingID";
            $booking = $conn->query($bookings);
            $rowBooking = $booking->fetch_assoc();
            // if($rowBooking['booking_Status']){
            $stat = $rowBooking['booking_Status'];
            // }
            $statRS = $rowBooking['booking_Status'];
            $statLS = $rowBooking['booking_Status'];
            $statMS = $rowBooking['booking_Status'];
            if (($rowBooking['booking_SeatPosition'] == 'Front Seat')) {
                $FSeat = true;
            } elseif (($rowBooking['booking_SeatPosition'] == 'Left Window Seat')) {
                $LSeat = true;
            } elseif ($rowBooking['booking_SeatPosition'] == 'Right Window Seat') {
                $RSeat = true;
            } elseif ($rowBooking['booking_SeatPosition'] == 'Middle Seat') {
                $MSeat = true;
            }
            if ($FSeat == true || $LSeat == true || $RSeat == true || $MSeat == true) {
                $cancellable = false;
            }


            $status = $_SESSION['routeStatus'];
            unset($_SESSION['routeStatus']);
            if ($status == 'Waiting') {
                if ($stat == 'Scheduled') {
                    echo '<input onclick="onCar()" type="button" value="In Car">';
                } elseif ($stat == 'Inside') {
                    echo '<b style="text-align:center">The trip will start in a few minutes. Please wait for the driver to depart.</b>';
                }
            } elseif ($stat == 'Traveling') {
                echo '<input onclick="arrived()" type="button" value="Arrived">';
            } 
            if ($stat == 'Missed') {
                echo '<b style="text-align:center">You have missed the trip.</b>';
            }
            // else {
            //     echo '<input id="start" onclick="confirm()" type="button" value="Start the Session">';
            // }
            ?>
        </div>
        <br><br>

        <?php
        $sqlRoute = "SELECT * FROM route WHERE route_ID = '$route_ID'";
        $resultRoute = $conn->query($sqlRoute);
        while ($rowRoute = $resultRoute->fetch_assoc()) :
            $FSRate = $rowRoute['route_FrontSeat'];
            $SSRate = $rowRoute['route_SideSeat'];
            $MSRate = $rowRoute['route_MidSeat'];
        endwhile;

        $sql = "SELECT * FROM booking WHERE route_ID = '$route_ID'";
        $result = $conn->query($sql);
        $FS = '';
        $RS = '';
        $LS = '';
        $MS = '';

        while ($row = $result->fetch_assoc()) :
            if (($row['booking_SeatPosition'] == 'Front Seat')) {
                $FS = 'Front Seat';
            } elseif (($row['booking_SeatPosition'] == 'Left Window Seat')) {
                $LS = 'Left Window Seat';
            } elseif ($row['booking_SeatPosition'] == 'Right Window Seat') {
                $RS = 'Right Window Seat';
            } elseif ($row['booking_SeatPosition'] == 'Middle Seat') {
                $MS = 'Middle Seat';
            }
        endwhile;

        $user = "SELECT * FROM user WHERE user_ID = '$user_ID'";
        $accBal = $conn->query($user);
        while ($rowBalance = $accBal->fetch_assoc()) :
            $balance = $rowBalance['user_AccBalance'];
        endwhile;
        ?>
        <div id="overlay">
            <button id="closeButton" type="button" onclick="off()">&times;</button>
            <h2 style="padding-bottom: 10px;">Reserve Now!</h2>
            <div class="container">
                <div class="item <?php echo $FS == 'Front Seat' ? 'reserved' : ''; ?>">
                    <b>Front Seat</b>
                    <div>
                        <?php echo "₱" . $FSRate ?>
                        <?php if ($FS == "Front Seat") : ?>
                            <span class="reserved-text" style="margin-left: 30px; margin-right: 20px;"><i>Reserved</i></span>
                        <?php else : ?>
                            <input type="hidden" name="front" value="<?php echo $FSRate ?>">
                            <input name="ReserveFS" type="submit" value="Reserve" style="margin-left: 20px" onclick="return checkBalance(<?php echo $FSRate; ?>, 'ReserveFS')">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="errorContainerFS" style="text-align: center;"></div>

            <div class="container">
                <div class="item <?php echo $RS == 'Right Window Seat' ? 'reserved' : ''; ?>">
                    <b>Right Window Seat</b>
                    <div>
                        <?php echo "₱" . $SSRate ?>
                        <?php if ($RS == "Right Window Seat") : ?>
                            <span class="reserved-text" style="margin-left: 30px; margin-right: 20px;"><i>Reserved</i></span>
                        <?php else : ?>
                            <input type="hidden" name="right" value="<?php echo $SSRate ?>">
                            <input name="ReserveRS" type="submit" value="Reserve" style="margin-left: 20px" onclick="return checkBalance(<?php echo $SSRate; ?>, 'ReserveRS')">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="errorContainerRS" style="text-align: center;"></div>

            <div class="container">
                <div class="item <?php echo $LS == 'Left Window Seat' ? 'reserved' : ''; ?>">
                    <b>Left Window Seat</b>
                    <div>
                        <?php echo "₱" . $SSRate ?>
                        <?php if ($LS == "Left Window Seat") : ?>
                            <span class="reserved-text" style="margin-left: 30px; margin-right: 20px;"><i>Reserved</i></span>
                        <?php else : ?>
                            <input type="hidden" name="left" value="<?php echo $SSRate ?>">
                            <input name="ReserveLS" type="submit" value="Reserve" style="margin-left: 20px" onclick="return checkBalance(<?php echo $SSRate; ?>, 'ReserveLS')">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="errorContainerLS" style="text-align: center;"></div>

            <div class="container">
                <div class="item <?php echo $MS == 'Middle Seat' ? 'reserved' : ''; ?>">
                    <b>Middle Seat</b>
                    <div>
                        <?php echo "₱" . $MSRate ?>
                        <?php if ($MS == "Middle Seat") : ?>
                            <span class="reserved-text" style="margin-left: 30px; margin-right: 20px;"><i>Reserved</i></span>
                        <?php else : ?>
                            <input type="hidden" name="middle" value="<?php echo $MSRate ?>">
                            <input name="ReserveMS" type="submit" value="Reserve" style="margin-left: 20px" onclick="return checkBalance(<?php echo $MSRate; ?>, 'ReserveMS')">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="errorContainerMS" style="text-align: center;"></div>

        </div>

        <div class="confirmation" id="onCar">
            <h4>Are you are already in the car?</h4>

            <div style="display: flex; justify-content: space-evenly;">
                <input name="yes" type="submit" value="Yes" style="background-color: #a5a5a5;">
                <input type="hidden" name="bookingID" value="<?php echo $bookingID ?>">
                <input onclick="closeDialog()" type="button" value="Cancel">
            </div>
        </div>
        <div class="confirmation" id="arrivedButton">
            <h4>Did you arrived at your destination?</h4>

            <div style="display: flex; justify-content: space-evenly;">
                <input name="arrivedButton" type="submit" value="Yes" style="background-color: #a5a5a5;">
                <input type="hidden" name="bookingID" value="<?php echo $bookingID ?>">
                <input type="hidden" name="routeID" value="<?php echo $route_ID ?>">
                <input onclick="closeDialog()" type="button" value="Cancel">
            </div>
        </div>
    </form>
    <script>
        function arrived() {
            document.getElementById("arrivedButton").style.display = "block";
        }

        function onCar() {
            document.getElementById("onCar").style.display = "block";
        }

        function closeDialog() {
            document.getElementById("onCar").style.display = "none";
            document.getElementById("arrivedButton").style.display = "none";


        }

        function on() {
            document.getElementById("overlay").style.display = "block";
        }

        function off() {
            document.getElementById("overlay").style.display = "none";
        }

        function checkBalance(rate, seat) {
            balance = parseInt(<?php echo $balance; ?>);
            FSRate = parseInt(<?php echo $FSRate ?>);
            SSRate = parseInt(<?php echo $SSRate ?>);
            MSRate = parseInt(<?php echo $MSRate ?>);

            FSneed = (FSRate - balance)
            SSneed = (SSRate - balance)
            MSneed = (MSRate - balance)

            if (seat === 'ReserveFS' && balance < FSRate) {
                document.getElementById('errorContainerFS').innerHTML = "<span style='color: red;'>You need " + FSneed + " more tickets to reserve this seat. </span><br><br>";
                document.getElementById('errorContainerRS').innerHTML = "";
                document.getElementById('errorContainerLS').innerHTML = "";
                document.getElementById('errorContainerMS').innerHTML = "";
                return false;
            }
            if (seat === 'ReserveRS' && balance < SSRate) {
                document.getElementById('errorContainerRS').innerHTML = "<span style='color: red;'>You need " + SSneed + " more tickets to reserve this seat.</span><br><br>";
                document.getElementById('errorContainerFS').innerHTML = "";
                document.getElementById('errorContainerLS').innerHTML = "";
                document.getElementById('errorContainerMS').innerHTML = "";
                return false;
            }
            if (seat === 'ReserveLS' && balance < $SSRate) {
                document.getElementById('errorContainerLS').innerHTML = "<span style='color: red;'>You need " + SSneed + " more tickets to reserve this seat.</span><br><br>";
                document.getElementById('errorContainerRS').innerHTML = "";
                document.getElementById('errorContainerFS').innerHTML = "";
                document.getElementById('errorContainerMS').innerHTML = "";
                return false;
            }
            if (seat === 'ReserveMS' && balance < $MSRate) {
                document.getElementById('errorContainerMS').innerHTML = "<span style='color: red;'>You need " + MSneed + " more tickets to reserve this seat.</span><br><br>";
                document.getElementById('errorContainerRS').innerHTML = "";
                document.getElementById('errorContainerLS').innerHTML = "";
                document.getElementById('errorContainerFS').innerHTML = "";
                return false;
            }
            return true;
        }
    </script>
    <br><br><br><br>
</body>

</html>
<!-- 
    
<?php
$sql = "SELECT * FROM route INNER JOIN booking ON route.route_ID = booking.route_ID WHERE booking.route_ID = '$route_ID'";
$result = $conn->query($sql);
$bookingSeatPositions = array();

while ($row = $result->fetch_assoc()) {
    $bookingSeatPositions[] = $row['booking_SeatPosition'];
    $fare = $row['route_FrontSeat'];
}
?>