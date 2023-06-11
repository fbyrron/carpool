<?php
include "../database.php";
$bookingID = $_POST['bookingID'];
$routeID = $_POST['routeID'];

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    if (isset($_POST['yes'])) {
        $updateRouteStatus = "UPDATE booking SET booking_Status = 'Inside' WHERE booking_ID = $bookingID";
        $conn->query($updateRouteStatus);
        header('Location: myBookingDetails.php');
        exit();
    }
    if (isset($_POST['arrivedButton'])) {
        $updateRouteStatus = "UPDATE booking SET booking_Status = 'Arrived' WHERE booking_ID = $bookingID";
        $conn->query($updateRouteStatus);
    
        header('Location: myBookingDetails.php');
        exit();
    }
    
    
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
