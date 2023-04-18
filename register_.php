<?php
    session_start();
    $user_Type = $_SESSION['user_Type'];
    $user_Email = $_SESSION['user_Email'];
    $user_Password = $_SESSION['user_Password'];
    $user_FirstName = $_SESSION['user_FirstName'];
    $user_LastName = $_SESSION['user_LastName'];
    $user_ContactNumber = $_SESSION['user_ContactNumber'];
    
    //Database Connection
    $conn = new mysqli('localhost', 'root', '', 'carpool');
    if($conn->connect_error){
        die('Connection Failed: '.$conn->connect_error);
    }else{
        $stmt = $conn->prepare("INSERT INTO user(user_Type, user_Email, user_Password, user_FirstName, user_LastName, user_ContactNumber)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $user_Type, $user_Email, $user_Password, $user_FirstName, $user_LastName, $user_ContactNumber);
        $stmt->execute();
        echo "Carpool Registration Successful";
    
    $stmt-> close();
    $conn-> close();
    header("Location: list.php"); 
    exit();
}

?>