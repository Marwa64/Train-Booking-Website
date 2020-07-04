<?php
  session_start();
  include_once ('sqlConnection.php');

  $to = mysqli_real_escape_string($connect, $_GET['to']);
  $from = mysqli_real_escape_string($connect, $_GET['from']);
  $date = mysqli_real_escape_string($connect, $_GET['date']);
  $time = mysqli_real_escape_string($connect, $_GET['time']);
  $train = mysqli_real_escape_string($connect, $_GET['train']);
  $cost = mysqli_real_escape_string($connect, $_GET['cost']);

  // Checks if the user is logged in and if the user in an admin
  if(isset($_SESSION['role'])){
    if ($_SESSION['role'] == "Admin"){
        // Calculates the number of seats for this trip depending on the train chosen
      $sqlSeats = "SELECT seatNum, cartNum FROM train WHERE train_ID = '$train';";
      $seatResult = mysqli_query($connect, $sqlSeats);
      $row = mysqli_fetch_assoc($seatResult);
      $numOfSeats = $row['cartNum'] * $row['seatNum'];
      // Adds the trip to the database
      $sql = "INSERT INTO trip(trip_from, trip_to, trip_date, trip_time, train_ID, seatCost, trip_seats) VALUES ('$from', '$to', '$date', '$time', '$train', '$cost','$numOfSeats');";
      if(mysqli_query($connect, $sql)){
        header('Location: ../index.php?trip-create=success');
      }
      die(mysqli_error($connect));
    }
  // User not logged in or user is not an admin
  } else {
    header("Location: ../login.php");
  }
