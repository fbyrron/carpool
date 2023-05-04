<?php
session_start();

if (isset($_POST['save_edit'])) {
  $updated_VerificationStatus = $_POST['verificationStat'];
  $ID = $_SESSION['update_car_ID'];
  $conn = mysqli_connect("localhost", "root", "", "carpool");
  
  $update_query = "UPDATE car SET verificationStat = '$updated_VerificationStatus' WHERE car_ID = '$ID'";
  if(mysqli_query($conn, $update_query)) {
    // show success message
    $_SESSION['verificationStat'] = $updated_VerificationStatus;
    echo "<script>alert('Status update successful')</script>";

  } else {
    // show error message
    echo "<script>alert('Error updating status')</script>";
  }
  // close the database connection
  mysqli_close($conn);

  // redirect the user back to the profile page
  header("Location: admincarlist.php");
  exit();
}
?>