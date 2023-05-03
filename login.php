<?php
// Start the session
session_start();

// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpool";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve email and password from form submission
$email = $_POST['user_Email'];
$password = $_POST['user_Password'];

// Verify email and password against database
$sql = "SELECT * FROM user WHERE user_Email = '$email' AND user_Password = '$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Email and password are valid, retrieve user data from database
  $row = mysqli_fetch_assoc($result);
  
  // Store the variables in the session
  $_SESSION['login_Type'] = $row['user_Type'];
  $_SESSION['login_Email'] = $email;
  $_SESSION['login_Password'] = $password;
  $_SESSION['login_FirstName'] = $row['user_FirstName'];
  $_SESSION['login_LastName'] = $row['user_LastName'];
  $_SESSION['login_ContactNumber'] = $row['user_ContactNumber'];
  
  // Redirect to homepage
  header('Location: home.html');
  exit();
} else {
  // Email and password are invalid, display error message
  echo "<script>window.alert('Incorrect email or password')</script>";
}

mysqli_close($conn);
?>
