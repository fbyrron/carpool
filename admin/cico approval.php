<?php
include '../database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash-In/Cash-Out Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Container styles */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Tab styles */
        .tab {
            display: flex;
            justify-content: space-between;
            background-color: #4CAF50;
        }

        .tab .tablinks {
            flex: 1;
            text-align: center;
            background-color: inherit;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: background-color 0.3s;
            font-size: 17px;
            color: #fff;
        }

        .tab .tablinks:hover {
            background-color: #45a049;
        }

        .tab .tablinks.active {
            background-color: #3e8e41;
        }

        /* Tab content styles */
        .tabcontent {
            display: none;
            padding: 20px;
            border-top: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        #dr {
            text-align: center;
            padding-bottom: 10px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        input[type="number"] {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
  }
    </style>
</head>

<body>
    <?php include 'sidemenu.html' ?>
    <div class="container">
        <h1 id="dr">Verifrying Cash in / Cash Out</h1>
        <div class="tab" style="display: flex; justify-content: space-evenly;">
            <button class="tablinks active" onclick="openCity(event, 'cit')">Cash-In</button>
            <button class="tablinks" onclick="openCity(event, 'cot')">Cash-Out</button>
        </div>

        <div id="cit" class="tabcontent" style="display: block;">
            <table>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Con Fee</th>
                    <th>Gcash No.</th>
                    <th>Reference No.</th>
                    <th>Verification</th>
                </tr>
                <?php
                $sql = "SELECT * FROM cico INNER JOIN user ON cico.user_ID = user.user_ID WHERE c_Type = 'Cash-In' AND c_Status = 'Pending'";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) :
                ?>
                    <?php if ($row['c_Type'] == 'Cash-In') : ?>
                        <tr>
                            <td><?php echo $row['c_ID']; ?></td>
                            <td><?php echo $row['user_FirstName'] . " " . $row['user_LastName']; ?></td>
                            <td><?php echo $row['c_Amount']; ?></td>
                            <td><?php echo $row['c_InFee'] ?></td>
                            <td><?php echo $row['c_GcashAccNo']; ?></td>
                            <td><?php echo $row['c_GcashRef']; ?></td>
                            <form action="approveCico.php?c_ID=<?php echo $row['c_ID']; ?>" method="POST">
                                <td style="display: flex; justify-content: space-evenly;">
                                    <button type="submit" name="approve_btn" id="approve_btn" style="background-color: #6fc372;">Approve</button>
                                    <button type="submit" name="deny_btn" id="deny_btn" style="background-color: #dc5543;">Deny</button>
                                </td>
                                <input type="hidden" id="c_ID" name="c_ID" value="<?php echo $row['c_ID']; ?>">
                            </form>
                        </tr>
                <?php
                    endif;
                endwhile; ?>

            </table>
        </div>

        <div id="cot" class="tabcontent">
            <table>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Pro Fee</th>
                    <th>Reference No.</th>
                    <th>Verification</th>
                </tr>
                <?php
                $sql = "SELECT * FROM cico INNER JOIN user ON cico.user_ID = user.user_ID WHERE c_Type = 'Cash-Out' AND c_Status = 'Pending'";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) :
                ?>
                    <?php if ($row['c_Type'] == 'Cash-Out') : ?>
                        <tr>
                            <td><?php echo $row['c_ID']; ?></td>
                            <td><?php echo $row['user_FirstName'] . " " . $row['user_LastName']; ?></td>
                            <td><?php echo $row['c_Amount']; ?></td>
                            <td><?php echo $row['c_OutFee'] ?></td>
                            <form action="approveCico.php?c_ID=<?php echo $row['c_ID']; ?>" method="POST">
                            <td><input type="number" name="c_GcashRef" id="c_GcashRef"></td>
                                <td style="display: flex; justify-content: space-evenly;">
                                    <button type="submit" name="approve_btn" id="approve_btn" style="background-color: #6fc372;">Approve</button>
                                    <button type="submit" name="deny_btn" id="deny_btn" style="background-color: #dc5543;">Deny</button>
                                </td>
                                <input type="hidden" id="c_ID" name="c_ID" value="<?php echo $row['c_ID']; ?>">
                            </form>
                        </tr>
                <?php
                    endif;
                endwhile; ?>

            </table>
        </div>
    </div>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>

</html>