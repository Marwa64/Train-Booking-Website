<?php
  include_once('includes/sqlConnection.php');
  $tripID = mysqli_real_escape_string($connect, $_GET['trip']);
  $sql = "SELECT * FROM trip WHERE trip_ID = '$tripID'";
  $result = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($result);
 ?>
<html>
  <head>
    <link rel="stylesheet" href="indexStyle.css">
    <link rel="stylesheet" href="loginStyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Booking | Edit Trip</title>
    <script>
      function validateForm(){
        var message = document.getElementById("errorMessage");
        var to = document.getElementById("to");
        var from = document.getElementById("from");
        var date = document.getElementById("date");
        var time = document.getElementById("time");
        var train = document.getElementById("train");
        var cost = document.getElementById("cost");
        if(from.value == ""){
          message.innerHTML = "This field is empty!";
          from.focus();
          return false;
        }
        if(to.value == ""){
          message.innerHTML = "This field is empty!";
          to.focus();
          return false;
        }
        if(date.value == ""){
          message.innerHTML = "Fill in the date of departure";
          date.focus();
          return false;
        }
        if(time.value == ""){
          message.innerHTML = "Fill in the time of departure";
          time.focus();
          return false;
        }
        if(cost.value == ""){
          message.innerHTML = "Fill in the cost per seat";
          cost.focus();
          return false;
        }
        if(train.value == "default"){
          message.innerHTML = "Fill in the train number";
          train.focus();
          return false;
        }
          message.innerHTML = "";
          location.href="includes/updateTrip.php?id="+<?php echo $tripID?> +"&to="+to.value+"&from="+from.value+"&date="+date.value+"&time="+time.value+"&train="+train.value+"&cost="+cost.value;
      }
    </script>
  </head>
  <body>
    <?php include('header.php') ?>
    <div class="mainBlock">
      <h3> Edit Trip </h3>
      <form method="post" action="JavaScript:validateForm()">
        <div class="grid">
           <label>From</label>
           <input type='text' id='from' name='from' class='textField' <?php echo "value='$row[trip_from]'"; ?> />
           <label>To</label>
           <input type='text' id='to' name='to' class='textField' <?php echo "value='$row[trip_to]'"; ?>/>
           <label>Departure date</label>
           <input type='date' id='date' name='date' class='textField' <?php echo "value='$row[trip_date]'"; ?>/>
           <label>Departure time</label>
           <input type='time' id='time' name='time' class='textField'<?php echo "value='$row[trip_time]'"; ?> />
           <label>Cost per seat</label>
           <input type='number' id='cost' name='cost' class='textField' <?php echo "value='$row[seatCost]'"; ?>/>
           <label>Train Number</label>
           <select id="train" name="train" class="textField">
             <option value="default"> None </option>
             <?php
              // Puts all the available train numbers as options
              $sql = "SELECT train_ID FROM train;";
              $result = mysqli_query($connect, $sql);
              if (mysqli_num_rows($result) > 0){
                while($row2 = mysqli_fetch_assoc($result)){
                  if ($row['train_ID'] === $row2['train_ID']){
                    echo "<option value='$row2[train_ID]' selected> $row2[train_ID] </option>";
                  } else {
                    echo "<option value='$row2[train_ID]'> $row2[train_ID] </option>";
                  }
                }
              }
              ?>
           </select>
         </div>
        <br/>
        <div>
          <input type="submit" value="Submit" class="submit"/>
          <button type="button" class="submit" onclick="location.href='includes/deleteTrip.php?id='+<?php echo $tripID?>">Delete</button>
        </div>
        <div class="errorMessage" id="errorMessage"></div>
      </form>
    </div>
  </body>
</html>
