<?php
include("connection.php");

if (isset($_POST['email'])) {
  // Retrieve the email value from the AJAX request
  $email = $_POST['email'];

  // Query the database to check if a record with the entered email exists
  $query = "SELECT record FROM form WHERE email = '$email'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $filePath = $row['record'];

    // Return the file path as the response
    echo $filePath;
  } else {
    // No record found for the entered email
    echo "No record found for the entered email";
  }

  mysqli_close($conn);
}


