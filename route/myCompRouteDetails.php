<?php
include '../database.php';
$route_ID = $_SESSION['compRouteID'];
$route_CarID = $_SESSION['compRouteCarID'];
$user_ID = $_SESSION['login_ID'];

$sqlRoute = "SELECT * FROM route WHERE route_ID = '$route_ID'";
$resultRoute = $conn->query($sqlRoute);
$rowRoutee = $resultRoute->fetch_assoc();
$routeStat = $rowRoutee['route_Status'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Route Details <?php echo $route_ID?></title>
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
            echo '<input type="hidden" name="driverID" value="' . $driver . '">';
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
        <br><br><br><br>

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
            $completed = false;

            $bookings = "SELECT * FROM booking WHERE route_ID = '$route_ID'";
            $booking = $conn->query($bookings);
            while ($rowBooking = $booking->fetch_assoc()) :
                $bookingID = $rowBooking['booking_ID'];
                $bookingStat = $rowBooking['booking_Status'];

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
                    break;
                }
            // if($rowBooking['booking_Status'] == 'Traveling'){
            //     $completed
            // }
            endwhile;
            $status = $_SESSION['routeStatus'];
            unset($_SESSION['routeStatus']);

            if ($ID == $routeDriver && $cancellable == true) {
                if ($status != 'Cancelled') {
                    echo '<input onclick="confirm()" type="button" value="Cancel Schedule">';
                }
            } elseif ($ID == $routeDriver && $cancellable == false) {
                if ($status == 'Scheduled') {
                    echo '<input id="start" onclick="startSess()" type="button" value="Start the Session">';
                    echo '<input name="bookingID" type="hidden" value="' . $bookingID . '">';
                } elseif ($status == 'Waiting') {
                    echo '<input onclick="depart()" type="button" value="Depart">';
                } elseif ($status == 'Completed') {
                    echo '<h1 style="color: green; text-align: center; font-weight: 900;">Completed</h1>';
                }
            }
            $checkTravelingQuery = "SELECT COUNT(*) AS count FROM booking WHERE route_ID = $route_ID AND booking_Status = 'Traveling'";
            $result = $conn->query($checkTravelingQuery);
            $row = $result->fetch_assoc();
            $count = $row['count'];


            ?>
        </div>
        <br>
        <p style="text-align: center;">The current time is: <span id="current-time"></span></p>
        <!-- <br> -->
        <?php
        $sqlRouted = "SELECT * FROM route WHERE route_ID = '$route_ID'";
        $resultRouted = $conn->query($sqlRouted);
        $rowRouted = $resultRouted->fetch_assoc();
        $departureTimes = strtotime($rowRouted['route_Depart']);
        $timeDeparteds = strtotime($rowRouted['route_TimeDeparted']);
        $timeDifferences = $timeDeparteds - $departureTimes;
        $tenMinutess = 10 * 60;

        $passengers = "SELECT * FROM booking INNER JOIN user ON booking.user_ID = user.user_ID WHERE route_ID = '$route_ID'";
        $passenger = $conn->query($passengers);

        $frontSeat = $rightWindowSeat = $leftWindowSeat = $middleSeat = "No Passenger.";
        $FSPID = $RSPID = $LSPID = $MSPID = "";
        $FSStat = $RSStat = $LSStat = $MSStat = "-";
        $FSFare = $RSFare = $LSFare = $MSFare = "0";
        $FSRefund = $RSRefund = $LSRefund = $MSRefund = "0";
        $adminFS = $adminRS = $adminLS = $adminMS = "0";

        if ($status != 'Cancelled') :
            while ($rowPassenger = $passenger->fetch_assoc()) {
                $fname = $rowPassenger['user_FirstName'];
                $lname = $rowPassenger['user_LastName'];

                if ($rowPassenger['booking_SeatPosition'] == 'Front Seat') {
                    $frontSeat = $fname . " " . $lname;
                    $FSStat = $rowPassenger['booking_Status'];
                    $FSPID = $rowPassenger['user_ID'];
                    echo '<input type="hidden" name="FSPID" value="' . $FSPID . '">';

                    if ($FSStat == 'Arrived') {
                        $FSFare = $rowPassenger['booking_SeatRate'];
                    } elseif ($FSStat == 'Missed') {
                        if ($rowRouted['route_TimeDeparted'] <= $rowRouted['route_Depart']) :
                            $FSRefund = $FSFare;
                        elseif (intval($rowRouted['route_TimeDeparted']) > intval($rowRouted['route_Depart']) && intval($rowRouted['route_TimeDeparted']) <= (intval($rowRouted['route_Depart']) + 600)) :
                            $FSFare = $rowPassenger['booking_SeatRate'] * 0.4;
                            $adminFS = $rowPassenger['booking_SeatRate'] * 0.2;
                            $FSRefund = $rowPassenger['booking_SeatRate'] * 0.4;
                        elseif ($timeDifferences > $tenMinutess) :
                            $FSFare = $rowPassenger['booking_SeatRate'] * 0.9;
                            $adminFS = $rowPassenger['booking_SeatRate'] * 0.1;
                        endif;
                    }
                } elseif ($rowPassenger['booking_SeatPosition'] == 'Right Window Seat') {
                    $rightWindowSeat = $fname . " " . $lname;
                    $RSStat = $rowPassenger['booking_Status'];
                    $RSPID = $rowPassenger['user_ID'];
                    echo '<input type="hidden" name="RSPID" value="' . $RSPID . '">';

                    if ($RSStat == 'Arrived') {
                        $RSFare = $rowPassenger['booking_SeatRate'];
                    } elseif ($RSStat == 'Missed') {
                        if ($rowRouted['route_TimeDeparted'] <= $rowRouted['route_Depart']) :
                            $RSRefund = $RSFare;
                        elseif (intval($rowRouted['route_TimeDeparted']) > intval($rowRouted['route_Depart']) && intval($rowRouted['route_TimeDeparted']) <= (intval($rowRouted['route_Depart']) + 600)) :
                            $RSFare = $rowPassenger['booking_SeatRate'] * 0.4;
                            $adminRS = $rowPassenger['booking_SeatRate'] * 0.2;
                            $RSRefund = $rowPassenger['booking_SeatRate'] * 0.4;
                        elseif ($timeDifferences > $tenMinutess) :
                            $RSFare = $rowPassenger['booking_SeatRate'] * 0.9;
                            $adminRS = $rowPassenger['booking_SeatRate'] * 0.1;
                        endif;
                    }
                } elseif ($rowPassenger['booking_SeatPosition'] == 'Left Window Seat') {
                    $leftWindowSeat = $fname . " " . $lname;
                    $LSStat = $rowPassenger['booking_Status'];
                    $LSPID = $rowPassenger['user_ID'];
                    echo '<input type="hidden" name="LSPID" value="' . $LSPID . '">';

                    if ($LSStat == 'Arrived') {
                        $LSFare = $rowPassenger['booking_SeatRate'];
                    } elseif ($LSStat == 'Missed') {
                        if ($rowRouted['route_TimeDeparted'] <= $rowRouted['route_Depart']) :
                            $LSRefund = $LSFare;
                        elseif (intval($rowRouted['route_TimeDeparted']) > intval($rowRouted['route_Depart']) && intval($rowRouted['route_TimeDeparted']) <= (intval($rowRouted['route_Depart']) + 600)) :
                            $LSFare = $rowPassenger['booking_SeatRate'] * 0.4;
                            $adminLS = $rowPassenger['booking_SeatRate'] * 0.2;
                            $LSRefund = $rowPassenger['booking_SeatRate'] * 0.4;
                        elseif ($timeDifferences > $tenMinutess) :
                            $LSFare = $rowPassenger['booking_SeatRate'] * 0.9;
                            $adminLS = $rowPassenger['booking_SeatRate'] * 0.1;
                        endif;
                    }
                } elseif ($rowPassenger['booking_SeatPosition'] == 'Middle Seat') {
                    $middleSeat = $fname . " " . $lname;
                    $MSStat = $rowPassenger['booking_Status'];
                    $MSPID = $rowPassenger['user_ID'];
                    echo '<input type="hidden" name="MSPID" value="' . $MSPID . '">';

                    if ($MSStat == 'Arrived') {
                        $MSFare = $rowPassenger['booking_SeatRate'];
                    } elseif ($MSStat == 'Missed') {
                        if ($rowRouted['route_TimeDeparted'] <= $rowRouted['route_Depart']) :
                            $LSRefund = $LSFare;
                        elseif (intval($rowRouted['route_TimeDeparted']) > intval($rowRouted['route_Depart']) && intval($rowRouted['route_TimeDeparted']) <= (intval($rowRouted['route_Depart']) + 600)) :
                            $MSFare = $rowPassenger['booking_SeatRate'] * 0.4;
                            $adminMS = $rowPassenger['booking_SeatRate'] * 0.2;
                        elseif ($timeDifferences > $tenMinutess) :
                            $MSFare = $rowPassenger['booking_SeatRate'] * 0.9;
                            $adminMS = $rowPassenger['booking_SeatRate'] * 0.1;
                        endif;
                    }
                }
            }
            if ($status == 'Waiting' || $status == 'On-going' || $status == 'Completed') {
                $additionalColumn = "Additional Column: Waiting";
            } else {
                $additionalColumn = "";
            }

            if ($status == 'Completed') {
                $completedColumn = "completed";
            } else {
                $completedColumn = "";
            }
            $total = $FSFare + $RSFare + $LSFare + $MSFare;
            $totalRefundAdmin = $adminFS + $adminRS + $adminLS + $adminMS;
            echo '<input type="hidden" name="totalRefundAdmin" value="' . $totalRefundAdmin . '">';
            $totalRefundPassenger = $FSRefund + $RSRefund + $LSRefund + $MSRefund;
            echo '<input type="hidden" name="totalRefundPassenger" value="' . $totalRefundPassenger . '">';


        ?>
            <input type="hidden" name="FSFare" value="<?php $FSFare ?>">
            <input type="hidden" name="RSFare" value="<?php $RSFare ?>">
            <input type="hidden" name="LSFare" value="<?php $LSFare ?>">
            <input type="hidden" name="MSFare" value="<?php $MSFare ?>">

            <h4 style="text-align: center;">Current Passengers</h4>
            <table>
                <tr>
                    <td>
                        <b>Front Seat: </b>
                    </td>
                    <td>
                        <?php echo $frontSeat; ?>
                    </td>
                    <?php if ($additionalColumn != "") : ?>
                        <td>
                            <?php echo $FSStat ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($completedColumn == "completed") : ?>
                        <td>
                            <?php echo $FSFare ?>
                        </td>
                    <?php endif; ?>


                </tr>
                <tr>
                    <td>
                        <b>Right Window Seat: </b>
                    </td>
                    <td>
                        <?php echo $rightWindowSeat; ?>
                    </td>
                    <?php if ($additionalColumn != "") : ?>
                        <td>
                            <?php echo $RSStat ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($completedColumn == "completed") : ?>
                        <td>
                            <?php echo $RSFare ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td>
                        <b>Left Window Seat: </b>
                    </td>
                    <td>
                        <?php echo $leftWindowSeat; ?>
                    </td>
                    <?php if ($additionalColumn != "") : ?>
                        <td>
                            <?php echo $LSStat ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($completedColumn == "completed") : ?>
                        <td>
                            <?php echo $LSFare ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td>
                        <b>Middle Seat: </b>
                    </td>
                    <td>
                        <?php echo $middleSeat; ?>
                    </td>
                    <?php if ($additionalColumn != "") : ?>
                        <td>
                            <?php echo $MSStat ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($completedColumn == "completed") : ?>
                        <td>
                            <?php echo $MSFare ?>
                        </td>
                    <?php endif; ?>
                </tr>
            </table>
            <br>
            <?php if ($status == 'Completed') : ?>
                <p style="text-align: center;">Total earnings: <?php echo $total ?> tickets</p>
        <?php
            endif;
        endif;

        $sqlRoute = "SELECT * FROM route WHERE route_ID = '$route_ID'";
        $resultRoute = $conn->query($sqlRoute);
        $rowRoute = $resultRoute->fetch_assoc();
        $FSRate = $rowRoute['route_FrontSeat'];
        $SSRate = $rowRoute['route_SideSeat'];
        $MSRate = $rowRoute['route_MidSeat'];

        $scheduledUserIDs = array();
        $insideUserIDs = array();

        $sql = "SELECT * FROM booking WHERE route_ID = '$route_ID'";
        $result = $conn->query($sql);
        $FS = '';
        $RS = '';
        $LS = '';
        $MS = '';

        while ($row = $result->fetch_assoc()) :
            if ($row['booking_Status'] == 'Scheduled') {
                $scheduledIDs[] = $row['booking_ID'];
                $scheduledIDsString = implode(',', $scheduledIDs);
                $_SESSION['scheduledIDs'] = $scheduledIDsString;
            }
            if ($row['booking_Status'] == 'Inside') {
                $insideIDs[] = $row['booking_ID'];
                $insideIDsString = implode(',', $insideIDs);
                $_SESSION['insideIDs'] = $insideIDsString;
            }

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
            <br>
        </div>

        <div class="confirmation" id="confirmation">
            <h4>Are you sure you want to cancel this Sheduled Route?</h4>

            <div style="display: flex; justify-content: space-evenly;">
                <input id="yes" name="yes" type="submit" value="Yes" style="background-color: #a5a5a5;">
                <input id="no" onclick="closeDialog()" type="button" value="Cancel">
            </div>
        </div>
        <div class="confirmation" id="startSession">
            <h4>Are you sure you want to Start the session?</h4>

            <div style="display: flex; justify-content: space-evenly;">
                <input id="startNow" name="startNow" type="submit" value="Yes" style="background-color: #a5a5a5;">
                <input id="dont" onclick="closeDialog()" type="button" value="Cancel">
            </div>
        </div>
        <div class="confirmation" id="departure">
            <h4>Are you sure you already want to depart?</h4>
            <div style="display: flex; justify-content: space-evenly;">
                <input name="departNow" type="submit" value="Yes" style="background-color: #a5a5a5;">
                <input type="hidden" name="" value="">
                <input onclick="closeDialog()" type="button" value="Cancel">
            </div>
        </div>
        <?php
        $departureTime = strtotime($rowRoute['route_Depart']);
        $timeDeparted = strtotime($rowRoute['route_TimeDeparted']);
        $timeDifference = $timeDeparted - $departureTime;
        $tenMinutes = 10 * 60;
        ?>
        <div class="confirmation" id="completed">
            <h4>All your passengers have arrived. Press <i>Continue</i> to claim your earned tickets.</h4>
            <?php if ($rowRoute['route_TimeDeparted'] <= $rowRoute['route_Depart']) : ?>
                <p>
                    <i><b>Note:</b> Since you left earlier than your scheduled departure, you will not be able to claim your missed passenger's payment.</i><br><br>
                </p>
            <?php elseif (intval($rowRouted['route_TimeDeparted']) > intval($rowRouted['route_Depart']) && intval($rowRouted['route_TimeDeparted']) <= (intval($rowRouted['route_Depart']) + 600)) :
            ?>
                <p>
                    <i><b>Note:</b> Since you left during the 10 minute waiting period, you can only get 40% of the ticket from your missed passenger</i><br><br>
                </p>
            <?php elseif ($timeDifference > $tenMinutes) : ?>
                <p>
                    <i><b>Note:</b> Your passenger's payment who missed the trip will still be added to your balance</i><br><br>
                </p>
            <?php endif; ?>

            <div style="display: flex; justify-content: space-evenly; padding-bottom: 10px;">
                <input name="completedNow" type="submit" value="Continue" style="background-color: #a5a5a5;">
                <input type="hidden" name="" value="">
                <input onclick="closeDialog()" type="button" value="Cancel">
            </div>
        </div>
    </form>
    <script>
        function completed() {
            document.getElementById("completed").style.display = "block";
        }

        function depart() {
            document.getElementById("departure").style.display = "block";
        }

        function confirm() {
            document.getElementById("confirmation").style.display = "block";
        }

        function startSess() {
            document.getElementById("startSession").style.display = "block";
        }


        function closeDialog() {
            document.getElementById("confirmation").style.display = "none";
            document.getElementById("startSession").style.display = "none";
            document.getElementById("departure").style.display = "none";
            document.getElementById("completed").style.display = "none";
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

            FSneed = ((FSRate + 10) - balance)
            SSneed = ((SSRate + 10) - balance)
            MSneed = ((MSRate + 10) - balance)

            if (seat === 'ReserveFS' && balance < (FSRate + 10)) {
                document.getElementById('errorContainerFS').innerHTML = "<span style='color: red;'>You need " + FSneed + " more tickets to reserve this seat. </span><br><br>";
                document.getElementById('errorContainerRS').innerHTML = "";
                document.getElementById('errorContainerLS').innerHTML = "";
                document.getElementById('errorContainerMS').innerHTML = "";
                return false;
            }
            if (seat === 'ReserveRS' && balance < (SSRate + 10)) {
                document.getElementById('errorContainerRS').innerHTML = "<span style='color: red;'>You need " + SSneed + " more tickets to reserve this seat.</span><br><br>";
                document.getElementById('errorContainerFS').innerHTML = "";
                document.getElementById('errorContainerLS').innerHTML = "";
                document.getElementById('errorContainerMS').innerHTML = "";
                return false;
            }
            if (seat === 'ReserveLS' && balance < ($SSRate + 10)) {
                document.getElementById('errorContainerLS').innerHTML = "<span style='color: red;'>You need " + SSneed + " more tickets to reserve this seat.</span><br><br>";
                document.getElementById('errorContainerRS').innerHTML = "";
                document.getElementById('errorContainerFS').innerHTML = "";
                document.getElementById('errorContainerMS').innerHTML = "";
                return false;
            }
            if (seat === 'ReserveMS' && balance < ($MSRate + 10)) {
                document.getElementById('errorContainerMS').innerHTML = "<span style='color: red;'>You need " + MSneed + " more tickets to reserve this seat.</span><br><br>";
                document.getElementById('errorContainerRS').innerHTML = "";
                document.getElementById('errorContainerLS').innerHTML = "";
                document.getElementById('errorContainerFS').innerHTML = "";
                return false;
            }
            return true;
        }

        function updateTime() {
            var currentTime = new Date();
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();
            var meridiem = hours >= 12 ? "PM" : "AM";

            hours = hours % 12;
            hours = hours ? hours : 12;

            hours = (hours < 10 ? "0" : "") + hours;
            minutes = (minutes < 10 ? "0" : "") + minutes;
            seconds = (seconds < 10 ? "0" : "") + seconds;

            var timeString = hours + ":" + minutes + ":" + seconds + " " + meridiem;

            document.getElementById("current-time").innerHTML = timeString;
        }

        setInterval(updateTime, 1000);
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