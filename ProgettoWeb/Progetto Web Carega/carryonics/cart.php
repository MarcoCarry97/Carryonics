<!-- Modal -->
<?php
if(isset($remove))
{
  $cart=$_SESSION["cart"];
  //print_r($cart);
  unset($cart[$del]);
  $_SESSION["cart"]=$cart;
}
 ?>
<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cartModalLabel">Cart</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
        <form class="form-group" method="post">


            <!--codice per gestire il carrello-->
            <?php
              if(isset($_SESSION))
              {
                $link=mysqli_connect("localhost","root","","carryonics");
                /*if(!isset($_SESSION["cart"]))
                {
                  //echo "\n\n\n\n\n\n\n\n\n\n ok" ;
                  $_SESSION["cart"]=array();
                }*/
                $cart=$_SESSION['cart'];
                $tot=0;
                //print_r($cart);
                if(count($cart)==0)
                {
                  echo "<div class='row col-12' style='margin:10px'>";
                  echo "<p class='text-center'>Your cart is empty!</p>";
                  echo "</div>";
                }
                else foreach($cart as $piece=>$amount)
                {
                  //echo "ok";
                  $query="select * from products where id=$piece";
                  $result=mysqli_query($link,$query);
                  if($result)
                  {
                    //echo "yeah";
                    $array=mysqli_fetch_array($result);
                    $id=$array["id"];
                    $name=$array['NAME'];
                    //$photo=$array['photo'];
                    $price=$array['price'];
                    $tot+=$price*$amount;
                    echo "<div class='row' style='margin:10px'>";
                    echo "<div class='col-4'>";
                    echo "<p class='text-center'>$name</p>";
                    echo "</div>";
                    echo "<div class='col-3'>";
                    echo "<p class='text-center'>Amount: $amount</p>";
                    echo "</div>";
                    echo "<div class='col-3'>";
                    echo "<p class='text-center'>$price €</p>";
                    echo "</div>";
                    echo "<input type='hidden' name='del' value='$id'>";
                    echo "<button class='col-2 btn btn-danger' name='remove'>X</button>";

                    echo "</div>";
                  }
                }
                echo "</form>";
                if(count($cart)!=0)
                {
                  echo "<form class='form-group row' style='margin:10px' method='get' action='pay.php'>";
                  echo "<div class='col-10'>";
                  echo "<p class='text-center'>Subtotal: $tot €</p>";
                  echo "</div>";
                  echo "<input type='hidden' value='$tot' name='subtot'>";
                  echo "<button class='btn btn-primary col-2' type='submit' name='pay'>";
                  echo "Pay";
                  echo "</button>";
                  echo "</form>";
                }
              }
            ?>

        </form>
    </div>
</div>
</div>
<!--fine-modal-->
