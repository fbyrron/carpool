<?php
include '../database.php';
$conn = new mysqli($servername, $username, $password, $dbname);
$ID = $_POST['carID'];
$sql = "SELECT * FROM car WHERE car_ID = '$ID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $user_ID = $row['user_ID'];
}

if (isset($_POST['approve_btn'])) {

  $check_result = mysqli_query($conn, "SELECT * FROM car WHERE user_ID = '$user_ID' AND verificationStat = 'Approved'");

  $driver = "SELECT * FROM user WHERE user_ID = '$user_ID'";
  $resultt = $conn->query($driver);
  $driverRow = $result->fetch_assoc();
  $userType = $driverRow['user_Type'];

  if (!$check_result || mysqli_num_rows($check_result) == 0) {
    mysqli_query($conn, "UPDATE user SET user_Type = 'Driver', user_AccBalance = user_AccBalance + 40 WHERE user_ID = '$user_ID'");
    $_SESSION['login_Type'] = 'Driver';
    $_SESSION['login_Balance'] = ($_SESSION['login_Balance'] + 40);

    $updateAdminBal = "UPDATE admin SET carpool_Balance = (carpool_Balance - 40) WHERE admin_ID = 1";
    $conn->query($updateAdminBal);

    $insert = "INSERT INTO cash_flows (cf_Type, cf_Description, cf_Amount) VALUES ('Outflow', 'First Approve Car free tickets', 40)";
    $conn->query($insert);
  }
  $update_query = "UPDATE car SET verificationStat = 'Approved' WHERE car_ID = '$ID'";
  mysqli_query($conn, $update_query);


  header('Location: admincarlist.php');
  exit();
}



if (isset($_POST['deny_btn'])) {
  $update_query = "UPDATE car SET verificationStat = 'Denied' WHERE car_ID = '$ID'";
  mysqli_query($conn, $update_query);
  header('Location: admincarlist.php');
  exit();
}
