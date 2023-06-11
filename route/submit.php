<?php
include "../database.php";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO route (user_ID, route_CarID, route_Start, route_End, route_Date, route_Depart, route_Arrival, route_FrontSeat, route_SideSeat, route_MidSeat, route_Status, route_VerificationStat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $user_ID = $_SESSION['login_ID'];

    if (isset($_POST['submit'])) {
        $carID = $_POST['route_CarID'];
        $route_Start = $_POST['route_Start'];
        $route_End = $_POST['route_End'];
        $route_Date = $_POST['route_Date'];
        $route_Depart = $_POST['route_Depart'];
        $route_Arrival = $_POST['route_Arrival'];
        $route_FrontSeat = $_POST['route_FrontSeat'];
        $route_SideSeat = $_POST['route_SideSeat'];
        $route_MidSeat = $_POST['route_MidSeat'];
        $route_Status = 'Scheduled';
        $route_VerIficationStat = 'Pending';

        $sql = "SELECT * FROM user WHERE user_ID = $user_ID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $AccBalance = $row['user_AccBalance'];
                $newBalance = $AccBalance - 10;
                $updateSql = "UPDATE user SET user_AccBalance = $newBalance WHERE user_ID = $user_ID";
                $conn->query($updateSql);
            }
        }
        $updateAdminBal = "UPDATE admin SET carpool_Balance = (carpool_Balance + 10) WHERE admin_ID = 1";
        $conn->query($updateAdminBal);

        $insert = "INSERT INTO cash_flows (cf_Type, cf_Description, cf_Amount) VALUES ('Inflow', 'Create Route Fee', 10)"; 
        $conn->query($insert);
        
        $stmt->bind_param("ddsssssdddss", $user_ID, $carID, $route_Start, $route_End, $route_Date, $route_Depart, $route_Arrival, $route_FrontSeat, $route_SideSeat, $route_MidSeat, $route_Status, $route_VerIficationStat);

        if ($stmt->execute()) {
            $_SESSION['cashInSuccess'] = "Your route has been successfully registered and posted on the <i>View Route</i> chuchu.";
            header('Location: createRoute.php');
            exit();
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    }

    $sql = "SELECT * FROM user WHERE user_ID = $user_ID";
    $result = $conn->query($sql);

    $stmt = $conn->prepare("INSERT INTO booking (route_ID, user_ID, booking_SeatPosition, booking_SeatRate, booking_PaymentStatus, booking_Status) VALUES (?, ?, ?, ?, ?, ?)");
    $route_ID = $_POST['route_ID'];
    $paymentStatus = 'Reserved';
    $bookingStatus = 'Scheduled';

    if (isset($_POST['ReserveFS'])) {
        $FSRate = $_POST['front'];
        $seatPosition = 'Front Seat';
        $stmt->bind_param("ddsdss", $route_ID, $user_ID, $seatPosition, $FSRate, $paymentStatus, $bookingStatus);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $AccBalance = $row['user_AccBalance'];
                $newBalance = $AccBalance - ($FSRate + 10);
                $updateSql = "UPDATE user SET user_AccBalance = $newBalance WHERE user_ID = $user_ID";
                $conn->query($updateSql);

                $updateAdminBal = "UPDATE admin SET carpool_Balance = (carpool_Balance + 10) WHERE admin_ID = 1";
                $conn->query($updateAdminBal);

                $insert = "INSERT INTO cash_flows (cf_Type, cf_Description, cf_Amount) VALUES ('Inflow', 'Booking Fee', 10)";
                $conn->query($insert);
            }
        }
        if ($stmt->execute()) {
            $_SESSION['Success'] = "You have successfully reserved your Front Seat";
            header('Location: viewRoute.php');
            exit();
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    }
    if (isset($_POST['ReserveRS'])) {
        $RSRate = $_POST['right'];
        $seatPosition = 'Right Window Seat';
        $stmt->bind_param("ddsdss", $route_ID, $user_ID, $seatPosition, $RSRate, $paymentStatus, $bookingStatus);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $AccBalance = $row['user_AccBalance'];
                $newBalance = $AccBalance - ($RSRate + 10);
                $updateSql = "UPDATE user SET user_AccBalance = $newBalance WHERE user_ID = $user_ID";
                $conn->query($updateSql);

                $updateAdminBal = "UPDATE admin SET carpool_Balance = (carpool_Balance + 10) WHERE admin_ID = 1";
                $conn->query($updateAdminBal);

                $insert = "INSERT INTO cash_flows (cf_Type, cf_Description, cf_Amount) VALUES ('Inflow', 'Booking Fee', 10)";
                $conn->query($insert);
            }
        }
        if ($stmt->execute()) {
            $_SESSION['Success'] = "You have successfully reserved your Right Window Seat";
            header('Location: viewRoute.php');
            exit();
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    }
    if (isset($_POST['ReserveLS'])) {
        $LSRate = $_POST['left'];
        $seatPosition = 'Left Window Seat';
        $stmt->bind_param("ddsdss", $route_ID, $user_ID, $seatPosition, $LSRate, $paymentStatus, $bookingStatus);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $AccBalance = $row['user_AccBalance'];
                $newBalance = $AccBalance - ($LSRate + 10);
                $updateSql = "UPDATE user SET user_AccBalance = $newBalance WHERE user_ID = $user_ID";
                $conn->query($updateSql);

                $updateAdminBal = "UPDATE admin SET carpool_Balance = (carpool_Balance + 10) WHERE admin_ID = 1";
                $conn->query($updateAdminBal);

                $insert = "INSERT INTO cash_flows (cf_Type, cf_Description, cf_Amount) VALUES ('Inflow', 'Booking Fee', 10)";
                $conn->query($insert);
            }
        }
        if ($stmt->execute()) {
            $_SESSION['Success'] = "You have successfully reserved your Left Window Seat";
            header('Location: viewRoute.php');
            exit();
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    }
    if (isset($_POST['ReserveMS'])) {
        $MSRate = $_POST['middle'];
        $seatPosition = 'Middle Seat';
        $stmt->bind_param("ddsdss", $route_ID, $user_ID, $seatPosition, $MSRate, $paymentStatus, $bookingStatus);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $AccBalance = $row['user_AccBalance'];
                $newBalance = $AccBalance - ($MSRate - 10);
                $updateSql = "UPDATE user SET user_AccBalance = $newBalance WHERE user_ID = $user_ID";
                $conn->query($updateSql);

                $updateAdminBal = "UPDATE admin SET carpool_Balance = (carpool_Balance + 10) WHERE admin_ID = 1";
                $conn->query($updateAdminBal);

                $insert = "INSERT INTO cash_flows (cf_Type, cf_Description, cf_Amount) VALUES ('Inflow', 'Booking Fee', 10)";
                $conn->query($insert);
            }
        }
        if ($stmt->execute()) {
            $_SESSION['Success'] = "You have successfully reserved your Middle Seat";
            header('Location: viewRoute.php');
            exit();
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    }

    if (isset($_POST['yes'])) {
        $updateRouteStatus = "UPDATE route SET route_Status = 'Cancelled' WHERE route_ID = $route_ID";
        $conn->query($updateRouteStatus);
        header('Location: myRoutes.php');
        exit();
    }

    if (isset($_POST['startNow'])) {
        $updateRouteStatus = "UPDATE route SET route_Status = 'Waiting' WHERE route_ID = $route_ID";
        $conn->query($updateRouteStatus);
        header('Location: myRouteDetails.php');
        exit();
    }

    if (isset($_POST['departNow'])) {
        date_default_timezone_set('Asia/Manila');
        $routeTimestamp = date("Y-m-d H:i:s");
        $updateRouteStatus = "UPDATE route SET route_Status = 'On-going', route_TimeDeparted = '$routeTimestamp' WHERE route_ID = $route_ID";
        $conn->query($updateRouteStatus);

        $scheduledIDsString = $_SESSION['scheduledIDs'];
        $scheduledIDs = explode(',', $scheduledIDsString);

        $insideIDsString = $_SESSION['insideIDs'];
        $insideIDs = explode(',', $insideIDsString);

        foreach ($scheduledIDs as $bookingID) {
            $updateQuery = "UPDATE booking SET booking_Status = 'Missed' WHERE booking_ID = $bookingID";
            $conn->query($updateQuery);
        }

        foreach ($insideIDs as $insideBookingID) {
            $updateQuery = "UPDATE booking SET booking_Status = 'Traveling' WHERE booking_ID = $insideBookingID";
            $conn->query($updateQuery);
        }

        header('Location: myRouteDetails.php');
        exit();
    }

    if (isset($_POST['completedNow'])) {

        $sqlRoute = "SELECT * FROM route WHERE route_ID = '$route_ID'";
        $resultRoute = $conn->query($sqlRoute);
        $rowRoute = $resultRoute->fetch_assoc();

        $departureTime = strtotime($rowRoute['route_Depart']);
        $timeDeparted = strtotime($rowRoute['route_TimeDeparted']);
        $timeDifference = $timeDeparted - $departureTime;
        $tenMinutes = 10 * 60;
        $driverID = $_POST['driverID'];
        // (intval($_POST['FSFare']) + intval($_POST['RSFare']) + intval($_POST['LSFare']) + intval($_POST['MSFare']));
        $total = $_POST['total'];
        $totalRefundAdmin = $_POST['totalRefundAdmin'];
        $totalRefundPassenger = $_POST['totalRefundPassenger'];

        $update = "UPDATE user SET user_AccBalance = user_AccBalance + $total WHERE user_ID = $driverID"; // HEREEEEEEEE
        $conn->query($update);


        if ($totalRefundAdmin > 0) {
            $updateAdmin = "UPDATE admin SET carpool_Balance = carpool_Balance + $totalRefundAdmin WHERE admin_ID = 1";
            $conn->query($updateAdmin);
        }
        if ($totalRefundPassenger > 0) {
            $updatePassenger = "UPDATE user SET user_AccBalance = user_AccBalance + $totalRefundPassenger WHERE user_UD = $what";
            $conn->query($updatePassenger);
        }

        $updateRouteQuery = "UPDATE route SET route_Status = 'Completed' WHERE route_ID = $route_ID ";
        $conn->query($updateRouteQuery);

        $_SESSION['compRouteID'] = $_POST['compRouteID'];
        $_SESSION['compRouteCarID'] = $_POST['compRouteCarID'];

        header('Location: myCompRouteDetails.php');
        exit();
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
