<?php
include 'database.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve email and password from form submission
$email = $_POST['user_Email'];
$password = $_POST['user_Password'];

$sql = "SELECT * FROM admin WHERE admin_Email = '$email' AND admin_Password = '$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);

  $_SESSION['admin_ID'] = $row['admin_ID'];
  $_SESSION['admin_Email'] = $email;
  $_SESSION['admin_Password'] = $password;
  $_SESSION['admin_FN'] = $row['admin_FName'];
  $_SESSION['admin_LN'] = $row['admin_LName'];
  $_SESSION['admin_Role'] = $row['admin_Role'];

  header('Location: admin/profile.php');
  exit();
}

// Verify email and password against database
$sql = "SELECT * FROM user WHERE user_Email = '$email' AND user_Password = '$password' AND user_VerificationStat='Approved'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Email and password are valid, retrieve user data from database
  $row = mysqli_fetch_assoc($result);
  
  // Store the variables in the session
  $_SESSION['login_ID'] = $row['user_ID'];
  $_SESSION['login_Type'] = $row['user_Type'];
  $_SESSION['login_Email'] = $email;
  $_SESSION['login_Password'] = $password;
  $_SESSION['login_FirstName'] = $row['user_FirstName'];
  $_SESSION['login_LastName'] = $row['user_LastName'];
  $_SESSION['login_ContactNumber'] = $row['user_ContactNumber'];
  $_SESSION['login_Balance'] = $row['user_AccBalance'];
  
  // Redirect to homepage
  header('Location: home.php');
  exit();
} else {
  // Email and password are invalid, display error message
  $_SESSION['login_error'] = 'Incorrect email or password';
  header('Location: index.php');
}

mysqli_close($conn);
?>
