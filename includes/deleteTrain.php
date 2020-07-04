<?php
  include_once ('sqlConnection.php');

  $id = mysqli_real_escape_string($connect, $_GET['id']);

  $sql="SELECT * FROM trip WHERE train_ID='$id';";
  $result = mysqli_query($connect, $sql);
  if(mysqli_num_rows($result) > 0){
    echo "This train has trips so it can't be deleted.";
  } else {
    $delete = "DELETE FROM train WHERE train_ID='$id';";
    mysqli_query($connect, $delete);
    echo"success";
  }
