<?php
  error_reporting(0);
  session_start();
  include_once('includes/sqlConnection.php');
   $sql="SELECT * FROM user_data WHERE user_ID = '$_SESSION[userID]';";
   $result = mysqli_query($connect, $sql);
   $row = mysqli_fetch_assoc($result);
 ?>

  <div class="deposit" id="deposit">
     <form action="JavaScript:deposit()" method="post">
       <span> <b> Amount: </b> </span>
       <input type="number" id="amount" class="textField"/>
       <input type="submit" class="adminBtn" value="Deposit"/>
       <input type="button" class="adminBtn" onclick="closeBalance()" value="Close"/> <br/>
       <span class="message" id="successMessage"></span>
     </form>
  </div>

  <h3> Profile </h3>
  <div class="btnContainer"> <button onclick="location.href='editInfo.php'" class="adminBtn"> Edit Info </button> <br/> </div>
  <table class="userInfo">
    <tr>
      <td class="userLabel">User Name:</td>
      <td><?php echo " $row[user_name]";?></td>
      <td></td>
    </tr>
    <tr>
      <td class="userLabel">E-mail:</td>
      <td> <?php echo " $row[user_email]";?></td>
      <td></td>
    </tr>
    <?php
    // if the user is a customer
      if ($row['role'] == "Customer"){
        echo "
          <tr>
            <td class='userLabel'>Balance:</td>
            <td>$$row[balance]</td>
            <td><button class='adminBtn' onclick='openBalance()'>Deposit</button></td>
          </tr>
          <tr>
            <td></td>
          </tr>
          <tr>
            <td class='userLabel'>Booked Trips:</td>
          </tr>
        ";
        $bookedTrips = "SELECT * FROM booked_trip WHERE user_ID='$_SESSION[userID]';";
        $result2 = mysqli_query($connect, $bookedTrips);
        if (mysqli_num_rows($result2) > 0 ){
          $num = 1;
          while ($trip = mysqli_fetch_assoc($result2)){
            echo "
              <tr>
                <td></td>
                <td><button class='adminBtn' onclick=\"ticket($trip[trip_ID], 'true')\"> Ticket $num </button></td>
                <td></td>
              </tr>
            ";
            $num = $num + 1;
          }
        } else {
          echo "
            <tr>
              <td></td>
              <td> No trips booked</td>
              <td></td>
            </tr>
          ";
        }
      // If the user is an admin
      } else {
        echo "
          <tr>
            <td></td>
          </tr>
          <tr>
            <td class='userLabel'>All Users:</td>
          </tr>
        ";
        $users = "SELECT * FROM user_data;";
        $result3 = mysqli_query($connect, $users);
        if (mysqli_num_rows($result3) > 0 ){
          while ($user = mysqli_fetch_assoc($result3)){
            echo "
              <tr>
                <td></td>
                <td>$user[user_name]</td>
            ";
            if ($user['role'] == "Admin"){
              if (!$user['user_ID'] == $_SESSION['userID']){
                echo "<td id='$user[user_ID]'><button onclick='customer($user[user_ID])' class='adminBtn'> Remove Admin </button></td>
                  </tr>";
              }
            } else {
              echo "<td id='$user[user_ID]'><button onclick='admin($user[user_ID])' class='adminBtn'> Make Admin </button></td>
                </tr>";
            }
          }
        }
      }
     ?>
  </table>
 <button class='logBtn' onclick="location.href='includes/logout.php'"=> Log Out </button>
