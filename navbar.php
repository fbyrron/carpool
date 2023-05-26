<style>
    /* CSS for the navigation bar */
    .navbar {
        background-color: #4CAF50;
        overflow: hidden;
    }

    .navbar ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar li {
        flex-grow: 1;
    }

    .navbar a {
        display: block;
        color: #fff;
        text-align: center;
        padding: 16px;
        text-decoration: none;
        transition: background-color 0.3s;
        font-family: Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        border-bottom: 2px solid transparent;
    }

    .navbar a:hover {
        background-color: #6fc372;
        border-bottom-color: #fff;
    }
</style>

<?php
$ID = $_SESSION['login_ID'];
$sql = "SELECT * FROM user WHERE user_ID = '$ID'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) :
    if ($row['user_ID'] == $ID) :
        $user_Type =  $row['user_Type'];
        $user_Balance = $row['user_AccBalance'];
    endif;
endwhile;
?> 
<div class="navbar" style="margin-bottom: 50px;">
    <ul>
        <li id="route">
            <?php
            if ($user_Type == "Driver") {
                $link = 'http://localhost/carpool/transaction/transaction.php';
            } elseif ($user_Type == "Passenger") {
                $link = 'http://localhost/carpool/transaction/cash-in.php';
            }
            ?>
            <a href="<?php echo $link ?>">
                E-wallet
            </a>
        </li>
        <li id="">
            <?php
            if ($user_Type == "Driver") {
                $link = 'http://localhost/carpool/route/route.php';
            } elseif ($user_Type == "Passenger") {
                $link = 'http://localhost/carpool/route/viewRoute.php';
            }
            ?>
            <a href="<?php echo $link ?>">
                Routes
            </a>
        </li>
        <li>
            <a href="http://localhost/carpool/carReg.php">
                Register a Car
            </a>
        </li>
        <?php if ($user_Type == "Driver") : ?>
            <li>
                <a href="http://localhost/carpool/carList.php">
                    List of Registered Cars
                </a>
            </li>
        <?php endif; ?>
        <li>
            <a href="http://localhost/carpool/profile.php">
                Profile
            </a>
        </li>
    </ul>
</div>