<?php
  session_start();
  include_once('includes/sqlConnection.php');
  $sql = "SELECT * FROM user_data WHERE user_ID = '$_SESSION[userID]'";
  $result = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($result);
 ?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginStyle.css">
    <title>Train Booking | Edit Info</title>
    <script>
      function update(name,email,password) {
        var url = 'includes/updateInfo.php';
        var parameters ='name='+name+'&email='+email+'&password='+password;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText === "success"){
              location.href="index.php";
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
        var name = document.getElementById("name");
        var email = document.getElementById("email");
        var password = document.getElementById("pw");
        var password2 = document.getElementById("pw2");
        if(name.value == ""){
          message.innerHTML = "Fill in the username field";
          name.focus();
          return false;
        }
        if(email.value == ""){
          message.innerHTML = "Fill in the email field";
          email.focus();
          return false;
        }
        if(!email.value.includes(".com")){
          message.innerHTML = "Invalid email";
          email.focus();
          return false;
        }
        if(password.value == ""){
          message.innerHTML = "Fill in the password field";
          password.focus();
          return false;
        }
        if(password.value != password2.value){
          message.innerHTML = "The confirm password field in incorrect";
          password2.focus();
          return false;
        }
          message.innerHTML = "";
          update(name.value, email.value,password.value);
      }
    </script>
  </head>
  <body>
    <div class="mainBlock">
      <h3> Edit Info </h3>
      <form action="JavaScript:validateForm()" method="POST" >
        <div class="grid">
           <label>Username</label>
           <input type='text' id='name' name='name' class='textField' <?php echo "value='$row[user_name]'"; ?>/>
           <label>Email</label>
           <input type='email' id='email' name='email' class='textField' <?php echo "value='$row[user_email]'"; ?> />
           <label>Password</label>
           <input type='text' id='pw' name='password' class='textField' pattern='(?=.*\d).{6,}' title='Password must be at least 6 characters and contains at least 1 number.' <?php echo "value='$row[user_password]'"; ?>/>
           <label id="confirmPas">Confirm Password</label>
           <input type='text' id='pw2' name='password2' class='textField'/>
         </div>
        <br/> <input type="submit" value="Confirm" class="submit"/>
        <div class="errorMessage" id="errorMessage"></div>
      </form>
  </body>
</html>
