<script>
// This displays the content of the profile file into the tag
function profile() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("content").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "profile.php", true);
    xhttp.send();
  }
  // This function opens the menu tag and calls the profile function
  function displayMenu(){
    var menu = document.getElementById("menu");
    var content = document.getElementById("content");
    menu.style.width = "100%";
    profile();
  }
  // This function closes the menu tag
  function closeMenu(){
    var menu = document.getElementById("menu");
    menu.style.width = "0";
  }
  // This function sends the amount entered by the user in the input tag (which is in the profile file) to the
  // deposit file and prints the message from that file using ajax.
  function deposit() {
    var amount = document.getElementById("amount");
    var url = 'includes/deposit.php';
    var parameters ='amount='+amount.value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("successMessage").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET",  url+ "?" + parameters, true);
    xhttp.send();
  }
  // This function opens the small balance window
  function openBalance(){
    var deposit = document.getElementById("deposit");
    deposit.style.visibility = "visible";
    document.getElementById("successMessage").innerHTML = "";
  }
  // This function closes the small balance window
  function closeBalance(){
    var deposit = document.getElementById("deposit");
    deposit.style.visibility = "hidden";
  }
  // This function takes the id of a user(customer) and sends it to the makeAdmin file the changes the text on the button
  // (which is in the profile file) using ajax depending on the message from the file.
  function admin(id){
    var url = 'includes/makeAdmin.php';
    var parameters ='id='+id;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(id).innerHTML = this.responseText;
      }
    };
    xhttp.open("GET",  url+ "?" + parameters, true);
    xhttp.send();
  }
  // This function takes the id of a user(admin) and sends it to the removeAdmin file the changes the text on the button
  // (which is in the profile file) using ajax depending on the message from the file.
  function customer(id){
    var url = 'includes/removeAdmin.php';
    var parameters ='id='+id;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(id).innerHTML = this.responseText;
      }
    };
    xhttp.open("GET",  url+ "?" + parameters, true);
    xhttp.send();
  }
</script>
<header>
  <table width="100%">
    <tr>
      <td width = "40%"><img src="logo.png" id="logo"/></td>
      <td><a href="index.php"> Home </a></td>
      <td><a href="viewTrains.php"> View Trains </a></td>
      <td><a href=""> About us </a></td>
      <td><a href=""> Contact us </a></td>
      <td>
        <?php
            if (isset($_SESSION['name'])){ ?>
              <a href="JavaScript:displayMenu()"> Profile </a>
      <?php } else { ?>
              <a href="login.php"> Log in </a>
      <?php }?>
      </td>
    </tr>
</table>
</header>
<div class="menu" id="menu">
  <a class="closebtn" onclick="closeMenu()">&#10150;</a>
  <div class="menuContent" id="content">
  </div>
</div>
