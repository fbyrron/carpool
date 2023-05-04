<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpool";

session_start();
$ID = $_SESSION['login_ID'];


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM car WHERE user_ID = '$ID'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      background-color: #f2f2f2;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 50px 20px;
      background-color: #fff;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
      margin: 0;
      font-size: 32px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
      font-weight: normal;
    }

    td:first-child {
      font-weight: bold;
      width: 30%;
    }

    td:last-child {
      font-weight: 500;
      color: #666;
    }
    input[type="submit"]{
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px; 
    }
    button{
      background-color: #4CAF50;
      color: white;
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 12px;  
    }
    input[type="text"], input[type="email"], input[type="tel"], input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 16px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
    $user_Type = $_SESSION['login_Type'];
    $email = $_SESSION['login_Email'];
    $password = $_SESSION['login_Password'];
    $user_FirstName = $_SESSION['login_FirstName'];
    $user_LastName = $_SESSION['login_LastName'];
    $user_ContactNumber = $_SESSION['login_ContactNumber'];
    ?>

    <h1><?php echo $user_FirstName. " " . $user_LastName; ?></h1>
    <div id="table">
    <table>
      <tr>
        <td>Type:</td>
        <td><?php echo $user_Type; ?></td>
      </tr>
      <tr>
        <td>Name:</td>
        <td><?php echo $user_FirstName. " ". $user_LastName; ?></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td><?php echo $email; ?></td>
      </tr>
      <tr>
        <td>Contact Number:</td>
        <td><?php echo $user_ContactNumber; ?></td>
      </tr>
      <tr>
        <td style="vertical-align:top">Registered Car:</td>
        <td>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php echo $row['car_MakeModel'] . "<br>"; ?>
          <?php endwhile; ?>
        </td>
      </tr>



    </table>

    <br><br>
    <div>
        <button onclick="edit()">Edit Profile</button>
    </div><br>
    <div>
        <button onclick="editpass()">Change Password</button>
    </div><br>
    <div>
        <a href="http://localhost/carpool/"><button style="background-color: #C23A22;">Logout</button></a>
    </div>

  </div>
    
    <div id="editable">
    <p id="p1" style="text-align: center;"></p>
    <form method="POST" action="update_profile.php">
      <table>
        <tr>
          <td>Type:</td>
          <td><?php echo $user_Type; ?></td>
        </tr>
        <tr>
            <td>Name:</td>
              <td>
                <span><input type="text" name="firstname" id="firstname" value='<?php echo $user_FirstName; ?>'></span>
                <span><input type="text" name="lastname" id="lastname" value='<?php echo $user_LastName; ?>'></span>
              </td>
          </tr>
          <tr>
            <td>Email:</td>
            <td><input type="email" name="email" id="email" value=<?php echo $email; ?>></td>
          </tr>
          <tr>
            <td>Contact Number:</td>
            <td><input type="tel" name="phone" id="phone" value=<?php echo $user_ContactNumber; ?>></td>
          </tr>
        </table>
        <br><br>
        <input type="submit" name="save_edit" value="Save edit">
      </form>

      </div>

      <div id="password">
    <form method="POST" action="update_profile.php">
      <table>
        <tr>
            <td>Current Password:</td>
              <td>
                <input type="password" name="old_pass" id="old_pass">
              </td>
          </tr>
          <tr>
            <td>New Password:</td>
            <td><input type="password" name="new_pass" id="new_pass"></td>
          </tr>
          <tr>
            <td>Confirm New Password:</td>
            <td><input type="password" name="confirm_pass" id="confirm_pass"></td>
          </tr>
        </table>     
        <br><br>
        <input type="submit" name="save_pass" value="Save Password">
      </form>

      </div>

    <script>
      table = document.getElementById("table");
      editable = document.getElementById("editable");
      password = document.getElementById("password");

      editable.style.display = "none";
      password.style.display = "none"

      function edit(){            
          table.style.display = "none";
          editable.style.display = "block";
          password.style.display = "none";

          document.getElementById('p1').innerHTML = "You may now edit your Profile"
        }
      function editpass(){
        table.style.display = "none";
        editable.style.display = "none";
        password.style.display = "block";
      }  

    </script>
  </div>
</body>
</html>
