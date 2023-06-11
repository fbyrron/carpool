<?php
include '../database.php';

$ID = $_SESSION['login_ID'];
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime("+1 day"));

$successMessage = "";
if (isset($_SESSION['Success'])) {
    $successMessage = $_SESSION['Success'];
    unset($_SESSION['Success']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Routes</title>
    <style>
        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 40%;
            margin: 0 auto;
        }

        .success {
            color: green;
            text-align: center;
            font-weight: 700;
        }

        tr.item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #d2ffd3;
            border: 1px solid;
            border-radius: 15px;
            padding: 10px;
            margin-bottom: 10px;
        }

        tr.item.reserved {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffd2bc;
            border: 1px solid;
            border-radius: 15px;
            padding: 10px;

        }

        tr,
        td {
            border: none;

        }

        .toggle-btn {
            width: 40px;
            height: 20px;
            background-color: #ccc;
            border-radius: 10px;
            position: relative;
            cursor: pointer;
        }

        .toggle-btn:before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background-color: white;
            border-radius: 50%;
            transition: 0.3s;
        }

        .toggle-btn.active {
            background-color: green;
        }

        .toggle-btn.active:before {
            transform: translateX(20px);
        }

        #toggle {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
        }
    </style>
</head>
<header>
    <?php include '../navbar.php' ?>
</header>

<body>
    <?php if ($successMessage !== "") : ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['viewRoute'])) {
    $_SESSION['pRouteID'] = $_POST['routeID'];
    $_SESSION['pRouteCarID'] = $_POST['routeCarID'];
    header('Location: routeDetails.php');
    exit;
}
    ?>
    <div id="routes">
        <div id="toggle">
            <p style="padding-right: 20px;">Show available routes only </p>
            <div class="toggle-btn" onclick="toggleButton(this)"></div>
        </div>


        <h2 style="text-align: center;">Today's Routes</h2>
        <div id="noRoutesMessageToday" style="display:none; text-align: center">No other available routes as of the moment.</div>
        <table>
            <?php
            $sql = "SELECT * FROM route  ORDER BY route_Depart ASC";
            $result = $conn->query($sql);
            $routesFound = false;

            while ($row = $result->fetch_assoc()) :
                if ($row['route_Date'] == $today) :
                    $departValue = $row['route_Depart'];
                    $arriveValue = $row['route_Arrival'];
                    $depart = date("h:i A", strtotime($departValue));
                    $arrive = date("h:i A", strtotime($arriveValue));

                    $FS = false;
                    $RS = false;
                    $LS = false;
                    $MS = false;
                    
                    $bookings = "SELECT * FROM booking WHERE route_ID = '{$row['route_ID']}'";
                    $booking = $conn->query($bookings);
                    while ($rowBooking = $booking->fetch_assoc()) :
                        if (($rowBooking['booking_SeatPosition'] == 'Front Seat')) {
                            $FS = true;
                        } elseif (($rowBooking['booking_SeatPosition'] == 'Left Window Seat')) {
                            $LS = true;
                        } elseif ($rowBooking['booking_SeatPosition'] == 'Right Window Seat') {
                            $RS = true;
                        } elseif ($rowBooking['booking_SeatPosition'] == 'Middle Seat') {
                            $MS = true;
                        }
                    endwhile;
                    if ($row['route_Status'] == 'Scheduled') :
                        $routesFound = true;
                        ?>
                        <tr class="item <?php echo ($FS == true && $LS == true && $RS == true && $MS == true) ? 'reserved' : ''; ?>">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" .
                                        $depart . " - " . $arrive ?></td>
                                <td>
                                    <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                    <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                                    <?php if ($FS == true && $LS == true && $RS == true && $MS == true) : ?>
                                        <span class="full-text" style=" text-align: center; margin-right: 20px"><i>Fully booked</i></span>
                                    <?php else : ?>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php endif; ?>
                                </td>
                            </form>
                        </tr>

            <?php
                    endif;
                endif;
            endwhile;

            if (!$routesFound) {
                echo "<div id='noToday' style='text-align:center;'><i>No available routes for today</i></div>";
            }
            ?>

        </table>

        <h2 style="text-align: center; padding-top: 50px">Tomorrow's Routes</h2>
        <div id="noRoutesMessageTomorrow" style="display:none; text-align: center">No other available routes as of the moment.</div>
        <table>
            <?php
            $sql = "SELECT * FROM route  ORDER BY route_Depart ASC";
            $result = $conn->query($sql);
            $routesFound = false;

            while ($row = $result->fetch_assoc()) :
                if ($row['route_Date'] == $tomorrow) :
                    $departValue = $row['route_Depart'];
                    $arriveValue = $row['route_Arrival'];
                    $depart = date("h:i A", strtotime($departValue));
                    $arrive = date("h:i A", strtotime($arriveValue));

                    $FS = false;
                    $RS = false;
                    $LS = false;
                    $MS = false;

                    $bookings = "SELECT * FROM booking WHERE route_ID = '{$row['route_ID']}'";
                    $booking = $conn->query($bookings);
                    while ($rowBooking = $booking->fetch_assoc()) :
                        if (($rowBooking['booking_SeatPosition'] == 'Front Seat')) {
                            $FS = true;
                        } elseif (($rowBooking['booking_SeatPosition'] == 'Left Window Seat')) {
                            $LS = true;
                        } elseif ($rowBooking['booking_SeatPosition'] == 'Right Window Seat') {
                            $RS = true;
                        } elseif ($rowBooking['booking_SeatPosition'] == 'Middle Seat') {
                            $MS = true;
                        }
                    endwhile;
                    if ($row['route_Status'] == 'Scheduled') :
                        $routesFound = true;
                        ?>
                        <tr class="item <?php echo ($FS == true && $LS == true && $RS == true && $MS == true) ? 'reserved' : ''; ?>">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" .
                                        $depart . " - " . $arrive ?></td>
                                <td>
                                    <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                    <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                                    <?php if ($FS == true && $LS == true && $RS == true && $MS == true) : ?>
                                        <span class="full-text" style=" text-align: center; margin-right: 20px"><i>Fully booked</i></span>
                                    <?php else : ?>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php endif; ?>
                                </td>
                            </form>
                        </tr>
            <?php
                    endif;
                endif;
            endwhile;

            if (!$routesFound) {
                echo "<div id='noTom' style='text-align:center;'><i>No available routes for tomorrow</i></div>";
            }
            ?>
        </table>

        <h2 style="text-align: center; padding-top: 50px">Other Routes</h2>
        <div id="noRoutesMessageOther" style="display:none; text-align: center;">No other available routes as of the moment.</div>
        <table>
            <?php
            $sql = "SELECT * FROM route  ORDER BY route_Date ASC, route_Depart ASC";
            $result = $conn->query($sql);
            $routesFound = false;

            while ($row = $result->fetch_assoc()) :
                $departValue = $row['route_Depart'];
                $arriveValue = $row['route_Arrival'];
                $dateValue = $row['route_Date'];
                $formattedDate = date("F d, Y", strtotime($dateValue));
                $depart = date("h:i A", strtotime($departValue));
                $arrive = date("h:i A", strtotime($arriveValue));
                if ($dateValue > $tomorrow) :
                    $FS = false;
                    $RS = false;
                    $LS = false;
                    $MS = false;
                    
                    $bookings = "SELECT * FROM booking WHERE route_ID = '{$row['route_ID']}'";
                    $booking = $conn->query($bookings);
                    while ($rowBooking = $booking->fetch_assoc()) :
                        if (($rowBooking['booking_SeatPosition'] == 'Front Seat')) {
                            $FS = true;
                        } elseif (($rowBooking['booking_SeatPosition'] == 'Left Window Seat')) {
                            $LS = true;
                        } elseif ($rowBooking['booking_SeatPosition'] == 'Right Window Seat') {
                            $RS = true;
                        } elseif ($rowBooking['booking_SeatPosition'] == 'Middle Seat') {
                            $MS = true;
                        }
                    endwhile;
                    if ($row['route_Status'] == 'Scheduled') :
                        $routesFound = true;
                        ?>
                        <tr class="item <?php echo ($FS == true && $LS == true && $RS == true && $MS == true) ? 'reserved' : ''; ?>">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" .
                                        $depart . " - " . $arrive ?></td>
                                <td>
                                    <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                    <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                                    <?php if ($FS == true && $LS == true && $RS == true && $MS == true) : ?>
                                        <span class="full-text" style=" text-align: center; margin-right: 20px"><i>Fully booked</i></span>
                                    <?php else : ?>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php endif; ?>
                                </td>
                            </form>
                        </tr>
            <?php
                    endif;
                endif;
            endwhile;

            if (!$routesFound) {
                echo "<div id='noOther' style='text-align:center;'><i>No other routes as of the moment</i></div>";
            } ?>
        </table>
        <br><br><br><br>
    </div>
    <script>
    function toggleButton(btn) {
        btn.classList.toggle('active');
        var tableRowsToday = document.querySelectorAll('#routes table:nth-of-type(1) tr.item');
        var tableRowsTomorrow = document.querySelectorAll('#routes table:nth-of-type(2) tr.item');
        var tableRowsOther = document.querySelectorAll('#routes table:nth-of-type(3) tr.item');
        var noRoutesMessageToday = document.getElementById('noRoutesMessageToday');
        var noRoutesMessageTomorrow = document.getElementById('noRoutesMessageTomorrow');
        var noRoutesMessageOther = document.getElementById('noRoutesMessageOther');
        var noToday = document.getElementById('noToday');
        var noTom = document.getElementById('noTom');
        var noOther = document.getElementById('noOther');

        var hasAvailableRoutesToday = false;
        var hasAvailableRoutesTomorrow = false;
        var hasAvailableRoutesOther = false;
        // noToday.style.display = 'none';
        // noTom.style.display = 'none';
        // noOther.style.display = 'none';

        for (var i = 0; i < tableRowsToday.length; i++) {
            var row = tableRowsToday[i];
            var isFullyBooked = row.classList.contains('reserved');
            var isCancelled = row.dataset.status === 'Cancelled';

            if (btn.classList.contains('active') && (isFullyBooked || isCancelled)) {
                row.style.display = 'none';
            } else {
                row.style.display = '';
                hasAvailableRoutesToday = true;
            }
        }

        for (var i = 0; i < tableRowsTomorrow.length; i++) {
            var row = tableRowsTomorrow[i];
            var isFullyBooked = row.classList.contains('reserved');
            var isCancelled = row.dataset.status === 'Cancelled';

            if (btn.classList.contains('active') && (isFullyBooked || isCancelled)) {
                row.style.display = 'none';
            } else {
                row.style.display = '';
                hasAvailableRoutesTomorrow = true;
            }
        }

        for (var i = 0; i < tableRowsOther.length; i++) {
            var row = tableRowsOther[i];
            var isFullyBooked = row.classList.contains('reserved');
            var isCancelled = row.dataset.status === 'Cancelled';

            if (btn.classList.contains('active') && (isFullyBooked || isCancelled)) {
                row.style.display = 'none';
            } else {
                row.style.display = '';
                hasAvailableRoutesOther = true;
            }
        }

        if (hasAvailableRoutesToday) {
            noRoutesMessageToday.style.display = 'none';
        } else {
            noRoutesMessageToday.style.display = '';
        }

        if (hasAvailableRoutesTomorrow) {
            noRoutesMessageTomorrow.style.display = 'none';
        } else {
            noRoutesMessageTomorrow.style.display = '';
        }

        if (hasAvailableRoutesOther) {
            noRoutesMessageOther.style.display = 'none';
        } else {
            noRoutesMessageOther.style.display = '';
        }
    }
</script>



</body>

</html>