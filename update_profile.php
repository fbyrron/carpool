<?php
// start the session
session_start();

// check if the save button is clicked
if (isset($_POST['save_btn'])) {
  // retrieve the updated profile information
  $updated_first_name = $_POST['first_name'];
  $updated_last_name = $_POST['last_name'];
  $updated_email = $_POST['email'];
  $updated_contact_number = $_POST['contact_number'];

  // perform validation on the user input
  // ...

  // connect to the database
  $conn = mysqli_connect("localhost", "username", "password", "database_name");

  // update the user's information in the database
  $user_id = $_SESSION['user_id']; // get the user's ID from the session
  $update_query = "UPDATE users SET first_name='$updated_first_name', last_name='$updated_last_name', email='$updated_email', contact_number='$updated_contact_number' WHERE id='$user_id'";
  mysqli_query($conn, $update_query);

  // close the database connection
  mysqli_close($conn);

  // redirect the user back to the profile page
  header("Location: profile.php");
  exit();
}
?>
