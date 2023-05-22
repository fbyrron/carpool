<?php
include '../database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['login_ID'];

$sql = "SELECT * FROM user WHERE user_ID = $userID";
$result = $conn->query($sql);

$successMessage = "";
if (isset($_SESSION['cashInSuccess'])) {
    $successMessage = $_SESSION['cashInSuccess'];
    unset($_SESSION['cashInSuccess']); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cash-In</title>
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

<body>
  <?php include '../navbar.php' ?>
  <h1>Cash-In</h1>
  <?php if ($successMessage !== ""): ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>
  <form action="saveTransaction.php" method="POST" class="form-container" name="cashInForm" onsubmit="return validateForm()">

    <input type="hidden" name="trans_Type" value="Cash-In">

    <label><b>Amount</b></label><br>
    <!-- 50 -->
    <input type="radio" id="50" name="trans_Amount" value="50">
    <label for="50">50 pesos (40 tickets)</label><br>
    <!-- 100 -->
    <input type="radio" id="100" name="trans_Amount" value="100">
    <label for="100">100 pesos (80 tickets)</label><br>
    <!-- 250 -->
    <input type="radio" id="250" name="trans_Amount" value="250">
    <label for="250">250 pesos (200 tickets)</label><br>
    <!-- 500 -->
    <input type="radio" id="500" name="trans_Amount" value="500">
    <label for="500">500 pesos (450 tickets)</label>
    <br><br><br>

    <label for="trans_GcashAccNo"><b>Gcash Account Number</b></label>
    <input type="text" name="trans_GcashAccNo" id="trans_GcashAccNo">
    <br><br>

    <label for="trans_GcashAccName"><b>Gcash Account Name</b></label>
    <input type="text" name="trans_GcashAccName" id="trans_GcashAccName">
    <br><br>

    <label for="trans_GcashRefNo"><b>Gcash Transaction Reference Number</b></label>
    <input type="number" name="trans_GcashRefNo" id="trans_GcashRefNo">
    <br><br>
    <div id="errorContainer"></div>
    <br>

    <input type="submit" value="Submit" name="submit">
  </form>


  <script>
    function validateForm() {
      var amount = document.forms["cashInForm"]["trans_Amount"].value;
      var gcashAccNo = document.forms["cashInForm"]["trans_GcashAccNo"].value;
      var gcashAccName = document.forms["cashInForm"]["trans_GcashAccName"].value;
      var gcashRefNo = document.forms["cashInForm"]["trans_GcashRefNo"].value;

      var errorMessages = [];

      if (amount === "" || gcashAccNo === "" || gcashAccName === "" || gcashRefNo === "") {
        errorMessages.push("Please fill in all fields");
      }

      var errorContainer = document.getElementById("errorContainer");
      errorContainer.innerHTML = ""; // Clear previous error messages

      if (errorMessages.length > 0) {
        var errorText = document.createElement("p");
        errorText.className = "error";
        errorText.textContent = errorMessages[0];
        errorContainer.appendChild(errorText);
        return false; // Prevent form submission
      }

      return true; // Allow form submission
    }
  </script>

</body>

</html>









<!-- <label for="SPoint">Starting Point</label>
  <input type="text" name="SPoint" id="SPoint" class="form-input">

  <label for="DOPoint">Drop-Off Point</label>
  <input type="text" name="DOPoint" id="DOPoint" class="form-input">

  <input type="submit" value="Submit" class="form-submit"> -->