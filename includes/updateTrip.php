<?php
  session_start();
  include_once ('sqlConnection.php');

  $id = mysqli_real_escape_string($connect, $_GET['id']);
  $to = mysqli_real_escape_string($connect, $_GET['to']);
  $from = mysqli_real_escape_string($connect, $_GET['from']);
  $date = mysqli_real_escape_string($connect, $_GET['date']);
  $time = mysqli_real_escape_string($connect, $_GET['time']);
  $train = mysqli_real_escape_string($connect, $_GET['train']);
  $cost = mysqli_real_escape_string($connect, $_GET['cost']);

  // Deletes all the previously booked trips for this trip
  $sqlDelete = "DELETE FROM booked_trip WHERE trip_ID = '$id';";
  $deleteResult = mysqli_query($connect, $sqlDelete);
  // Calculates the number of seats for this trip depending on the train chosen
  $sqlSeats = "SELECT seatNum, cartNum FROM train WHERE train_ID = '$train';";
  $seatResult = mysqli_query($connect, $sqlSeats);
  $row = mysqli_fetch_assoc($seatResult);
  $numOfSeats = $row['cartNum'] * $row['seatNum'];
  // Updates the trip details
  $sql = "UPDATE trip SET trip_to='$to', trip_from='$from', trip_date='$date', trip_time='$time', seatCost='$cost', trip_seats='$numOfSeats', train_ID='$train' WHERE trip_ID='$id';";
  if(mysqli_query($connect, $sql)){
    header('Location: ../index.php?trip-update=success');
  }
