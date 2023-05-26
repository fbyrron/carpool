<?php
include '../database.php';

$conn = new mysqli($servername, $username, $password, $dbname);
$ID = $_POST['c_ID'];
$sql = "SELECT * FROM `cico` WHERE `c_ID` = '$ID'";
$result = $conn->query($sql);

$refNo = $_POST['c_GcashRef'];

$user_ID = ""; // Declare the $user_ID variable

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_ID = $row['user_ID']; 
    $c_Amount = $row['c_Amount']; 
    $c_InFee = $row['c_InFee']; 
    $c_OutFee = $row['c_OutFee'];
    $trans_Type = $row['c_Type'];
}

if (isset($_POST['approve_btn'])) {
    $update_query = "UPDATE `cico` SET `c_Status` = 'Approved' WHERE `c_ID` = '$ID'";
    mysqli_query($conn, $update_query);

    if ($trans_Type == 'Cash-In') {
        $cashin = ($c_Amount - $c_InFee);
        $newBalance =  ($_SESSION['login_Balance'] + $cashin);
        $update_query = "UPDATE `user` SET `user_AccBalance` = '$newBalance' WHERE `user_ID` = '$user_ID'" ;

        if ($conn->query($update_query) === TRUE) {
            $_SESSION['login_Balance'] = $newBalance;
        }
        header('Location: cico approval.php');
        exit();
    } elseif ($trans_Type == 'Cash-Out') {
        $cashout = ($c_Amount + $c_OutFee);
        $newBalance = ($_SESSION['login_Balance'] - $cashout);
        $update_user_query = "UPDATE `user` SET `user_AccBalance` = '$newBalance' WHERE `user_ID` = '$user_ID'";
        $update_cico_query = "UPDATE `cico` SET `c_GcashRef` = '$refNo' WHERE `c_ID` = '$ID'";

        if ($conn->query($update_user_query) === TRUE && $conn->query($update_cico_query) === TRUE) {
            $_SESSION['login_Balance'] = $newBalance;
        }
        header('Location: cico approval.php');
        exit();
    }
}

if (isset($_POST['deny_btn'])) {
    $update_query = "UPDATE `cico` SET `c_Status` = 'Denied' WHERE `c_ID` = '$ID'";
    mysqli_query($conn, $update_query);
    header('Location: cico approval.php');
    exit();
}
