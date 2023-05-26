

<?php
include "../database.php";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Step 1: Check for database connection errors
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Set up prepared statement
    $stmt = $conn->prepare("INSERT INTO cico (user_ID, c_Type, c_Amount, c_GcashAccNo, c_GcashAccName, c_GcashRef, c_OutFee, c_InFee, c_Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Step 3: Retrieve the form data using PHP $_POST variable
    if (isset($_POST['submit'])) {
        $user_ID = $_SESSION['login_ID'];
        $trans_Type = $_POST["trans_Type"];
        $trans_Amount = $_POST["trans_Amount"];
        $trans_GcashAccNo = $_POST["trans_GcashAccNo"];
        $trans_GcashAccName = $_POST["trans_GcashAccName"];
        $trans_Status = 'Pending';
        if ($trans_Type == 'Cash-In') {
            $trans_GcashRefNo = $_POST["trans_GcashRefNo"];
            $c_OutFee = 0;
            if ($trans_Amount == 50) {
                $c_InFee = 10;
            } elseif ($trans_Amount == 100) {
                $c_InFee = 20;
            } elseif ($trans_Amount == 250 || $trans_Amount == 500) {
                $c_InFee = 50;
            } else {
                // Default value if none of the conditions are met
                $c_InFee = 0;
            }
        } else if ($trans_Type == 'Cash-Out') {
            $trans_GcashRefNo = 0;
            $c_InFee = 0;
            $c_OutFee = ceil($trans_Amount / 1000) * 20;
        }

        // Step 4: Bind the parameters to the statement
        $stmt->bind_param("dsdssddds", $user_ID, $trans_Type, $trans_Amount, $trans_GcashAccNo, $trans_GcashAccName, $trans_GcashRefNo, $c_OutFee, $c_InFee, $trans_Status);

        // Step 5: Execute the statement
        if ($stmt->execute()) {
            if ($trans_Type == 'Cash-In') {
                $_SESSION['cashInSuccess'] = "Your cash-in is now being processed. Please wait for the admin to verify.";
                header('Location: cash-in.php');
                exit();
            } else if ($trans_Type == 'Cash-Out') {
                $_SESSION['cashOutSuccess'] = "Your cash-out is now being processed. Please wait for the admin to verify.";
                header('Location: cash-out.php');
                exit();
            }
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    }

    // Step 6: Close the statement and connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>


