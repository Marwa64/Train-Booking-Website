<?php
  include_once('sqlConnection.php');
  $user = mysqli_real_escape_string($connect, $_GET['user']);
  $trip = mysqli_real_escape_string($connect, $_GET['trip']);
  $cost = mysqli_real_escape_string($connect, $_GET['cost']);

  $sql = "INSERT INTO booked_trip(user_ID, trip_ID, cost) VALUES('$user', '$trip', '$cost');";
  if (mysqli_query($connect, $sql)){
    // Deduct the trip cost from the balance
    $sqlBalance = "SELECT balance FROM user_data WHERE user_ID='$user';";
    $result = mysqli_query($connect, $sqlBalance);
    $oldBalance = mysqli_fetch_assoc($result);

    $newBalance = $oldBalance['balance'] - $cost;
    $sqlUpdateBalance="UPDATE user_data SET balance='$newBalance' WHERE user_ID='$user';";
    mysqli_query($connect, $sqlUpdateBalance);

    // Get the cost of one seat in this trip
    $sqltripCost = "SELECT seatCost FROM trip WHERE trip_ID = '$trip';";
    $tripCostResult = mysqli_query($connect, $sqltripCost);
    $tripCost = mysqli_fetch_assoc($tripCostResult);

    // Calculate number of seats booked
    $numOfSeats = $cost / $tripCost['seatCost'];

    // Deduct the number of seats from the seats available for this trip
    $sqlSeats = "UPDATE trip SET trip_seats = trip_seats-'$numOfSeats' WHERE trip_ID='$trip';";
    mysqli_query($connect, $sqlSeats);

    header("Location: ../index.php?booking=confirmed");
  }
