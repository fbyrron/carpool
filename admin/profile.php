<?php

include '../database.php';

$ID = $_SESSION['admin_ID'];
$email = $_SESSION['admin_Email'];
$password = $_SESSION['admin_Password'];
$FirstName = $_SESSION['admin_FN'];
$LastName = $_SESSION['admin_LN'];
$Role = $_SESSION['admin_Role'];

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM admin WHERE admin_ID = '$ID'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Admin</title>
	<link rel="stylesheet" href="admin.css">
	<style>
		.container {
			display: flex;
			justify-content: center;
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
		}

		#table {
			display: flex;
			justify-content: center;
			width: 100%;
			margin: 0 auto;
			margin-top: 30px;
		}

		#table h1 {
			text-align: center;
			margin-bottom: 20px;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		table td {
			padding: 10px;
			border: 1px solid #ddd;
		}

		table tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		table tr:hover {
			background-color: #ddd;
		}
	</style>
</head>

<body>
	<div class="container">
		<div id="table">
			<h1><?php echo $FirstName . " " . $LastName; ?></h1>
			<table>
				<tr>
					<td>Role:</td>
					<td><?php echo $Role; ?></td>
				</tr>
				<tr>
					<td>Name:</td>
					<td><?php echo $FirstName . " " . $LastName; ?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?php echo $email; ?></td>
				</tr>
			</table>
		</div>
	</div>
	<?php include 'sidemenu.html'; ?>
</body>

</html>