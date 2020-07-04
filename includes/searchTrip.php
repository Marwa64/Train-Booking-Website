<?php
// Prints out all the available trips based on the criteria searched
  include_once('sqlConnection.php');

  $from = mysqli_real_escape_string($connect, $_GET['from']);
  $to = mysqli_real_escape_string($connect, $_GET['to']);
  $date = mysqli_real_escape_string($connect, $_GET['date']);
  $seats = mysqli_real_escape_string($connect, $_GET['seats']);

  if ($from === ""){
    $from = "%";
  }
  if ($to === ""){
    $to = "%";
  }
  if ($date === ""){
    $date = "%";
  }
  if ($seats === ""){
    $seats = "0";
  }
  $sql = "SELECT * FROM trip WHERE trip_from LIKE '$from' AND trip_to LIKE '$to' AND trip_date LIKE '$date' AND trip_seats >= '$seats'";
  $result = mysqli_query($connect, $sql);
  if (mysqli_num_rows($result) > 0 ){
    while ($row = mysqli_fetch_assoc($result)){
      echo "
            <tr>
              <td class='trip'onclick=\"ticket($row[trip_ID], 'false')\">
                <span> <b>From:</b> $row[trip_from] </span>
                <span> <b>To:</b> $row[trip_to] <br/> </span>
                <span> <b>Departure Date:</b> $row[trip_date] </span>
                <span> <b>Departure Time:</b> $row[trip_time] </span>
                <span> <b>Cost per Seat:</b> $$row[seatCost] <br/> </span>
                <span> <b>Number of seats available:</b> $row[trip_seats] <br/> </span>
              </td>
            </tr>
          ";
    }
  } else {
    echo "<h2>No trips available</h2>";
  }
?>
