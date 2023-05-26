<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include 'database.php';
    include 'navbar.php';
    ?>
    <h1>Car Registration</h1>

    <form action="carRegis.php" method="post">
        <h3>Car's Details</h3>
        <label for="car_MakeModel">Make & Model</label><br>
        <input type="text" name="car_MakeModel" id="car_MakeModel" required><br><br>

        <label for="car_Color">Color</label><br>
        <input type="text" name="car_Color" id="car_Color" required><br><br>

        <label for="car_Year">Year of Manufacture</label><br>
        <input type="text" name="car_Year" id="car_Year" required><br><br>

        <label for="car_PlateNumber">Plate Number</label><br>
        <input type="text" name="car_PlateNumber" id="car_PlateNumber" required><br><br>

        <label for="car_ChasisNumber">Chasis Number</label><br>
        <input type="text" name="car_ChasisNumber" id="car_ChasisNumber" required><br><br><br>

        <input type="submit" name="regCar">
    </form>
</body>

</html>