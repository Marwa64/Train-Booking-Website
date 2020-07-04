<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginStyle.css">
    <title>Log in</title>
    <script>
      function loadDoc(email,password) {
        var url = 'includes/validateUser.php';
        var parameters ='email='+email+'&password='+password;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == '<span id="successMessage"> Login successful! </span>'){
              location.href="index.php";
            }
            document.getElementById("errorMessage").innerHTML = this.responseText;
          }
        };
        xhttp.open("GET",  url+ "?" + parameters, true);
        xhttp.send();
      }
      function validateForm(){
        var message = document.getElementById("errorMessage");
        var email = document.getElementById("email");
        var password = document.getElementById("pw");
        if(email.value == ""){
          message.innerHTML = "Fill in the email field";
          email.focus();
          return false;
        }
        if(password.value == ""){
          message.innerHTML = "Fill in the password field";
          password.focus();
          return false;
        }
          message.innerHTML = "";
          setCookie("email", email.value);
          setCookie("password", password.value);
          loadDoc(email.value,password.value);
      }
      function setCookie(cookieName, cookieValue) {
        var d = new Date();
        d.setTime(d.getTime() + (7 * 24 * 60 * 60 * 1000)); // Expires in 7 days
        var expires = "expires="+d.toUTCString();
        document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
      }
      function getCookie(cookieName) {
        var name = cookieName + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }
      function checkCookie() {
        var email = getCookie("email");
        var password = getCookie("password");
        if (email != "") {
          document.getElementById("email").value = email;
          document.getElementById("pw").value = password;
        }
      }
      window.onload = function(){
        checkCookie();
      }
    </script>
  </head>
  <body>
    <div class="mainBlock" id="login">
      <h3>Log In</h3>
      <form method="post" action="JavaScript:validateForm()">
        <div class="grid">
           <label>Email</label>
             <input type="email" name="email" id="email" class="textField"/>
             <label>Password</label>
             <input type="password" name="password" id="pw" class="textField"/>
         </div>
        <br/>
        <table>
          <tr>
            <td>
              <input type="submit" value="Log in" class="submit"/>
            </td>
            <td>
              <button class="submit" type="button" onclick="location.href='signup.php'"> Sign up </button>
            </td>
          </tr>
        </table>
        <div class="errorMessage" id="errorMessage"></div>
      </form>
    </div>
  </body>
</html>
