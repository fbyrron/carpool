<?php
include 'database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cico INNER JOIN user ON cico.user_ID = user.user_ID";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        table {
  font-family: Arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 20px;
}

table th, table td {
  border: 1px solid #ddd;
  padding: 8px;
}

table th {
  background-color: #f2f2f2;
  text-align: left;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}

table tr:hover {
  background-color: #ddd;
}

@media screen and (max-width: 600px) {
  table {
    border-collapse: collapse;
    width: 100%;
  }
  
  table th, table td {
    border: none;
    padding: 8px;
    text-align: left;
  }
  
  table th {
    background-color: #f2f2f2;
    font-weight: bold;
    color: #333;
  }
  
  table tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  table tr:nth-child(odd) {
    background-color: #fff;
  }
  
  table tr:hover {
    background-color: #ddd;
  }
  h1{
    text-align: center;
  }
}

    </style>
</head>
<body>
    <h1>Daily Report</h1>
    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Pro Fee</th>
            <th>Con Fee</th>
            <th>Balance</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['c_ID']; ?></td>
            <td><?php echo $row['user_FirstName'] ." ". $row['user_LastName']; ?></td>
            <td><?php echo $row['c_Type']; ?></td>
            <td><?php echo $row['c_Amount']; ?></td>
            <td><?php echo $row['c_InFee'] ?></td>
            <td><?php echo $row['c_OutFee'] ?></td>
            <td><?php echo $row['user_AccBalance']; ?></td>
        </tr>
        
    <?php endwhile; ?>
    </table>
</body>
</html>

INSERT INTO transaction (user_ID, trans_Type, trans_Amount, trans_GcashAccNo,trans_GcashAccName,trans_GcashRefNo,trans_ProFee,trans_ConFee) 
VALUES 
(34, 'Cash-In', 1000,'09152085397' ,'John Doe', 21847293, 0, 100);