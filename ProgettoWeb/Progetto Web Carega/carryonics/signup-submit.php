<?php include "top.php"?>
<?php include "cart.php"?>

<div style="margin-top:100px"></div>

<?php

  //require("mail.php");
  extract($_POST);
  $link=mysqli_connect("localhost","root","","carryonics");
  mysqli_autocommit($link,FALSE);
  $result=mysqli_query($link,"select * from users where email='$email'");
  $array=mysqli_fetch_array($result);

  if(!$array)
  {
    try {
      $date=explode("/",$expdate);
      //print_r($date);
      $insert="insert into users set name='$name',surname='$surname',email='$email', pass='$pass', address='$address', civic='$street', postcode=$postcode, city='$city', credit_num='$credit', exp_date_month=$date[0], exp_date_year=$date[1],sec_code=$sec ";
      $result=mysqli_query($link,$insert);
      //ini_set("smtp_port","587");
      mysqli_commit($link);
      //sendMail($email,"Welcome to Carryonics!","Welcome to Carryonics!");

      $to = $email;
      $subject ="Welcome to Carryonics!";
      $body = "Yeah! You're in the best e-commerce website of the world! Enjoy it!".PHP_EOL;
      $body.= "Sent by mercury" . PHP_EOL;
      $headers ="From: carry@carryonics.net";
      if(mail($to,$subject,$body,$headers))
      {
        echo "<div class='container row alert-primary'>
        Yeah! You are in the system!
        </div>";
      }
      else "ERROR";

    } catch (\Exception $e) {
      mysqli_rollback($link);
      echo "<div class='container row alert-danger'>
      Error!;
      </div>";
    }


  }
  else {
    echo "<div class='container row alert-danger'>
      The inserted email is already used, please go back and digit another one!
    </div>";
  }
 ?>





<?php include "bottom.html"?>
