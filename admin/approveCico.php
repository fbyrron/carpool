<?php
include '../database.php';

$conn = new mysqli($servername, $username, $password, $dbname);
$ID = $_POST['c_ID'];
$sql = "SELECT * FROM cico WHERE c_ID = '$ID'";
$result = $conn->query($sql);
$newBalance = $_SESSION['newBalance'];
$trans_Type = $_SESSION['transType'];
$refNo = $_POST['c_GcashRef'];


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_ID = $row['user_ID'];
}
if (isset($_POST['approve_btn'])) {
    $update_query = "UPDATE cico SET c_Status = 'Approved' WHERE c_ID = '$ID'";
    mysqli_query($conn, $update_query);
    
    if($trans_Type == 'Cash-In'){
    $update_query = "UPDATE user SET user_AccBalance = '$newBalance' WHERE user_ID = '$user_ID'";

    if ($conn->query($update_query) === TRUE) {
        $_SESSION['login_Balance'] = $newBalance;
    }
    header('Location: cico approval.php');
    exit();
    }
    elseif ($trans_Type == 'Cash-Out') {
        $update_user_query = "UPDATE user SET user_AccBalance = '$newBalance' WHERE user_ID = '$user_ID'";
        $update_cico_query = "UPDATE cico SET c_GcashRef = '$refNo' WHERE c_ID = '$ID'";
    
        if ($conn->query($update_user_query) === TRUE && $conn->query($update_cico_query) === TRUE) {
            $_SESSION['login_Balance'] = $newBalance;
        }
        header('Location: cico approval.php');
        exit();
    }
    

}



if (isset($_POST['deny_btn'])) {
    $update_query = "UPDATE cico SET c_Status = 'Denied' WHERE c_ID = '$ID'";
    mysqli_query($conn, $update_query);
    header('Location: cico approval.php');
    exit();
}
