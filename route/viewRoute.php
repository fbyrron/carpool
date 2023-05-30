<?php
include '../database.php';

$ID = $_SESSION['login_ID'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Routes</title>
</head>
<header>
    <?php include '../navbar.php' ?>
</header>

<body>
    <div id="routes">
        <h2 style="text-align: center;">Today's Routes</h2>
        <table>
            <?php
            $today = date("Y-m-d");
            $sql = "SELECT * FROM route  WHERE route_Date = '$today' ORDER BY route_Depart ASC";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) :
                // $routeID = $row['route_ID']
            ?>
                <tr>
                    <form action="routeDetails.php" method="post">
                        <td><?php echo $row['route_Start'] . " - " . $row['route_End'] ?></td>
                        <td><?php echo $row['route_Depart'] . " - " . $row['route_Arrival'] ?></td>
                        <td>
                            <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                            <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                            <input type="submit" value="View Route"></input>
                        </td>
                    </form>
                </tr>
            <?php
            endwhile ?>
        </table>

        <h2 style="text-align: center; padding-top: 50px">Tomorrow's Routes</h2>
        <table>
            <?php
            $tomorrow = date("Y-m-d", strtotime("+1 day"));
            $sql = "SELECT * FROM route WHERE route_Date = '$tomorrow' ORDER BY route_Depart ASC";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) :
            ?>
                <tr>
                    <form action="routeDetails.php" method="post">
                        <div>
                        <td><?php echo $row['route_Start'] . " - " . $row['route_End'] ?></td>
                        <td><?php echo $row['route_Depart'] . " - " . $row['route_Arrival'] ?></td>
                        <td>
                            <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                            <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                            <input type="submit" value="View Route"></input>
                        </td>
                    </form>
                </tr>
            <?php

            endwhile ?>
        </table>

        <h2 style="text-align: center; padding-top: 50px">Other Routes</h2>
        <table>
            <?php
            $today = date("Y-m-d");
            $tomorrow = date("Y-m-d", strtotime("+1 day"));
            $sql = "SELECT * FROM route WHERE route_Date != '$today' AND route_Date != '$tomorrow' ORDER BY route_Depart ASC";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) :
            ?>
                <tr>
                    <form action="routeDetails.php" method="post">
                        <td><?php echo $row['route_Start'] . " - " . $row['route_End'] ?></td>
                        <td><?php echo $row['route_Depart'] . " - " . $row['route_Arrival'] ?></td>
                        <td>
                            <input type="hidden" name="routeID" value="<?php echo $row['route_ID'] ?>">
                            <input type="hidden" name="routeCarID" value="<?php echo $row['route_CarID'] ?>">
                            <input type="submit" value="View Route"></input>
                        </td>
                    </form>
                </tr>
            <?php endwhile ?>
        </table>
    </div>
</body>

</html>