<?php
  session_start();
  require_once("PHPMailer/PHPMailerAutoLoad.php");
  include_once('sqlConnection.php');

  $trip = mysqli_real_escape_string($connect, $_GET['id']);
  $cost = mysqli_real_escape_string($connect, $_GET['cost']);

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
  $mail->SetFrom("no-reply@TrainBooking.com", "Train Booking");
  $mail->Subject = "Train Booking - Trip Confirmation";
  $mail->Body = "Click <a href='http://".$_SERVER['HTTP_HOST']."/WT%20Final%20Project/includes/bookTrip.php?user=$_SESSION[userID]&trip=$trip&cost=$cost'> this </a> to confirm the booking for your trip";
  $mail->AddAddress($_SESSION['email']);

  if ($mail->send()){
    echo"Confirmation Email Sent";
  }
