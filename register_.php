<?php
include 'database.php';

$user_Type = $_SESSION['user_Type'];
$user_Email = $_SESSION['user_Email'];
$user_Password = $_SESSION['user_Password'];
$user_FirstName = $_SESSION['user_FirstName'];
$user_LastName = $_SESSION['user_LastName'];
$user_ContactNumber = $_SESSION['user_ContactNumber'];
$freeTix = 10;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_Email = ?");
    $stmt->bind_param("s", $user_Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, show error message
        echo "Email already registered.";
    } else {
        // Email does not exist, insert user data
        $stmt = $conn->prepare("INSERT INTO user(user_Type, user_Email, user_Password, user_FirstName, user_LastName, user_ContactNumber, user_AccBalance) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssd", $user_Type, $user_Email, $user_Password, $user_FirstName, $user_LastName, $user_ContactNumber, $freeTix);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "Carpool Registration Successful";
        
        header("Location: index.php"); 
        exit();
    }
}
?>
