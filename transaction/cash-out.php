<?php
include '../database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['login_ID'];

$successMessage = "";
if (isset($_SESSION['cashOutSuccess'])) {
  $successMessage = $_SESSION['cashOutSuccess'];
  unset($_SESSION['cashOutSuccess']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cash-Out</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    input[type="radio"] {
      margin-right: 5px;
      vertical-align: middle;
    }

    input[type="number"],
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 16px;
      margin-bottom: 20px;
    }

    label {
      display: inline-block;
      vertical-align: middle;
    }

    .error {
      color: red;
    }

    .success {
      color: green;
      text-align: center;
      font-weight: 700;
    }
  </style>
</head>

  <?php
  $sql = "SELECT * FROM user WHERE user_ID = $userID";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) :
    $user_Balance = $row['user_AccBalance'];
  endwhile;
  ?>
<body>
  <?php include '../navbar.php' ?>

  <h1>Cash-Out</h1>
  <?php if ($successMessage !== "") : ?>
    <p class="success"><?php echo $successMessage; ?></p>
  <?php endif; ?>
  <form action="saveTransaction.php" method="POST" class="form-container" name="cashOutForm" onsubmit="return validateForm()">

    <input type="hidden" name="trans_Type" value="Cash-Out">

    <p style="text-align: center;"><b>Current Balance:</b> <?php echo $user_Balance ?> tickets</p><br>

    <label><b>Amount</b></label><br>
    <input type="number" name="trans_Amount" min="1" id="trans_Amount">
    <br><br>

    <label for="trans_GcashAccNo"><b>Gcash Account Number</b> (Receiver)</label>
    <input type="text" name="trans_GcashAccNo" id="trans_GcashAccNo">
    <br><br>

    <label for="trans_GcashAccName"><b>Gcash Account Name</b> (Receiver)</label>
    <input type="text" name="trans_GcashAccName" id="trans_GcashAccName">
    <br><br>

    <label for="trans_GcashAccName"><b>Account Password</b></label>
    <input type="password" name="user_Password" id="user_Password">
    <br><br>

    <!-- <label for="trans_GcashRefNo"><b>Gcash Transaction Reference Number</b></label>
    <input type="number" name="trans_GcashRefNo" id="trans_GcashRefNo">
    <br><br> -->
    <div id="errorContainer"></div>
    <br>

    <input type="submit" value="Submit" name="submit">
  </form>


  <script>
    function validateForm() {
      var enteredPass = document.forms["cashOutForm"]["user_Password"].value;
      var amount = document.forms["cashOutForm"]["trans_Amount"].value;
      var gcashAccNo = document.forms["cashOutForm"]["trans_GcashAccNo"].value;
      var gcashAccName = document.forms["cashOutForm"]["trans_GcashAccName"].value;
      var trans_Amount = document.forms["cashOutForm"]["trans_Amount"].value;
      var fee = Math.ceil(trans_Amount / 1000) * 20;

      var errorMessages = [];

      if (amount === "" || gcashAccNo === "" || gcashAccName === "") {
        errorMessages.push("Please fill in all fields");
      } else if (enteredPass !== "<?php echo $_SESSION['login_Password'] ?>") {
        errorMessages.push("Incorrect password");
      } else if (parseInt("<?php echo $user_Balance ?>") < (parseInt(amount) + parseInt(fee))) {
        errorMessages.push("You don't have enough tickets to continue");
      }


      var errorContainer = document.getElementById("errorContainer");
      errorContainer.innerHTML = "";

      if (errorMessages.length > 0) {
        var errorText = document.createElement("p");
        errorText.className = "error";
        errorText.textContent = errorMessages.join(" <br> ");
        errorContainer.appendChild(errorText);
        return false; 
      }

      return true; 
    }
  </script>


</body>

</html>









<!-- <label for="SPoint">Starting Point</label>
  <input type="text" name="SPoint" id="SPoint" class="form-input">

  <label for="DOPoint">Drop-Off Point</label>
  <input type="text" name="DOPoint" id="DOPoint" class="form-input">

  <input type="submit" value="Submit" class="form-submit"> -->