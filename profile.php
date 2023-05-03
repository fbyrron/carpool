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
    button{
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;  }
  </style>
</head>
<body>
  <div class="container">
    <?php
    session_start();
    $user_Type = $_SESSION['login_Type'];
    $email = $_SESSION['login_Email'];
    $password = $_SESSION['login_Password'];
    $user_FirstName = $_SESSION['login_FirstName'];
    $user_LastName = $_SESSION['login_LastName'];
    $user_ContactNumber = $_SESSION['login_ContactNumber'];
    ?>

    <h1><?php echo $user_FirstName. " ". $user_LastName; ?></h1>
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
    </table>
    <br><br>
    <div>
        <button>Edit Profile</button>
    </div>

  </div>
</body>
</html>
