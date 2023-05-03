<?php
session_start();
$user_Type = $_SESSION['user_Type'];
$user_Email = $_SESSION['user_Email'];
$user_Password = $_SESSION['user_Password'];
$user_FirstName = $_SESSION['user_FirstName'];
$user_LastName = $_SESSION['user_LastName'];
$user_ContactNumber = $_SESSION['user_ContactNumber'];

// Database Connection
$conn = new mysqli('localhost', 'root', '', 'carpool');
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
        $stmt = $conn->prepare("INSERT INTO user(user_Type, user_Email, user_Password, user_FirstName, user_LastName, user_ContactNumber) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $user_Type, $user_Email, $user_Password, $user_FirstName, $user_LastName, $user_ContactNumber);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header("Location: list.php"); 
        exit();
        echo "Carpool Registration Successful";
    }
}
?>
