<?php
  include_once ('sqlConnection.php');

  $id = mysqli_real_escape_string($connect, $_GET['id']);

  $sql = "DELETE FROM trip WHERE trip_ID='$id';";
  if(mysqli_query($connect, $sql)){
    header('Location: ../index.php?trip-delete=success');
  }
