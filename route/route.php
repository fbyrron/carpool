<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
<?php 
include '../database.php'; 
include '../navbar.php' ;
?>
    <div class="row">
        <div class="col">
            <div>
                <h3>View Route</h3>
            </div>
            <br>
            <div><a href="viewRoute.php"><button>Here</button></a></div>
        </div>
        <div class="col">
            <h3>Create Route</h3> <br>
            <div><a href="createRoute.php"><button>Here</button></a></div>
        </div>
    </div>
    <?php 
    $type = $_SESSION['login_Type'] ?>
    <script>
        let route = document.getElementById('route');
        let type = '<?php echo $_SESSION['login_Type']; ?>';
    </script>
</body>

</html>