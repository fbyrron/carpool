<?php
// start the session
session_start();

// check if the save button is clicked
if (isset($_POST['save_edit'])) {
  // retrieve the updated profile information
  $updated_first_name = $_POST['firstname'];
  $updated_last_name = $_POST['lastname'];
  $updated_email = $_POST['email'];
  $updated_contact_number = $_POST['phone'];

  // perform validation on the user input
  // ...
  
  // connect to the database
  $conn = mysqli_connect("localhost", "root", "", "carpool");
  
  // update the user's information in the database
  $ID = $_SESSION['login_ID'];
  
  $update_query = "UPDATE user SET user_FirstName='$updated_first_name', user_LastName='$updated_last_name', user_Email='$updated_email', user_ContactNumber='$updated_contact_number' WHERE user_ID = '$ID'";
  if(mysqli_query($conn, $update_query)) {
    // show success message
    echo "<script>alert('Profile update successful')</script>";
    $_SESSION['login_ID'] = $ID;
    $_SESSION['login_Email'] = $updated_email;
    $_SESSION['login_FirstName'] = $updated_first_name;
    $_SESSION['login_LastName'] = $updated_last_name;
    $_SESSION['login_ContactNumber'] = $updated_contact_number;
  } else {
    // show error message
    echo "<script>alert('Error updating profile')</script>";
  }
  // close the database connection
  mysqli_close($conn);

  // redirect the user back to the profile page
  header("Location: profile.php");
  exit();
}

if (isset($_POST['save_pass'])) {
  // retrieve the updated profile information
  $old_pass = $_POST['old_pass'];
  $new_pass = $_POST['new_pass'];
  $confirm_pass = $_POST['confirm_pass'];
  $current_pass = $_SESSION['login_Password'];

  // connect to the database
  $conn = mysqli_connect("localhost", "root", "", "carpool");
  
  // update the user's information in the database
  $ID = $_SESSION['login_ID'];
  
  if ($old_pass == $current_pass) {
    if ($new_pass == $confirm_pass) {
      $verified_new_pass = $new_pass;
      $update_query = "UPDATE user SET user_Password='$verified_new_pass' WHERE user_ID='$ID'";
      if(mysqli_query($conn, $update_query)) {
        // show success message
        echo "<script>alert('Password change successful')</script>";
        $_SESSION['login_Password'] = $verified_new_pass;
    
      } else {
        // show error message
        echo "<script>alert('Error updating password ')</script>";
      }
      // close the database connection
      mysqli_close($conn);
    
      // redirect the user back to the profile page
      header("Location: profile.php");
      exit();
      // Execute the update query here
    } else {
      // New password and confirm password don't match, show error message
      echo "<script>window.alert('New password and confirm password don\'t match.')</script>";
    }
  } else {
    // Old password is incorrect, show error message
    echo "<script>window.alert('Incorrect old password.')</script>";
  }
}
?>