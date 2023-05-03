<?php
// Step 1: Create a database table to store the information submitted from the form
// You can use any database management system to create the table. Here's an example SQL statement to create a table named "car_registration":
/*
CREATE TABLE car_registration (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    car_make_model VARCHAR(50) NOT NULL,
    car_color VARCHAR(20) NOT NULL,
    car_plate_number VARCHAR(20) NOT NULL,
    user_first_name VARCHAR(30) NOT NULL,
    user_last_name VARCHAR(30) NOT NULL,
    d_license_number VARCHAR(20) NOT NULL,
    user_contact_number VARCHAR(20) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
*/

// Step 2: Connect to the database using PHP
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpool";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 3: Retrieve the form data using PHP $_POST variable
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_MakeModel = $_POST["car_MakeModel"];
    $car_Color = $_POST["car_Color"];
    $car_PlateNumber = $_POST["car_PlateNumber"];
    $car_OwnerName = $_POST["car_OwnerName"];
    $car_OwnerLicense = $_POST["car_OwnerLicense"];
    $car_OwnerContactNo = $_POST["car_OwnerContactNo"];

    // Step 5: Insert the data into the database table using a SQL INSERT statement
    $sql = "INSERT INTO car (car_MakeModel, car_Color, car_PlateNumber, car_OwnerName, car_OwnerLicense, car_OwnerContactNo)
            VALUES ('$car_MakeModel', '$car_Color', '$car_PlateNumber', '$car_OwnerName', '$car_OwnerLicense', '$car_OwnerContactNo')
            
            ";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: carList.php"); 
    $conn->close();
}
?>