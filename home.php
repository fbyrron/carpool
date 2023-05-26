<?php
include 'database.php';

$ID = $_SESSION['login_ID'];
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$ID = $_SESSION['login_ID'];
$sql = "SELECT * FROM user WHERE user_ID = '$ID'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) :
    if ($row['user_ID'] == $ID) :
        $user_Type =  $row['user_Type'];
        $user_Balance = $row['user_AccBalance'];
    endif;
endwhile;
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
        <div id="route" class="col">
            <h3>Routes</h3> <br>
            <?php
            if ($user_Type == "Driver") {
                $link = 'route/route.php';
            } elseif ($user_Type == "Passenger") {
                $link = 'route/viewRoute.php';
            }
            ?>
            <div><a href="<?php echo $link ?>"><button>Here</button></a></div>
        </div>
        <div id="wallet" class="col">
            <h3>E-wallet</h3> <br>
            <?php
            if ($user_Type == "Driver") {
                $link = 'transaction/transaction.php';
            } elseif ($user_Type == "Passenger") {
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
            <div><a href="carReg.php"><button>Here</button></a></div>
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
 ?>
    <script>
        let route = document.getElementById('route');
        let type = '<?php echo $user_Type; ?>';
        cars = document.getElementById('cars');

        if ("<?php echo $type ?>" == 'Driver') {
            cars.style.display = "block";
            cars.style.display = "flex";
        }
    </script>


</body>

</html>