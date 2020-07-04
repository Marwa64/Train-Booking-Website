<html>
  <head>
    <link rel="stylesheet" href="indexStyle.css">
    <link rel="stylesheet" href="loginStyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Booking | New Train</title>
    <script>
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
        if(carts.value <= "0"){
          message.innerHTML = "Invalid number of carts";
          carts.focus();
          return false;
        }
        if(seats.value == ""){
          message.innerHTML = "Fill in the number of seats";
          seats.focus();
          return false;
        }
        if(seats.value <= "0"){
          message.innerHTML = "Invalid number of seats";
          seats.focus();
          return false;
        }
          message.innerHTML = "";
          location.href="includes/addTrain.php?type="+type.value+"&carts="+carts.value+"&seats="+seats.value;
      }
    </script>
  </head>
  <body>
    <?php include('header.php') ?>
    <div class="mainBlock">
      <h3> New Train </h3>
      <form method="post" action="JavaScript:validateForm()">
        <div class="grid">
           <label>Train Type</label>
           <input type='text' id='type' name='type' class='textField' />
           <label>Number of carts</label>
           <input type='number' id='carts' name='carts' class='textField' />
           <label>Number of seats in each cart</label>
           <input type='number' id='seats' name='seats' class='textField'/>
         </div>
        <br/> <input type="submit" value="Submit" class="submit"/>
        <div class="errorMessage" id="errorMessage"></div>
      </form>
    </div>
  </body>
</html>
