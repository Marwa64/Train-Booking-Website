<?php
  include_once('includes/sqlConnection.php'); // Gets the file which has all the details to connect to our database
  session_start(); // Starts a session
  ?>
<html>
  <head>
    <link rel="stylesheet" href="indexStyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Booking | Home</title>
    <script>
    // This function takes the values the user entered in the search form, sends those values to the searchTrip file to
    // search for those values in our database. Then retrieves it and prints the results out using ajax.
      function search() {
        var from = document.getElementById("from");
        var to = document.getElementById("to");
        var seats = document.getElementById("seats");
        var date = document.getElementById("date");
        var url = 'includes/searchTrip.php';
        var parameters ='from='+from.value+'&to='+to.value+'&seats='+seats.value+'&date='+date.value;
        if (seats.value < "0" && seats.value != ""){
          document.getElementById("trips").innerHTML = "<h2>No trips available</h2>";
        } else {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("trips").innerHTML = this.responseText;
            }
          };
          xhttp.open("GET", url+ "?" + parameters, true);
          xhttp.send();
        }
      }
      // This function takes the trip ID and a variable that contains true if this trip has been booked by the current customer
      // and false if it hasn't been or if the customer isn't logged in. It then sends these parameters to the ticketContent file
      // which contains all the ticket details and prints them user ajax.
      function ticket(tripID, booked) {
        var url = 'ticketContent.php';
        var parameters ='trip='+tripID+'&booked='+booked;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var ticket = document.getElementById("ticket");
            var content = document.getElementById("ticketContent");
            ticket.style.width = "100%";
            content.innerHTML = this.responseText;
            content.style.visibility = "visible";
          }
        };
        xhttp.open("GET", url+ "?" + parameters, true);
        xhttp.send();
      }
      // This function closes the ticket window
      function closeTicket(){
        var ticket = document.getElementById("ticket");
        var content = document.getElementById("ticketContent");
        ticket.style.width = "0";
        content.style.visibility = "hidden";
      }
      // This function takes the trip ID as a parameter, and sends that ID to the cancelationEmail file which will send
      // an email to confirm that the customer wants to cancel the booking. Once the email is sent it prints the success
      // message in the cancelationEmail file onto the button using ajax.
      function cancel(trip){
        var url = 'includes/cancelationEmail.php';
        var parameters ='id='+trip;
        document.getElementById(trip).innerHTML = "Wait for a few seconds";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(trip).innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", url+ "?" + parameters, true);
        xhttp.send();
      }
      // This function takes the the trip ID and the cost (which is the cost of one seat * the number of seats booked)
      // and sends those parameters to the confirmationEmail file which will send an email to confirm that the user wants
      // to book the trip. Once the email is sent it prints the success message in the cancelationEmail file onto the button using ajax.
      function book(trip, cost){
        var url = 'includes/confirmationEmail.php';
        var parameters ='id='+trip+'&cost='+cost;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(trip).innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", url+ "?" + parameters, true);
        xhttp.send();
      }
      // This function takes the trip ID, cost (which is the cost of one seat * the number of seats booked), and the id
      // of the input tags that contains the number of seats the customer wants to book. (This input tag is in the ticketContent file)
      function checkBalance(trip,cost, seatID){
        var numOfSeats =  document.getElementById(seatID).value;
        // Checks if the number of seats wasn't enetered or if the customer entered 0 or a -ve number.
        if (numOfSeats == "" || numOfSeats <= 0){
          document.getElementById("bookMessage").innerHTML = "Enter a valid number of seats.";
        } else {
          <?php
          // If user is logged in
            if (isset($_SESSION['userID'])){
              // Gets the user's current balance from the database
              $sqlBalance = "SELECT balance FROM user_data WHERE user_ID='$_SESSION[userID]';";
              $balanceResult = mysqli_query($connect, $sqlBalance);
              $balance = mysqli_fetch_assoc($balanceResult);
              $amount = $balance['balance'];
            } else {
              // if the user isn't logged in we just set the amount as 0 as default
              $amount = 0;
            }
           ?>
           cost = cost * numOfSeats; // We multiply the cost of one seat * the number of seats th user wants to book
           var balance = <?php echo "$amount";?>; // We put the user's balance into a variable called balance
           // Checks if the user's current balance is greater than or equal to the cost
           if (balance >= cost){
             // If it is we'll print wait on the button using ajax then call the book function
             document.getElementById(trip).innerHTML = "Please wait for a few seconds";
             book(trip, cost);
            // If the user doesn't have enough money in his balance
           } else {
             document.getElementById("bookMessage").innerHTML = "Insufficient amount of money.";
           }
        }
      }
    </script>
  </head>
  <body>
    <?php include('header.php'); // This gets the code from the header file?>
    <div class="title">
      <h1> Train Booking </h1>
      <h2> Best train booking site </h2>
    </div>
     <div class="ticket" id="ticket">
       <a class="closebtn2" onclick="closeTicket()">&times;</a>
       <div class="ticketContent" id="ticketContent">

       </div>
     </div>

    <div class="mainBlock" id="tripsBlock">
      <?php
      // Sets role as false if the user is not logged in and true if he is
      if (isset($_SESSION['role'])){
        $role = 'true';
      } else {
        $role = 'false';
      }
      // This means the user is an admin so we show 2 new buttons only available for the admin
      if ($role == 'true' && $_SESSION['role'] == "Admin"){ ?>
        <div class="btnContainer">
          <button class="adminBtn" onclick="location.href='newTrain.php'"> Add Train </button>
          <button class="adminBtn" onclick="location.href='newTrip.php'"> Add Trip </button> <br/>
      </div>
<?php } ?>
      <form id="searchForm" action="JavaScript:search()" method="post">
        <b>From</b> <input type="textField" id="from"/>
        <b>To</b> <input type="textField" id="to"/>
        <b>Seats</b> <input type="number" id="seats"/>
        <b>Date</b> <input type="date" id="date"/>
        <input type="submit" value="Search"/>
      </form>
      <h4>Available trips: </h4>
      <table width='100%' id="trips">
        <?php
        // Gets all the trips from the database and prints them out
          $sql = "SELECT * FROM trip;";
          $result = mysqli_query($connect, $sql);
          if (mysqli_num_rows($result) > 0 ){
            while ($row = mysqli_fetch_assoc($result)){
              // Checks if the user is logged in
              if (isset($_SESSION['userID'])){
                // Checks if this trip has been booked by this user before
                $sqlCheckBooking = "SELECT * FROM booked_trip WHERE user_ID = '$_SESSION[userID]' AND trip_ID = '$row[trip_ID]';";
                $bookingResult = mysqli_query($connect, $sqlCheckBooking);
                if (mysqli_num_rows($bookingResult) > 0){
                  $booked = 'true';
                } else {
                  $booked = 'false';
                }
              } else {
                $booked = 'false';
              }
              echo "
                    <tr>
                      <td class='trip' onclick=\"ticket($row[trip_ID], '$booked')\">
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
            echo "<h2>No trip available</h2>";
          }
        ?>
      </table>
    </div>
  </body>
</html>
