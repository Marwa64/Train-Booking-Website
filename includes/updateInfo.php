<?php
  session_start();
  include_once ('sqlConnection.php');

  $error = 'false';

  $name = mysqli_real_escape_string($connect, $_GET['name']);
  $email = mysqli_real_escape_string($connect, $_GET['email']);
  $password = mysqli_real_escape_string($connect, $_GET['password']);

  $selectEmail = "SELECT * FROM user_data WHERE user_email = '$email';";
  $selectName = "SELECT * FROM user_data WHERE user_name = '$name';";
  $emailResult = mysqli_query($connect, $selectEmail);
  $nameResult = mysqli_query($connect, $selectName);

  if ($email != $_SESSION['email']){
    // Checks if the email is taken
    if (mysqli_num_rows($emailResult) > 0){
      echo "There is already an account with this email";
      $error = 'true';
    }
  }
  if ($name != $_SESSION['name']){
    // Checks if the user name is taken
    if (mysqli_num_rows($nameResult) > 0){
      echo "This user name is taken";
      $error = 'true';
    }
  }
 if ($error === 'false'){
   // Updates the account
    $sqlInsert = "UPDATE user_data SET user_name='$name', user_email='$email', user_password='$password' WHERE user_ID='$_SESSION[userID]';";
    if (mysqli_query($connect, $sqlInsert)){
      // Update sessions
      $_SESSION['name'] = $name;
      $_SESSION['email'] = $email;
      echo "success";
    } else {
      die(mysqli_error($connect));
    }
  }
