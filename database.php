<?php
// $servername = "localhost";
// $username = "u235219407_Ernest";
// $password = "Carpoolapp1";
// $dbname = "u235219407_cplapp";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Carpool";

$conn = new mysqli($servername, $username, $password, $dbname);

// if(!isset($_SESSION['login_ID'])){
//     header('Location: http://localhost/carpool/index.php');
    // header('Location: http://cplapp.caseykeos.tech/index.php');
// }
session_start();
?>