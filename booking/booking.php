<?php
include '../database.php';

$ID = $_SESSION['login_ID'];
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime("+1 day"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
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
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['viewRoute'])) {
        $_SESSION['bRouteID'] = $_POST['routeID'];
        $_SESSION['bRouteCarID'] = $_POST['routeCarID'];
        $_SESSION['bBookingID'] = $_POST['bookingID'];
        header('Location: myBookingDetails.php');
        exit;
    }
    ?>
    <div id="routes">
        <h1>My Bookings</h1>
        <h2 style="text-align: center;">Today</h2>
        <table>
            <?php
            $sql = "SELECT * FROM route INNER JOIN booking ON route.route_ID = booking.route_ID WHERE booking.user_ID = '$ID' ORDER BY route_Depart ASC";
            $result = $conn->query($sql);
            $routesFound = false;

            while ($row = $result->fetch_assoc()) :
                if ($row['route_Date'] == $today) :
                    $departValue = $row['route_Depart'];
                    $arriveValue = $row['route_Arrival'];
                    $depart = date("h:i A", strtotime($departValue));
                    $arrive = date("h:i A", strtotime($arriveValue));
                    $seat = $row['booking_SeatPosition'];
                    $bookingID = $row['booking_ID'];
                    $route_Status = $row['route_Status'];
                    if ($route_Status != 'Completed') :
                        $routesFound = true;
            ?>
                        <tr class="item">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" .
                                        $depart . " - " . $arrive ?><br>

                                </td>
                                <td>
                                    <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                    <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                                    <input type="hidden" name="bookingID" value="<?php echo $bookingID ?>">
                                    <span class="full-text" style=" text-align: center; margin-right: 10px"><i><?php echo $seat ?></i></span>
                                    <?php if ($row['route_Status'] == 'Scheduled') : ?>
                                        <span class="full-text" style="background-color: #7e7e7e; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php elseif ($row['route_Status'] == 'Waiting') : ?>
                                        <span class="full-text" style="background-color: #3a4198; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php elseif ($row['route_Status'] == 'On-going') : ?>
                                        <span class="full-text" style="background-color: #006703; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php endif; ?>

                                    <input type="submit" name="viewRoute" value="View"></input>
                                </td>
                            </form>
                        </tr>

            <?php
                    endif;
                endif;
            endwhile;

            if (!$routesFound) {
                echo "<p style='text-align:center;'><i>No booked route for today</i></p>";
            }
            ?>

        </table>

        <h2 style="text-align: center; padding-top: 50px">Tomorrow</h2>
        <table>
            <?php
            $sql = "SELECT * FROM route INNER JOIN booking ON route.route_ID = booking.route_ID WHERE booking.user_ID = '$ID' ORDER BY route_Depart ASC";
            $result = $conn->query($sql);
            $routesFound = false;

            while ($row = $result->fetch_assoc()) :
                if ($row['route_Date'] == $tomorrow) :
                    $departValue = $row['route_Depart'];
                    $arriveValue = $row['route_Arrival'];
                    $depart = date("h:i A", strtotime($departValue));
                    $arrive = date("h:i A", strtotime($arriveValue));
                    $seat = $row['booking_SeatPosition'];
                    $route_Status = $row['route_Status'];
                    $bookingID = $row['booking_ID'];

                    if ($route_Status != 'Completed') :
                        $routesFound = true;
            ?>

                        <tr class="item">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" .
                                        $depart . " - " . $arrive  ?></td>
                                <td>
                                    <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                    <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                                    <input type="hidden" name="bookingID" value="<?php echo $bookingID ?>">
                                    <span class="full-text" style=" text-align: center; margin-right: 20px"><i><?php echo $seat ?></i></span>
                                    <?php if ($row['route_Status'] == 'Scheduled') : ?>
                                        <span class="full-text" style="background-color: #7e7e7e; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php elseif ($row['route_Status'] == 'Waiting') : ?>
                                        <span class="full-text" style="background-color: #3a4198; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php elseif ($row['route_Status'] == 'On-going') : ?>
                                        <span class="full-text" style="background-color: #006703; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php endif; ?>
                                    <input type="submit" name="viewRoute" value="View Route"></input>

                                </td>
                            </form>
                        </tr>
            <?php
                    endif;
                endif;
            endwhile;

            if (!$routesFound) {
                echo "<p style='text-align:center;'><i>No booked route for tomorrow</i></p>";
            }
            ?>
        </table>

        <h2 style="text-align: center; padding-top: 50px">Other Day</h2>
        <table>
            <?php
            $sql = "SELECT * FROM route INNER JOIN booking ON route.route_ID = booking.route_ID WHERE booking.user_ID = '$ID' ORDER BY route_Date ASC, route_Depart ASC";
            $result = $conn->query($sql);
            $routesFound = false;

            while ($row = $result->fetch_assoc()) :
                $departValue = $row['route_Depart'];
                $arriveValue = $row['route_Arrival'];
                $dateValue = $row['route_Date'];
                $formattedDate = date("F d, Y", strtotime($dateValue));
                $depart = date("h:i A", strtotime($departValue));
                $arrive = date("h:i A", strtotime($arriveValue));
                $bookingID = $row['booking_ID'];

                if ($dateValue > $tomorrow) :
                    $seat = $row['booking_SeatPosition'];
                    if ($route_Status != 'Completed') :
                        $routesFound = true;

            ?>
                        <tr class="item">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <td><?php echo "<b>" . $row['route_Start'] . " - " . $row['route_End'] . "</b><br>" .
                                        $formattedDate . "<br>" .
                                        $depart . " - " . $arrive . "<br>"
                                    ?></td>
                                <td>
                                    <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                                    <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                                    <input type="hidden" name="bookingID" value="<?php echo $bookingID ?>">
                                    <span class="full-text" style=" text-align: center; margin-right: 20px"><i><?php echo $seat ?></i></span>
                                    <?php if ($row['route_Status'] == 'Scheduled') : ?>
                                        <span class="full-text" style="background-color: #7e7e7e; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php elseif ($row['route_Status'] == 'Waiting') : ?>
                                        <span class="full-text" style="background-color: #3a4198; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php elseif ($row['route_Status'] == 'On-going') : ?>
                                        <span class="full-text" style="background-color: #006703; color:white; padding: 10px; margin-right: 10px; border-radius: 20px; text-align: center;"><?php echo $row['route_Status']; ?></span>
                                    <?php endif; ?>
                                     <input type="submit" name="viewRoute" value="View Route"></input>
                                </td>
                            </form>
                        </tr>
            <?php
                    endif;
                endif;
            endwhile;

            if (!$routesFound) {
                echo "<p style='text-align:center;'><i>No other bookings as of the moment</i></p>";
            } ?>
        </table>
    </div>
    <br><br><br><br>

</body>

</html>