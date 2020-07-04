<?php
  session_start();
  include_once('includes/sqlConnection.php');

  $trip = mysqli_real_escape_string($connect, $_GET['trip']);
  $booked = mysqli_real_escape_string($connect, $_GET['booked']);

  $sql = "SELECT * FROM trip WHERE trip_ID = '$trip';";
  $result = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($result);
  echo "<h3> Ticket </h3> <br/>";
  if ($booked == "true"){
    // Get the total cost of the trip
    $sqlCost = "SELECT cost FROM booked_trip WHERE user_ID = '$_SESSION[userID]' AND trip_ID = '$trip';";
    $costResult = mysqli_query($connect, $sqlCost);
    $seatCost = mysqli_fetch_assoc($costResult);

    // Get the cost of one seat in this trip
    $sqltripCost = "SELECT seatCost FROM trip WHERE trip_ID = '$trip';";
    $tripCostResult = mysqli_query($connect, $sqltripCost);
    $tripCost = mysqli_fetch_assoc($tripCostResult);

    // Calculate number of seats booked
    $numOfSeats = $seatCost['cost'] / $tripCost['seatCost'];

    echo "
      <span> <b> Ticket Owner: </b> $_SESSION[name] <br/> </span>
      <span> <b> Number of Seats: </b> $numOfSeats <br/> </span>
    ";
  }
  echo "
    <span> <b>From:</b> $row[trip_from] </span>
    <span> <b>To:</b> $row[trip_to] <br/> </span>
    <span> <b>Departure Date:</b> $row[trip_date] </span>
    <span> <b>Departure Time:</b> $row[trip_time] </span>
    <span> <b> Seat Price: </b> $$row[seatCost] </span>
    <span> <b> Train Number: </b> $row[train_ID] </span>
  ";
  // If use is logged in
  if (isset($_SESSION['role'])){
    // If use is admin
    if ($_SESSION['role'] == "Admin"){
      echo "<br/><button class='ticketBtn' onclick=\"location.href='editTrip.php?trip='+$trip\">Edit</button>";
    // If user is a customer
    } else {
      if ($booked == "true"){
        echo "<br/><button id='$trip' class='ticketBtn' onclick='cancel($trip)'>Cancel</button>";
      } else {
        $seatsID = $trip."seat";
        echo "
          <span> <b> Number of Seats: </b> <input type='number' id='$seatsID' name='$seatsID'> </span>
          <span class='message' id='bookMessage'></span><br/>
          <button id='$trip' class='ticketBtn' onclick=\"checkBalance($trip,$row[seatCost],'$seatsID')\">Book</button>";
      }
    }
    // If user is no logged in
  } else {
    echo "<br/><button class='ticketBtn' onclick=\"location.href='login.php'\">Book</button>";
  }
