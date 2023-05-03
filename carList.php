<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpool";

// session_start();
// $user = $_SESSION['user_ID'];

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM car ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Car Registration List</title>
</head>
<body>
    <h1>Car Registration List</h1>
    <table>
        <tr>
            <th>Make & Model</th>
            <th>Color</th>
            <th>Plate Number</th>
            <th>Owner</th>
            <th>Owner's License Number</th>
            <th>Contact Number</th>
            <th>Verification Status</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['car_MakeModel']; ?></td>
            <td><?php echo $row['car_Color']; ?></td>
            <td><?php echo $row['car_PlateNumber']; ?></td>
            <td><?php echo $row['car_OwnerName']; ?></td>
            <td><?php echo $row['car_OwnerLicense']; ?></td>
            <td><?php echo $row['car_OwnerContactNo']; ?></td>
            <td><?php echo "Pending" ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
