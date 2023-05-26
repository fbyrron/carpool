<?php
include 'database.php';

if (isset($_POST['save_edit'])) {
  $updated_first_name = $_POST['firstname'];
  $updated_last_name = $_POST['lastname'];
  $updated_email = $_POST['email'];
  $updated_contact_number = $_POST['phone'];

  $conn = new mysqli($servername, $username, $password, $dbname);

  $ID = $_SESSION['login_ID'];

  $update_query = "UPDATE user SET user_FirstName='$updated_first_name', user_LastName='$updated_last_name', user_Email='$updated_email', user_ContactNumber='$updated_contact_number' WHERE user_ID = '$ID'";
  if (mysqli_query($conn, $update_query)) {
    echo "<script>alert('Profile update successful')</script>";
    $_SESSION['login_ID'] = $ID;
    $_SESSION['login_Email'] = $updated_email;
    $_SESSION['login_FirstName'] = $updated_first_name;
    $_SESSION['login_LastName'] = $updated_last_name;
    $_SESSION['login_ContactNumber'] = $updated_contact_number;
  } else {
    echo "<script>alert('Error updating profile')</script>";
  }
  mysqli_close($conn);

  header("Location: profile.php");
  exit();
}

if (isset($_POST['save_pass'])) {
  $old_pass = $_POST['old_pass'];
  $new_pass = $_POST['new_pass'];
  $confirm_pass = $_POST['confirm_pass'];
  $current_pass = $_SESSION['login_Password'];

  $conn = mysqli_connect("localhost", "root", "", "carpool");

  $ID = $_SESSION['login_ID'];

  if ($old_pass == $current_pass) {
    if ($new_pass == $confirm_pass) {
      $verified_new_pass = $new_pass;
      $update_query = "UPDATE user SET user_Password='$verified_new_pass' WHERE user_ID='$ID'";
      if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Password change successful')</script>";
        $_SESSION['login_Password'] = $verified_new_pass;
      } else {
        echo "<script>alert('Error updating password ')</script>";
      }
      mysqli_close($conn);
      header("Location: profile.php");
      exit();
    } else {
      echo "<script>window.alert('New password and confirm password don\'t match.')</script>";
    }
  } else {
    echo "<script>window.alert('Incorrect old password.')</script>";
  }
}
