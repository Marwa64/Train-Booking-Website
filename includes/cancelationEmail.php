<?php
  session_start();
  require_once ("PHPMailer/PHPMailerAutoLoad.php");
  include_once ('sqlConnection.php');

  $trip = mysqli_real_escape_string($connect, $_GET['id']);
  $sqlCost = "SELECT cost FROM booked_trip WHERE user_ID = '$_SESSION[userID]' AND trip_ID = '$trip';";
  $costResult = mysqli_query($connect, $sqlCost);
  $seatCost = mysqli_fetch_assoc($costResult);
  $cost = $seatCost['cost'];

  $mail = new PHPMailer();
  $mail->isSMTP();
  /*$mail->SMTPDebug = 1;*/
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'tsl';
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 587;
  $mail->isHTML(true);
  $mail->Username = "email.validation65@gmail.com";
  $mail->Password = "marwaomar2001";
  $mail->SetFrom("no-reply@forum.com", "Train Booking");
  $mail->Subject = "Train Booking - Trip Cancelation";
  $mail->Body = "Click <a href='http://".$_SERVER['HTTP_HOST']."/WT%20Final%20Project/includes/cancelBooking.php?user=$_SESSION[userID]&trip=$trip&cost=$cost'> this </a> to cancel the booking for your trip";
  $mail->AddAddress($_SESSION['email']);

  if ($mail->send()){
    echo"Confirmation Email Sent";
  }
