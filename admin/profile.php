<?php
session_start();
$ID = $_SESSION['admin_ID'];
$email = $_SESSION['admin_Email'];
$password = $_SESSION['admin_Password'];
$FirstName = $_SESSION['admin_FN'];
$LastName = $_SESSION['admin_LN'];
$Role = $_SESSION['admin_Role'];

$conn = new mysqli("localhost", "root", "", "carpool");
// Check connection
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

</head>
<body>
	<div class="container">
		<h1><?php echo $FirstName. " " . $LastName; ?></h1>
		<div id="table">
		<table>
		<tr>
			<td>Role:</td>
			<td><?php echo $Role; ?></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><?php echo $FirstName. " ". $LastName; ?></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><?php echo $email; ?></td>
		</tr>
		</table>
	</div>
</div>
		<div class="side-menu">
			<span class="close-menu">&times;</span>
			<ul>
                <li style="padding-bottom: 40px; padding-top: 40px; font-size: xx-large; text-align: center;">Carpool</li>
				<a href="profile.php"><li>Profile</li></a>
				<a href="admincarlist.php"><li>Registered Cars</li></a>
				<a href="userlist.php"><li>List of User</li></a>
                <a href="http://localhost/carpool/"><li>Logout</li></a>
			</ul>
		<span class="open-menu" >&#9776;</span>
	</div>

	<script>
		const openBtn = document.querySelector('.open-menu');
		const closeBtn = document.querySelector('.close-menu');
		const sideMenu = document.querySelector('.side-menu');

		openBtn.addEventListener('click', () => {
			sideMenu.classList.add('open');
			openBtn.style.display = 'none';
			closeBtn.style.display = 'block';
		});

		closeBtn.addEventListener('click', () => {
			sideMenu.classList.remove('open');
			closeBtn.style.display = 'none';
			openBtn.style.display = 'block';
		});
	</script>
</body>
</html>
