<?php include "top.php"?>

<div class="container" style="margin-top:100px">
  <div class="row col-12 alert alert-primary">
    <?php
      extract($_POST);
      $link=mysqli_connect("localhost","root","","carryonics");
      $query="select * from deliveries where id=$delivery";
      $result=mysqli_query($link,$query);
      $array=mysqli_fetch_array($result);
      $days=$array["delivering"];
      $email=$_SESSION["user_email"];
      $date=date("Y/m/d");
      $parts=explode("/",$date);
      $parts[2]+=$days;
      $date=implode("/",$parts);
      $total+=$array["price"];
      $money=$total+$_SESSION["spent"];
      if($money>$_SESSION["max"])
      {
        echo "Overloaded limit of money!";
      }
      else
      {
        try
        {
          //echo $money;
          $_SESSION["spent"]=$money;
          mysqli_autocommit($link,FALSE);
          foreach($_SESSION["cart"] as $product=>$amount)
          {
            //echo " ".$product." ".$delivery." ".$email." ".$date."\n";
            $take="select amount from products where id=$product";
            $set=mysqli_query($link,$take);
            $array=mysqli_fetch_array($set);
            $resamount=$array["amount"]-$amount;
            //echo " $amount - $resamount ";
            if($resamount<0)
            {
              //echo "<div class='row alert alert-primary' role='alert'>";
              echo "Error, the required amount of is not available!";
              //echo "</div>";
              exit();
            }
            else
            {
              $to = $email;
              $subject ="Your order in Carryonics!";
              $body = "Yeah! your order priced $total will arrive in this day: $date".PHP_EOL;
              $body.= "Sent by mercury" . PHP_EOL;
              $headers ="From: carry@carryonics.net";
              if(mail($to,$subject,$body,$headers))
              {
                $query="insert into orders set site_user='$email',product=$product,delivery=$delivery, del_date='$date'";
                $update="update products set amount=$resamount where id=$product";
                mysqli_query($link,$update);
                mysqli_query($link,$query);
                echo "Yeah! your order priced $total will arrive in this day: $date";
              }


            }
          }
          mysqli_commit($link);
          $_SESSION["cart"]=array();
        //  echo "Yeah! Your products priced $total € arrive in this day: $date";
        }
        catch (\Exception $e)
        {
          echo $e;
          mysqli_rollback($link);
        }
      }

     ?>
  </div>
</div>

<?php include "cart.php"?>


<?php include "bottom.html"?>
