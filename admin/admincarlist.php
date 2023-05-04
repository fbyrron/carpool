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

$sql = "SELECT * FROM user INNER JOIN car ON user.user_ID = car.user_ID";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <title>Car Registration List</title>
    <style>
        form {
            width: 90%;
            margin: 0 auto ;
            margin-bottom: 0px;
            padding: 0px;
            padding-left: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-top: 0px;
            border: 0px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 ;
        }
        #edit {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width:100%;
            margin: 0 auto;
        }
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
    <h1 id="h1" style="padding-bottom: 0px">Car Registration List</h1>
    <p style="text-align: center; padding-bottom: 20px" id="p1"></p>
    <div id="list"> 
    <table>
        <div style="text-align: center; padding-bottom:20px;"><button style="padding: 5px 10px; border-style: solid; border-width: 2px; border-color: black;" onclick="edit()">Change Verification Status</button></div>
        <tr>
            <th>ID</th>
            <th>Make & Model</th>
            <th>Color</th>
            <th>Plate Number</th>
            <th>Chasis Number</th>
            <th>Owner</th>
            <th>Contact Number</th>
            <th>Verification Status</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['car_ID']; ?></td>
            <td><?php echo $row['car_MakeModel']; ?></td>
            <td><?php echo $row['car_Color']; ?></td>
            <td><?php echo $row['car_PlateNumber']; ?></td>
            <td><?php echo $row['car_ChasisNumber']; ?></td>
            <td><?php echo $row['user_FirstName'] ." ". $row['user_LastName']; ?></td>
            <td><?php echo $row['user_ContactNumber']; ?></td>
            <td><div id="verification"><?php echo $row['verificationStat']; ?></div></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
    
<div  id="editable">
    <form action="editVerification.php" method="POST">
        <div style="text-align: center; padding-bottom:20px;"><input type="submit" value="Save Changes" name="save_edit" id="save_edit" style="padding: 5px 10px; border-style: solid; border-width: 2px; border-color: black;"></div>
        <?php
    $sql = "SELECT * FROM user INNER JOIN car ON user.user_ID = car.user_ID";
    $result = $conn->query($sql);
    ?>

<table id="edit">
    <tr>
            <th>ID</th>
            <th>Make & Model</th>
            <th>Color</th>
            <th>Plate Number</th>
            <th>Chasis Number</th>
            <th>Owner</th>
            <th>Contact Number</th>
            <th>Verification Status</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
            <td><?php echo $row['car_ID']; ?></td>
            <td><?php echo $row['car_MakeModel']; ?></td>
            <td><?php echo $row['car_Color']; ?></td>
            <td><?php echo $row['car_PlateNumber']; ?></td>
            <td><?php echo $row['car_ChasisNumber']; ?></td>
            <td><?php echo $row['user_FirstName'] ." ". $row['user_LastName']; ?></td>
            <td><?php echo $row['user_ContactNumber']; ?></td>
            <td>
                <select name="verificationStat" id="verificationStat">
                    <option value=""disabled selected><?php echo $row['verificationStat']; ?></option>
                    <option value="Pending">Pending</option>
                    <option value="Denied">Denied</option>
                    <option value="Approved">Approved</option>
                </select>
            </td>
            <input type="hidden" name="car_ID" value="<?php echo $row['car_ID']; ?>">
        </tr>
        <?php endwhile; 
        ?>

    </table>
    </form>
</div>

    <script> 
    list = document.getElementById('list');
    editable = document.getElementById('editable');
    
    list.style.display = "block";
    editable.style.display = "none"
    
    function edit(){    
        list.style.display = "none";
        editable.style.display = "block"    
        
        document.getElementById('p1').innerHTML = "You may change the Verification Status by clicking a specific ststus"
        document.getElementById('h1').innerHTML = "Edit Verification Status"
    }

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
</body>
</html>
