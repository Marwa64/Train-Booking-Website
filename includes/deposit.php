<?php
 session_start();
  include_once ('sqlConnection.php');

  $amount = mysqli_real_escape_string($connect, $_GET['amount']);
  if ($amount == ""){
    echo "Enter an amount";
  } else {
    $sql="UPDATE user_data SET balance=balance+'$amount' WHERE user_ID='$_SESSION[userID]';";
    if (mysqli_query($connect, $sql)){
      echo "Amount has been deposited";
    }
  }
