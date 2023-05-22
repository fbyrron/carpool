<?php
include 'database.php';

$ID = $_SESSION['login_ID'];
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpool</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Welcome to Carpool, <i><?php echo $_SESSION['login_FirstName'] ?></i></h1>

    <div class="row">
        <div id="route" class="col"> <!--style="display: none;" -->
            <h3>E-wallet</h3> <br>
            <?php
            if ($_SESSION['login_Type'] == "Driver") {
                $link = 'transaction/transaction.php';
            } elseif ($_SESSION['login_Type'] == "Passenger") {
                $link = 'transaction/cash-in.php';
            }
            ?>
                <div><a href="<?php echo $link ?>"><button>Here</button></a></div>
        </div>
        <div class="col">
            <div>
                <h3>Register a car</h3>
            </div>
            <br>
            <div><a href="carReg.html"><button>Here</button></a></div>
        </div>
        <div class="col" id="cars" style="display: none;">
            <h3>List of registered car/s</h3> <br>
            <div><a href="carList.php"><button>Here</button></a></div>
        </div>
        <div class="col">
            <h3>Profile</h3> <br>
            <div><a href="profile.php"><button>Here</button></a></div>
        </div>
    </div>
    <?php
    $type = $_SESSION['login_Type'] ?>
    <script>
        let route = document.getElementById('route');
        let type = '<?php echo $_SESSION['login_Type']; ?>';
        cars = document.getElementById('cars');

        if ("<?php echo $type ?>" == 'Driver'){
            cars.style.display = "block";
            cars.style.display = "flex";
        }
        // if (type == 'Driver') {
        //     route.style.display = 'block';
        //     route.style.display = 'flex';
        //     // window.location.href = 'index.php';
        // }
    </script>


</body>

</html>