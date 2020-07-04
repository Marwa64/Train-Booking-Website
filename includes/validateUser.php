<?php
  session_start();
  include_once ('sqlConnection.php');

  $email = mysqli_real_escape_string($connect, $_GET['email']);
  $password = mysqli_real_escape_string($connect, $_GET['password']);
  $select = "SELECT * FROM user_data WHERE user_email = '$email' AND user_password = '$password';";
  $result = mysqli_query($connect, $select);
  // Account exists
  if (mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $_SESSION['name'] = $row["user_name"];
    $_SESSION['userID'] = $row["user_ID"];
    $_SESSION['role'] = $row["role"];
    $_SESSION['email'] = $row["user_email"];
    echo '<span id="successMessage"> Login successful! </span>';
  // Account doesn't exist
  } else {
    echo 'Incorrect email or password';
  }
