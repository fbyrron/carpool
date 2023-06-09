<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
include 'database.php';

$user_Type = 'Passenger';
$user_Email = $_POST['user_Email'];
$user_Password = $_POST['user_Password'];
$user_FirstName = $_POST['user_FirstName'];
$user_LastName = $_POST['user_LastName'];
$user_ContactNumber = $_POST['user_ContactNumber'];
$user_VerificationStat = 'Pending';
$freeTix = 10;

if(isset($_POST["send"])){
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error){
        die('Connection Failed: '.$conn->connect_error);
    }

    // Check if email already exists in database
    $stmt = $conn->prepare("SELECT user_Email FROM user WHERE user_Email = ?");
    $stmt->bind_param("s", $_POST['user_Email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        // Email already exists, show error message and exit script
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
        exit();
    }else{
        // Email doesn't exist, proceed with sending email and saving user data
        $mail = new PHPMailer(true);
        // Rest of the email sending code goes here...
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sesame13579@gmail.com';
        $mail->Password = 'fheiucndptntxkhe';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        
        $mail->setFrom('sesame13579@gmail.com', 'Carpool App');
        
        $mail->addAddress($_POST["user_Email"]);

        $mail->isHTML(true);

        $mail->Subject = "User Registration";
        $mail_template ="
    <h2>Carpool App</h2>
    Good day, you only have one step to use the app. Click the link below to finalize the Carpool App Registration.<br>
    <a href='http://localhost/carpool/register_.php?email=$user_Email'>Verifying Email Address</a>";

    $mail->Body = $mail_template;
    $mail->send();
    $_SESSION['registered'] = "Your registration has been successful. Please check your email to verify your account";
    
    echo "
    <script>
            alert('Check your email to verify your registration');
        </script>
    ";
    
    
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
            $stmt = $conn->prepare("INSERT INTO user(user_Type, user_Email, user_Password, user_FirstName, user_LastName, user_ContactNumber, user_AccBalance, user_VerificationStat) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssds", $user_Type, $user_Email, $user_Password, $user_FirstName, $user_LastName, $user_ContactNumber, $freeTix, $user_VerificationStat);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            echo "Carpool Registration Successful";
            }
    }
    
    // Redirect to the new page
    header('Location: index.php');
    exit();
    
}
}
