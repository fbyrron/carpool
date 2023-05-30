<?php
include '../database.php';
$route_ID = $_POST['routeID'];
$route_CarID = $_POST['routeCarID'];
// $carID = 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Route Details</title>
    <style>
        h2 {
            text-align: center;
        }

        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 50%;
            margin: 0 auto;
        }

        #cancel {
            background-color: #a5a5a5;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <?php
    $sql = "SELECT * FROM route WHERE route_ID = '$route_ID'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) :
        $driver = $row['user_ID'];
    ?>
        <h2>Route Details</h2>
        <table>
            <tr>
                <td>
                    <b>Date: </b>
                </td>
                <td>
                    <?php echo $row['route_Date'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Departure Time: </b>
                </td>
                <td>
                    <?php echo $row['route_Depart'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Est. Arrival time: </b>
                </td>
                <td>
                    <?php echo $row['route_Arrival'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Starting Point: </b>
                </td>
                <td>
                    <?php echo $row['route_Start'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Ending Point: </b>
                </td>
                <td>
                    <?php echo $row['route_End'] ?>
                </td>
            </tr>
        </table>
        <br><br>
        <h2>Seat Rates</h2>
        <table>
            <tr>
                <td>
                    <b>Front Seat Rate: </b>
                </td>
                <td>
                    <?php echo $row['route_FrontSeat'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Window Seat Rate: </b>
                </td>
                <td>
                    <?php echo $row['route_SideSeat'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Middle Seat Rate: </b>
                </td>
                <td>
                    <?php echo $row['route_MidSeat'] ?>
                </td>
            </tr>
        </table>
        <?php
        $sql = "SELECT * FROM user WHERE user_ID = '$driver'";
        $result = $conn->query($sql);
        $driverRow = $result->fetch_assoc()

        ?>
        <h2>Driver Details</h2>
        <table>
            <tr>
                <td>
                    <b>Driver:</b>
                </td>
                <td>
                    <?php echo $driverRow['user_FirstName'] . " " . $driverRow['user_LastName'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Driver's License:</b>
                </td>
                <td>

                </td>
            </tr>
        </table>
    <?php endwhile ?>

    <?php
    $sql = "SELECT * FROM car WHERE car_ID = '$route_CarID'";
    $result = $conn->query($sql);
    $CarRow = $result->fetch_assoc()
    ?>
    <h2>Car Details</h2>
    <table>
        <tr>
            <td>
                <b>Make & Model:</b>
            </td>
            <td>
                <?php echo $CarRow['car_MakeModel'] ?>
            </td>
        </tr>
        <tr>
            <td>
                <b>Color:</b>
            </td>
            <td>
                <?php echo $CarRow['car_Color'] ?>
            </td>
        </tr>
        <tr>
            <td>
                <b>Plate No.:</b>
            </td>
            <td>
                <?php echo $CarRow['car_PlateNumber'] ?>
            </td>
        </tr>
    </table>
    <br><br>
    <form action="submit.php" method="post">
        <input id="cancel" type="submit" value="Cancel Schedule">
    </form>
    <br><br><br><br>
</body>

</html>