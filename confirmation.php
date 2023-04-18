<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


if(isset($_POST["send"])){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fbyrron19@gmail.com';
    $mail->Password = 'vfzkhhhnwcgfeazm';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('Carpool App');

    $mail->addAddress($_POST["user_Email"]);

    $mail->isHTML(true);

    $mail->Subject = "User Registration";
    $mail_template ="
    <h2>Carpool App</h2>
    Good day, you only have one step to use the app. Click the link below to finalize the Carpool App Registration.<br>
    <a href='http://localhost/carpool/register_.php' >Verifying Email Address</a>";

    $mail->Body = $mail_template;
    $mail->send();

    echo
    "
    <script>
    alert('Check your email to verify your registration');
    document.location.list.php = list.php
    </script>
    ";

    $user_Type = $_POST['user_Type'];
    $user_Email = $_POST['user_Email'];
    $user_Password = $_POST['user_Password'];
    $user_FirstName = $_POST['user_FirstName'];
    $user_LastName = $_POST['user_LastName'];
    $user_ContactNumber = $_POST['user_ContactNumber'];
    
    //Database Connection
    session_start();

    // Store the variables in the session
    $_SESSION['user_Type'] = $user_Type;
    $_SESSION['user_Email'] = $user_Email;
    $_SESSION['user_Password'] = $user_Password;
    $_SESSION['user_FirstName'] = $user_FirstName;
    $_SESSION['user_LastName'] = $user_LastName;
    $_SESSION['user_ContactNumber'] = $user_ContactNumber;
    
    // Redirect to the new page
    exit();

}
?>

