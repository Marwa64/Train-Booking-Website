<?php
  include_once ('sqlConnection.php');

  $name = mysqli_real_escape_string($connect, $_GET['name']);
  $email = mysqli_real_escape_string($connect, $_GET['email']);
  $password = mysqli_real_escape_string($connect, $_GET['password']);

  $selectEmail = "SELECT * FROM user_data WHERE user_email = '$email';";
  $selectName = "SELECT * FROM user_data WHERE user_name = '$name';";
  $emailResult = mysqli_query($connect, $selectEmail);
  $nameResult = mysqli_query($connect, $selectName);
  // Checks if the email is taken
  if (mysqli_num_rows($emailResult) > 0){
    echo "There is already an account with this email";
  // Checks if the user name is taken
  } else if (mysqli_num_rows($nameResult) > 0){
    echo "This user name is taken";
  // Adds the account to the database
  } else {
    $sqlInsert = "INSERT INTO user_data (user_name, user_email, user_password, role) VALUES ('$name', '$email', '$password', 'Customer');";
    mysqli_query($connect, $sqlInsert);
    echo '<span id="successMessage"> Account has been created successfully! </span>';
  }
