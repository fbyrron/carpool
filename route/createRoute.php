<?php
include '../database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['login_ID'];

$sql = "SELECT * FROM user WHERE user_ID = $userID";
$result = $conn->query($sql);

$successMessage = "";
if (isset($_SESSION['cashInSuccess'])) {
    $successMessage = $_SESSION['cashInSuccess'];
    unset($_SESSION['cashInSuccess']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Route</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        input[type="radio"] {
            margin-right: 5px;
            vertical-align: middle;
        }

        input[type="number"],
        input[type="time"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 20px;
        }

        label {
            display: inline-block;
            vertical-align: middle;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
            text-align: center;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <?php include '../navbar.php' ?>
    <h1>Create Route</h1>
    <?php if ($successMessage !== "") : ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <form action="submit.php" method="POST" class="form-container" name="route" onsubmit="return validateForm()">

        <h3 style="text-align: center;">Location</h3>
        <label for="route_Start"><b>Starting Point</b></label>
        <input type="text" name="route_Start" id="route_Start"><br>

        <label for="route_End"><b>End Point</b></label>
        <input type="text" name="route_End" id="route_End"><br><br><br>

        <h3 style="text-align: center;">Schedule</h3>

        <label for="route_Date"><b>Date</b></label>
        <input type="date" name="route_Date" id="route_Date"><br>

        <label for="route_Depart"><b>Time of Departure</b></label>
        <input type="time" name="route_Depart" id="route_Depart">

        <label for="route_Arrival"><b>Estimated Time of Arrival</b></label><br>
        <input type="time" name="route_Arrival" id="route_Arrival"><br><br><br>

        <h3 style="text-align: center;">Fare Rate</h3>

        <label for="route_FrontSeat"><b>Front Seat Fare</b></label>
        <input type="number" name="route_FrontSeat" id="route_FrontSeat"><br>

        <label for="route_SideSeat"><b>Left & Right Window Seat Fare</b></label>
        <input type="number" name="route_SideSeat" id="route_SideSeat"><br>

        <label for="route_MidSeat"><b>Middle Window Seat Fare</b></label>
        <input type="number" name="route_MidSeat" id="route_MidSeat"><br><br>
        <br>

        <label for="route_CarID"><b>Car Details</b></label>
        <select name="route_CarID" id="route_CarID">
            <?php
            $sql = "SELECT * FROM car WHERE user_ID = $userID";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) :
                if ($row['verificationStat'] == "Approved") :
                    $ID = $row['car_ID'] ?>
                    <option value="" selected disabled hidden>Choose One</option>
                    <option value="<?php echo $ID ?>">
                        <?php echo $row['car_MakeModel'] . " (" . $row['car_Color'] . ")" ?>
                    </option>
            <?php endif;
            endwhile; ?>
        </select>

        <div id="errorContainer"></div>
        <br>

        <?php
        $sql = "SELECT * FROM user WHERE user_ID = $userID";
        $result = $conn->query($sql); ?>

        <input type="submit" value="Submit" name="submit">
    </form>


    <script>
        function validateForm() {
            var route_Start = document.forms["route"]["route_Start"].value;
            var route_End = document.forms["route"]["route_End"].value;
            var route_Date = document.forms["route"]["route_Date"].value;
            var route_Depart = document.forms["route"]["route_Depart"].value;
            var route_Arrival = document.forms["route"]["route_Arrival"].value;
            var route_FrontSeat = document.forms["route"]["route_FrontSeat"].value;
            var route_SideSeat = document.forms["route"]["route_SideSeat"].value;
            var route_MidSeat = document.forms["route"]["route_MidSeat"].value;

            var errorMessages = [];

            if (route_Start === "" || route_End === "" || route_Date === "" || route_Depart === "" || route_Arrival === "" || route_FrontSeat === "" || route_SideSeat === "" || route_MidSeat === "") {
                errorMessages.push("Please fill in all fields");
            }

            var errorContainer = document.getElementById("errorContainer");
            errorContainer.innerHTML = "";

            if (errorMessages.length > 0) {
                var errorText = document.createElement("p");
                errorText.className = "error";
                errorText.textContent = errorMessages[0];
                errorContainer.appendChild(errorText);
                return false;
            }

            return true;
        }
    </script>

</body>

</html>