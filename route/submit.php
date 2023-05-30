<?php
include "../database.php";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Step 1: Check for database connection errors
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Set up prepared statement
    $stmt = $conn->prepare("INSERT INTO route (user_ID, route_CarID, route_Start, route_End, route_Date, route_Depart, route_Arrival, route_FrontSeat, route_SideSeat, route_MidSeat, route_Status, route_VerificationStat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Step 3: Retrieve the form data using PHP $_POST variable
    if (isset($_POST['submit'])) {
        $user_ID = $_SESSION['login_ID'];
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
        
        

        // Step 4: Bind the parameters to the statement
        $stmt->bind_param("ddsssssdddss", $user_ID, $carID, $route_Start, $route_End, $route_Date, $route_Depart, $route_Arrival, $route_FrontSeat, $route_SideSeat, $route_MidSeat, $route_Status, $route_VerIficationStat);

        // Step 5: Execute the statement
        if ($stmt->execute()) {
                $_SESSION['cashInSuccess'] = "Your route has been successfully registered and posted on the <i>View Route</i> chuchu.";
                header('Location: createRoute.php');
                exit();
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    }

    // Step 6: Close the statement and connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
