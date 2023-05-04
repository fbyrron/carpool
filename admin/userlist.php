<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpool";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <title>Car Registration List</title>
</head>
<body>
    <h1>Carpol User List</h1>
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Contact Number</th>
            <th>Email Address</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['user_ID']; ?></td>
            <td><?php echo $row['user_FirstName'] ." ". $row['user_LastName']; ?></td>
            <td><?php echo $row['user_Type']; ?></td>
            <td><?php echo $row['user_ContactNumber']; ?></td>
            <td><?php echo $row['user_Email']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table><br><br><br><br>
</body>
</html>

<?php
$conn->close();
?>
