<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpool";

session_start();
$ID = $_SESSION['login_ID'];
$ownerFN = $_SESSION['login_FirstName'];
$ownerLN = $_SESSION['login_LastName'];
$ownerCN = $_SESSION['login_ContactNumber'];

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user INNER JOIN car ON user.user_ID = car.user_ID WHERE car.user_ID = '$ID'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Car Registration List</title>
    <style>
        #verification {
            background-color: #5ba9c3;
            text-align: center;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body onload="verification()">
<h1>Car Registration List</h1>
<table>
    <tr>
        <th>Make & Model</th>
        <th>Color</th>
        <th>Year of Manufacture</th>
        <th>Plate Number</th>
        <th>Chasis Number</th>
        <th>Verification Status</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['car_MakeModel']; ?></td>
            <td><?php echo $row['car_Color']; ?></td>
            <td><?php echo $row['car_Year']; ?></td>
            <td><?php echo $row['car_PlateNumber']; ?></td>
            <td><?php echo $row['car_ChasisNumber']; ?></td>
            <td><div id="verification"><?php echo $row['verificationStat']; ?></div></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>

<script>
    function verification () {
            var elements = document.querySelectorAll('#verification');
            for (var i = 0; i < elements.length; i++) {
                var status = elements[i].innerHTML.trim();
                if (status == 'Approved') {
                    elements[i].style.backgroundColor = '#6fc372';
                }
                else if (status == 'Denied') {
                    elements[i].style.backgroundColor = '#dc5543';
                }
            }
        }
</script>

<?php
$conn->close();
?>
