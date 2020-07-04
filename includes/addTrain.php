<?php
  session_start();
  include_once ('sqlConnection.php');

  $type = mysqli_real_escape_string($connect, $_GET['type']);
  $carts = mysqli_real_escape_string($connect, $_GET['carts']);
  $seats = mysqli_real_escape_string($connect, $_GET['seats']);

  if(isset($_SESSION['role'])){
    if ($_SESSION['role'] == "Admin"){
      $sql = "INSERT INTO train(cartNum, seatNum, train_type) VALUES ('$carts', '$seats', '$type');";
      if(mysqli_query($connect, $sql)){
        header('Location: ../index.php?train-create=success');
      }
      die(mysqli_error($connect));
    }
  // User not logged in or user is not an admin
  } else {
    header("Location: ../login.php");
  }
