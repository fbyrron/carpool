<?php
include '../database.php';

$ID = $_SESSION['login_ID'];
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime("+1 day"));

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['viewRoute'])) {
    $_SESSION['routeID'] = $_POST['routeID'];
    $_SESSION['routeCarID'] = $_POST['routeCarID'];
    header('Location: myRouteDetails.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Routes</title>
    <link rel="stylesheet" href="../style.css">
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
    </style>
</head>
<header>
    <?php include '../navbar.php' ?>
</header>

<body>
    <div id="routes">
        <a href="completed.php">Completed Routes Here</a>
        <h1>My Routes</h1>
        <h2 style="text-align: center;">Today's Routes</h2>
        <table>
            <?php
            $sql = "SELECT * FROM route WHERE user_ID = '$ID' ORDER BY route_Depart ASC";
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
                    if ($row['route_Status'] != 'Completed' && $row['route_Status'] != 'Cancelled') :
                        $routesFound = true;
            ?>
                    <tr class="item <?php echo (($FS == true && $LS == true && $RS == true && $MS == true) || $row['route_Status'] == 'Cancelled') ? 'reserved' : ''; ?>">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" . $depart . " - " . $arrive ?></td>
                            <td>
                                <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">

                                <?php if ($FS == true && $LS == true && $RS == true && $MS == true) : ?>
                                    <span class="full-text" style="text-align: center; margin-right: 20px"><i>Fully booked</i></span>
                                    <input type="submit" name="viewRoute" value="View Route">
                                <?php elseif ($row['route_Status'] == 'Cancelled') : ?>
                                    <span class="full-text" style="text-align: center; margin-right: 35px"><i>Cancelled</i></span>
                                    <input type="submit" name="viewRoute" value="View Route">
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
                echo "<p style='text-align:center;'><i>No available routes for today</i></p>";
            }
            ?>

        </table>

        <h2 style="text-align: center; padding-top: 50px">Tomorrow's Routes</h2>
        <table>
            <?php
            $sql = "SELECT * FROM route WHERE user_ID = '$ID' ORDER BY route_Depart ASC";
            $result = $conn->query($sql);
            $routesFound = false;

            while ($row = $result->fetch_assoc()) :
                if ($row['route_Date'] == $tomorrow && $row['route_Status'] != 'Cancelled' && $row['route_Status'] != 'Completed') :
                    $departValue = $row['route_Depart'];
                    $arriveValue = $row['route_Arrival'];
                    $depart = date("h:i A", strtotime($departValue));
                    $arrive = date("h:i A", strtotime($arriveValue));
                    $routesFound = true;

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

            ?>
                        <tr class="item <?php echo (($FS == true && $LS == true && $RS == true && $MS == true) || $row['route_Status'] == 'Cancelled') ? 'reserved' : ''; ?>">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" . $depart . " - " . $arrive ?></td>
                                <td>
                                    <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                    <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">

                                    <?php if ($FS == true && $LS == true && $RS == true && $MS == true) : ?>
                                        <span class="full-text" style="text-align: center; margin-right: 20px"><i>Fully booked</i></span>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php elseif ($row['route_Status'] == 'Cancelled') : ?>
                                        <span class="full-text" style="text-align: center; margin-right: 35px"><i>Cancelled</i></span>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php else : ?>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php endif; ?>
                                </td>
                            </form>
                        </tr>
            <?php
                endif;
            endwhile;

            if (!$routesFound) {
                echo "<p style='text-align:center;'><i>No available routes for tomorrow</i></p>";
            }
            ?>
        </table>

        <h2 style="text-align: center; padding-top: 50px">Other Routes</h2>
        <table>
            <?php
            $sql = "SELECT * FROM route WHERE user_ID = '$ID' ORDER BY route_Date ASC, route_Depart ASC";
            $result = $conn->query($sql);
            $routesFound = false;

            while ($row = $result->fetch_assoc()) :
                $departValue = $row['route_Depart'];
                $arriveValue = $row['route_Arrival'];
                $dateValue = $row['route_Date'];
                $formattedDate = date("F d, Y", strtotime($dateValue));
                $depart = date("h:i A", strtotime($departValue));
                $arrive = date("h:i A", strtotime($arriveValue));
                if ($dateValue > $tomorrow && $row['route_Status'] != 'Cancelled' && $row['route_Status'] != 'Completed') :
                    $routesFound = true;
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
                        ?>
                        <tr class="item <?php echo (($FS == true && $LS == true && $RS == true && $MS == true) || $row['route_Status'] == 'Cancelled') ? 'reserved' : ''; ?>">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" . $depart . " - " . $arrive ?></td>
                                <td>
                                    <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                    <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">

                                    <?php if ($FS == true && $LS == true && $RS == true && $MS == true) : ?>
                                        <span class="full-text" style="text-align: center; margin-right: 20px"><i>Fully booked</i></span>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php elseif ($row['route_Status'] == 'Cancelled') : ?>
                                        <span class="full-text" style="text-align: center; margin-right: 35px"><i>Cancelled</i></span>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php else : ?>
                                        <input type="submit" name="viewRoute" value="View Route">
                                    <?php endif; ?>
                                </td>
                            </form>
                        </tr>
            <?php
                endif;
            endwhile;

            if (!$routesFound) {
                echo "<p style='text-align:center;'><i>No other routes as of the moment</i></p>";
            } ?>
        </table>
    </div>
    <br><br><br><br>

</body>

</html>