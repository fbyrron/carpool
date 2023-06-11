<?php
include '../database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carpool Cash Flows</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Container styles */
    .container {
      max-width: 800px;
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
  </style>
</head>

<body>
  <?php include 'sidemenu.html' ?>
  <div class="container">
    <h1 id="dr">Daily Cashflow</h1>
    <div class="tab" style="display: flex; justify-content: space-evenly;">
      <button class="tablinks active" onclick="openCity(event, 'cit')">Inflows</button>
      <button class="tablinks" onclick="openCity(event, 'cot')">Outflows</button>
      <!-- <button class="tablinks" onclick="openCity(event, 'bt')"></button> -->
    </div>

    <div id="cit" class="tabcontent" style="display: block;">
      <table>
        <tr>
          <th>#</th>
          <th>Description</th>
          <th>Amount</th>
        </tr>
        <?php
        $sql = "SELECT * FROM cash_flows";
        $result = $conn->query($sql);

        $totalAmount = 0;
        while ($row = $result->fetch_assoc()) :
        ?>
        <?php if ($row['cf_Type'] == 'Inflow'):?>
            <tr>
              <td><?php echo $row['cashflow_ID']; ?></td>
              <td><?php echo $row['cf_Description']; ?></td>
              <td><?php echo $row['cf_Amount']; ?></td>
            </tr>
        <?php
            $totalAmount += $row['cf_Amount'];
        endif;
        endwhile; ?>
        <tr>
          <td style="padding-top: 30px;" colspan="2"><strong>Total:</strong></td>
          <td style="padding-top: 30px;"><strong><?php echo $totalAmount; ?></strong></td>
        </tr>
      </table>
    </div>

    <div id="cot" class="tabcontent">
    <table>
        <tr>
          <th>#</th>
          <th>Description</th>
          <th>Amount</th>
        </tr>
        <?php
        $sql = "SELECT * FROM cash_flows";
        $result = $conn->query($sql);

        $totalAmount = 0;
        while ($row = $result->fetch_assoc()) :
        ?>
        <?php if ($row['cf_Type'] == 'Outflow'):?>
            <tr>
              <td><?php echo $row['cashflow_ID']; ?></td>
              <td><?php echo $row['cf_Description']; ?></td>
              <td><?php echo $row['cf_Amount']; ?></td>
            </tr>
        <?php
            $totalAmount += $row['cf_Amount'];
        endif;
        endwhile; ?>
        <tr>
          <td style="padding-top: 30px;" colspan="2"><strong>Total:</strong></td>
          <td style="padding-top: 30px;"><strong><?php echo $totalAmount; ?></strong></td>
        </tr>
      </table>
    </div>

    <div id="bt" class="tabcontent">
      <table>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Balance</th>
        </tr>
        <?php
        $sql = "SELECT user_ID, user_FirstName, user_LastName, user_AccBalance FROM user";
        $result = $conn->query($sql);

        $totalBalance = 0;
        while ($row = $result->fetch_assoc()) :
        ?>
          <tr>
            <td><?php echo $row['user_ID']; ?></td>
            <td><?php echo $row['user_FirstName'] . " " . $row['user_LastName']; ?></td>
            <td><?php echo $row['user_AccBalance']; ?></td>
          </tr>
        <?php
          $totalBalance += $row['user_AccBalance'];
        endwhile; ?>
        <tr>
          <td style="padding-top: 30px;" colspan="2"><strong>Total:</strong></td>
          <td style="padding-top: 30px;"><strong><?php echo $totalBalance; ?></strong></td>
        </tr>
      </table>
      <p></p>
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