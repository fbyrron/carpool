<?php
include 'database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

$email = $_GET['email'];

$sql = "SELECT * FROM `user` WHERE `user_Email` = '$email'";
$result = $conn->query($sql);

$update_query = "UPDATE `user` SET `user_VerificationStat` = 'Approved' WHERE `user_Email` = '$email'";
mysqli_query($conn, $update_query);

header("Location: index.php");
exit();
