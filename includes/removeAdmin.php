<?php
  include_once ('sqlConnection.php');

  $id = mysqli_real_escape_string($connect, $_GET['id']);

  $sql = "UPDATE user_data SET role='Customer' WHERE user_ID='$id';";
  if(mysqli_query($connect, $sql)){
    echo "<button onclick='admin($id)' class='adminBtn'> Make Admin </button>";
  } else {
    die(mysqli_error($connect));
  }
