<?php
 include('dbcon.php');

 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verify($user_FirstName, $user_Email){
    $mail=new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fbyrron19@gmail.com';
    $mail->Password = 'vfzkhhhnwcgfeazm';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('fbyrron19@gmail.com');

    $mail->addAddress($_POST["user_Email"]);

    $mail->isHTML(true);

    $mail->Subject = "User Registration";
    $mail_template ="
    <h2>Carpool App</h2>
    Good day, you only have one step to use the app. Click the link below to finalize the Carpool App Registration.<br>
    <a href='http://localhost/carpool/register.php?' >Verifying Email Address</a>";

    $mail->Body = $mail_template;
    $mail->send();

    echo
    "
    <script>
    alert('Check your email to verify your registration');
    document.location.list.php = list.php
    </script>
    ";

}

if(isset($_POST["send"])){

    
    $user_Type = $_POST['user_Type'];
    $user_Email = $_POST['user_Email'];
    $user_Password = $_POST['user_Password'];
    $user_FirstName = $_POST['user_FirstName'];
    $user_LastName = $_POST['user_LastName'];
    $user_ContactNumber = $_POST['user_ContactNumber'];
    // $verify_token

    $check_email_query = "SELECT user_Email From user WHERE email = 'user_Email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0){
        $_SESSION['status'] = "Email ID already exists";
        header("Location: register.php");
    }
    else{
        $query = "INSERT INTO user(user_Type, user_Email, user_Password, user_FirstName, user_LastName, user_ContactNumber)
        VALUES ($user_Type, $user_Email, $user_Password, $user_FirstName, $user_LastName, $user_ContactNumber)";
        $query_run = mysqli_query($con, $query);

        if($query_run){
            sendemail_verify("$user_FirstName", "$user_Email");
            $_SESSION['status'] = "Registration Successful! Please verify your email address";
            header("Location: register.php");
        }
        else{
            $_SESSION['status'] = "Registration Failed";
            header("Location: register.php");

        }
    }
}

?>