<?php session_start()?>
<html>
  <head>
    <link rel="stylesheet" href="indexStyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Booking | Trains</title>
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="trainTitle">
      Our Trains
    </div>
    <div class="mainBlock">
      <table class="trainTable">
        <tr class="tableHeader">
          <td><b>Train Number</b></td>
          <td><b>Type</b></td>
          <td><b>Number of Carts</b></td>
          <td><b>Number of Seats/Cart</b></td>
          <?php
            if(isset($_SESSION['role'])){
              if ($_SESSION['role'] === "Admin"){ ?>
                <td><b>Edit Info</b></td>
       <?php }
            }
           ?>
         </tr>
        <?php
          include_once('includes/sqlConnection.php');
          $sql = "SELECT * FROM train;";
          $result = mysqli_query($connect, $sql);
          if (mysqli_num_rows($result) > 0 ){
            while ($row = mysqli_fetch_assoc($result)){
              echo "
                <tr>
                  <td>$row[train_ID]</td>
                  <td>$row[train_type]</td>
                  <td>$row[cartNum]</td>
                  <td>$row[seatNum]</td>
              ";
              if(isset($_SESSION['role'])){
                if ($_SESSION['role'] === "Admin"){
                  echo "<td><button class='adminBtn' onclick=\"location.href='editTrain.php?train='+$row[train_ID]\"> Edit </button></td>
                  </tr>
                  ";
                }
              }
            }
          }
         ?>
      </table>
    </div>
  </body>
</html>
