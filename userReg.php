<?php
$successMessage = "";
if (isset($_SESSION['registered'])) {
    $successMessage = $_SESSION['registered'];
    unset($_SESSION['registered']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpool</title>
    <link rel="stylesheet" href="style.css">
    <style>
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .success {
            color: green;
            text-align: center;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <h1>Carpooling App Registration</h1>

    <?php if ($successMessage !== "") : ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>



    <form action="confirmation.php" method="post">

        <!-- <label for="user_Type">User Type</label>
        <select name="user_Type" id="user_Type">
            <option value="Passenger">Passenger</option>
            <option value="Driver">Driver</option>
        </select><br><br><br> -->

        <label for="user_Email">Email</label><br>
        <input type="text" name="user_Email" required><br><br>

        <label for="user_Password">Password</label><br>
        <input type="password" name="user_Password" required><br><br><br>

        <label for="user_FirstName">First Name</label><br>
        <input type="text" name="user_FirstName" required><br><br>

        <label for="user_LastName">Last Name</label><br>
        <input type="text" name="user_LastName" required><br><br>

        <label for="user_ContactNumber">Contact Number</label><br>
        <input type="text" name="user_ContactNumber" required><br><br>

        <input type="submit" name="send">
    </form>

</body>

</html>