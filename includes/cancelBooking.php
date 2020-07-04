<?php

  include_once('sqlConnection.php');
  $user = mysqli_real_escape_string($connect, $_GET['user']);
  $trip = mysqli_real_escape_string($connect, $_GET['trip']);
  $cost = mysqli_real_escape_string($connect, $_GET['cost']);

  $sql = "DELETE FROM booked_trip WHERE user_ID = $user AND trip_ID = $trip;";
  if (mysqli_query($connect, $sql)){
    // Refund the amount the customer paid for the trip
    $sqlBalance = "UPDATE user_data SET balance=balance+'$cost' WHERE user_ID='$user';";
    $result = mysqli_query($connect, $sqlBalance);

    // Get the cost of one seat in this trip
    $sqltripCost = "SELECT seatCost FROM trip WHERE trip_ID = '$trip';";
    $tripCostResult = mysqli_query($connect, $sqltripCost);
    $tripCost = mysqli_fetch_assoc($tripCostResult);

    // Calculate number of seats booked
    $numOfSeats = $cost / $tripCost['seatCost'];

    // Add the number of seats from the seats available for this trip
    $sqlSeats = "UPDATE trip SET trip_seats = trip_seats+'$numOfSeats' WHERE trip_ID='$trip';";
    mysqli_query($connect, $sqlSeats);
    header("Location: ../index.php?booking=cancelled");
  }
