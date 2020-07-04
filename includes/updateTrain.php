<?php
  session_start();
  include_once ('sqlConnection.php');

  $id = mysqli_real_escape_string($connect, $_GET['id']);
  $type = mysqli_real_escape_string($connect, $_GET['type']);
  $carts = mysqli_real_escape_string($connect, $_GET['carts']);
  $seats = mysqli_real_escape_string($connect, $_GET['seats']);

  $sql = "UPDATE train SET train_type='$type', cartNum='$carts', seatNum='$seats' WHERE train_ID='$id';";
  if(mysqli_query($connect, $sql)){
    header('Location: ../viewTrains.php?train-update=success');
  }
