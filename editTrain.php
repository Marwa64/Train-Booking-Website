<?php
  include_once('includes/sqlConnection.php');
  $trainID = mysqli_real_escape_string($connect, $_GET['train']);
  $sql = "SELECT * FROM train WHERE train_ID = '$trainID'";
  $result = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($result);
 ?>
<html>
  <head>
    <link rel="stylesheet" href="indexStyle.css">
    <link rel="stylesheet" href="loginStyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Booking | Edit Train</title>
    <script>
    function deleteTrain(){
      var url = 'includes/deleteTrain.php';
      var parameters ='id='+<?php echo $trainID?>;
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if(this.responseText == "success"){
            location.href="viewTrains.php?trip-delete=success";
          } else {
            document.getElementById("errorMessage").innerHTML = this.responseText;
          }
        }
      };
      xhttp.open("GET", url+ "?" + parameters, true);
      xhttp.send();
    }
      function validateForm(){
        var message = document.getElementById("errorMessage");
        var type = document.getElementById("type");
        var carts = document.getElementById("carts");
        var seats = document.getElementById("seats");
        if(type.value == ""){
          message.innerHTML = "Fill in the type field";
          type.focus();
          return false;
        }
        if(carts.value == ""){
          message.innerHTML = "Fill in the number of carts";
          carts.focus();
          return false;
        }
        if(seats.value == ""){
          message.innerHTML = "Fill in the number of seats";
          seats.focus();
          return false;
        }
          message.innerHTML = "";
          location.href="includes/updateTrain.php?id="+<?php echo $trainID?> +"&type="+type.value+"&carts="+carts.value+"&seats="+seats.value;
      }
    </script>
  </head>
  <body>
    <?php include('header.php') ?>
    <div class="mainBlock">
      <h3> Edit Train </h3>
      <form method="post" action="JavaScript:validateForm()">
        <div class="grid">
           <label>Train Type</label>
           <input type='text' id='type' name='type' class='textField' <?php echo "value='$row[train_type]'"; ?>/>
           <label>Number of carts</label>
           <input type='number' id='carts' name='carts' class='textField' <?php echo "value='$row[cartNum]'"; ?>/>
           <label>Number of seats in each cart</label>
           <input type='number' id='seats' name='seats' class='textField' <?php echo "value='$row[seatNum]'"; ?>/>
        </div>
        <br/>
        <div>
          <input type="submit" value="Submit" class="submit"/>
          <button type="button" class="submit" onclick="deleteTrain()">Delete</button>
        </div>
        <div class="errorMessage" id="errorMessage"></div>
      </form>
    </div>
  </body>
</html>
