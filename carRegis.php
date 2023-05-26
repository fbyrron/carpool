<?php
include "database.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 3: Retrieve the form data using PHP $_POST variable
if (isset($_POST['regCar'])) {
    $car_MakeModel = $_POST["car_MakeModel"];
    $car_Color = $_POST["car_Color"];
    $car_Year = $_POST["car_Year"];
    $car_PlateNumber = $_POST["car_PlateNumber"];
    $car_ChasisNumber = $_POST["car_ChasisNumber"];
    $owner_ID = $_SESSION['login_ID'];
    $d_ID = $_SESSION['login_ID'];
    $user_Type = $_SESSION['login_Type'];
    $verificationStat = 'Pending';

    // Step 4: Prepare a SQL statement with parameters
    $stmt = $conn->prepare("INSERT INTO car (car_MakeModel, car_Color, car_PlateNumber, car_ChasisNumber, car_Year, user_ID, d_ID, verificationStat) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    // Step 5: Bind the parameters to the statement
    $stmt->bind_param("ssssssss", $car_MakeModel, $car_Color, $car_PlateNumber, $car_ChasisNumber, $car_Year, $owner_ID, $d_ID, $verificationStat);

    // Step 6: Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('New record created successfully')</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Step 7: Close the statement
    $stmt->close();

    // Step 9: Close the connection
    $conn->close();

    header("Location: carList.php"); 
    exit();
}
?>
