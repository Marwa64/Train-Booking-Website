<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginStyle.css">
    <title>Train Booking | Sign Up</title>
    <script>
      function loadDoc(name,email,password,role) {
        var url = 'includes/addAccount.php';
        var parameters ='name='+name+'&email='+email+'&password='+password+'&role='+role;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == '<span id="successMessage"> Account has been created successfully! </span>'){
              document.getElementById("errorMessage").innerHTML = this.responseText;
              location.href="login.php";
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
          loadDoc(name.value,email.value,password.value);
      }
    </script>
  </head>
  <body>
    <div class="mainBlock">
      <h3> Sign up </h3>
      <form action="JavaScript:validateForm()" method="POST" >
        <div class="grid">
           <label>Username</label>
           <input type='text' id='name' name='name' class='textField' />
           <label>Email</label>
           <input type='email' id='email' name='email' class='textField' />
           <label>Password</label>
           <input type='password' id='pw' name='password' class='textField' pattern='(?=.*\d).{6,}' title='Password must be at least 6 characters and contains at least 1 number.'/>
           <label id="confirmPas">Confirm Password</label>
           <input type='password' id='pw2' name='password2' class='textField' />
         </div>
        <br/> <input type="submit" value="Sign up" class="submit"/>
        <div class="errorMessage" id="errorMessage"></div>
      </form>
  </body>
</html>
