<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpool</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Carpool Login</h1>
    <form action="login.php" method="post">
        <label for="user_Email">Email</label><br>
        <input type="text" name="user_Email" id="user_Email" required><br><br>

        <label for="user_Password">Password</label><br>
        <input type="password" name="user_Password" id="user_Password" required>
        <?php
        session_start();
        if (isset($_SESSION['login_error'])) {
            echo '<p style="color: red">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>
        <br><br>

        <input type="submit" value="Login"><br><br><br>

        <div id="dont">
            <p></p>Don't have an Account?</p><a href="userReg.php">Register Here</a>
        </div>
    </form>

    <script src="login.php"></script>
</body>

</html>