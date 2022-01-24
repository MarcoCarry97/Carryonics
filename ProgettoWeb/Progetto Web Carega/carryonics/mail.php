<?php

// Load Composer's autoloader
 /*require 'D:\Programmi\xampp\htdocs\carryonics\PHPMailer\src\PHPMailer.php';
 require 'D:\Programmi\xampp\htdocs\carryonics\PHPMailer\src\Exception.php';
 require 'D:\Programmi\xampp\htdocs\carryonics\PHPMailer\src\SMTP.php';*/

function sendMail($email,$header,$message)
{
  require 'D:\Programmi\xampp\htdocs\carryonics\PHPMailer\src\PHPMailer.php';
  require 'D:\Programmi\xampp\htdocs\carryonics\PHPMailer\src\Exception.php';
  require 'D:\Programmi\xampp\htdocs\carryonics\PHPMailer\src\SMTP.php';
  //require 'PHPMailer-master/PHPMailerAutoload.php';
  /*if(validate_email($email))
  {*/
    $mail=new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true; // Autenticazione SMTP
    $mail->Host = "posta.italcom.biz";
    $mail->Port = 465;
    $mail->SMTPSecure = 'tls';
    $mail->Username = "carryonics@italcomspa.biz";
    $mail->Password = "PierinaMicrosoft2019!";
    $mail->From     = "carryonics@italcomspa.biz";
    $mail->FromName = "E-mail di prova - server custom";
    $mail->AddAddress($email);
    $mail->IsHTML(true);
    $mail->Subject  =  $header;
    $mail->Body     =  $message;
    if(!$mail->Send())
    {
               echo "errore nell'invio della mail: ".$mail->ErrorInfo;
               return false;
       }
       else
       {
               return true;
       }
  /* }
   else
   {
       echo "La mail non è stata inviata a causa dell'indirizzo errato o un problema di connessione!";
   }*/
  }
?>
