<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <style>
        /* CSS for the navigation bar */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #6fc372;
        }

        .col {
            display: flex;
            align-items: center;
        }

        .col h3 {
            margin: 0;
            font-size: 16px;
        }

        .col a {
            color: #fff;
            text-decoration: none;
            background-color: #6fc372;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .col a:hover {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div id="route" class="col">
            <h3>E-wallet</h3>
            <?php
            if ($_SESSION['login_Type'] == "Driver") {
                $link = 'transaction/transaction.php';
            } elseif ($_SESSION['login_Type'] == "Passenger") {
                $link = 'transaction/cash-in.php';
            }
            ?>
            <div><a href="<?php echo $link ?>">Go to Transactions</a></div>
        </div>
        <div class="col">
            <div>
                <h3>Register a Car</h3>
            </div>
            <div><a href="carReg.html">Register Now</a></div>
        </div>
        <?php if ($_SESSION['login_Type'] == "Driver") : ?>
        <div class="col" id="cars">
            <h3>List of Registered Cars</h3>
            <div><a href="carList.php">View Cars</a></div>
        </div>
        <?php endif; ?>
        <div class="col">
            <h3>Profile</h3>
            <div><a href="profile.php">Go to Profile</a></div>
        </div>
    </div>
    <!-- Rest of your HTML code -->
</body>
</html>
