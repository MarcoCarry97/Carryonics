<?php include "top.php";?>
<?php
  extract($_GET);
  {
    if(isset($remove))
    {
      $cart=$_SESSION["cart"];
      unset($cart[$remove]);
      $_SESSION["cart"]=$cart;
    }
  }
 ?>
<?php include "cart.php"; ?>


<div class="container" style="margin-top:100px">
  <div class="row">
      <table class="table text-center">
        <thead>
          <tr>
            <th>Product</th>
            <th>Num</th>
            <th>Price</th>
            <th>Delete</th>
          </tr>
        </thead>
        <!--effettuare calcolo tabella, prezzi e totale-->
          <?php
            extract($_GET);
            $link=mysqli_connect("localhost","root","","carryonics");
            $cart=$_SESSION["cart"];
            $tot=0;
            foreach($cart as $piece=>$amount)
            {
              $query="select * from products where id=$piece";
              $result=mysqli_query($link,$query);
              $array=mysqli_fetch_array($result);
              $name=$array["NAME"];
              $price=$array["price"];
              echo "<tr>";
                echo "<td>$name</td>";
                echo "<td>$amount</td>";
                echo "<td>$price</td>";
                echo "<form method='get'>";
                echo "<td><button name='remove' value='$piece' class='btn btn-danger'>X</button></td>";
                echo "</form>";
              echo "</tr>";
              $tot+=$amount*$price;
            }
            if($tot!=0)
            {
              echo "<tfoot>";
                echo "<tr>";
                  echo "<th colspan='3' id='total'>Total</th>";
                  echo "<th>$tot €</th>";
                echo "</tr>";
              echo "</tfoot>";
            }
            else
            {
              echo "<tfoot>";
                echo "<tr>";
                  echo "<th>There are no products here...</th>";
                echo "</tr>";
              echo "</tfoot>";
            }
           ?>

    </table>

</div>

</div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>Choose the delivery price:</h4>
    </div>
  </div>
  <form method='post' action='confirm.php'>
  <table class="text-center table">
    <thead>
      <tr>
        <th></th>
        <th> Type </th>
        <th> Courier </th>
        <th> Price </th>
        <th> Number of days </th>
      </tr>
    </thead>

      <?php
        $link=mysqli_connect("localhost","root","","carryonics");
        $query="select * from deliveries";
        $result=mysqli_query($link,$query);
        $first=false;
        for(;$array=mysqli_fetch_array($result);)
        {
          $name=$array["name"];
          $courier=$array["courier"];
          $money=$array["price"];
          $numday=$array["delivering"];
          $id=$array["id"];
          echo "<tr>";
            echo "<td><input type='radio' class='custom-radio' name='delivery' id='delivery' value='$id'".(!$first ? "checked" : "")."/></td>";
            echo "<td> $name </td>";
            echo "<td> $courier </td>";
            echo "<td> $money €</td>";
            echo "<td> $numday </td>";
          echo "</tr>";

          $first=true;
        }
        echo "</table>";
        //echo "<form method='post' action='confirm.php'>";
        $cart=$_SESSION["cart"];
        $tot=0;
        foreach($cart as $piece=>$amount)
        {
          $query="select price from products where id=$piece";
          $result=mysqli_query($link,$query);
          $array=mysqli_fetch_array($result);
          $price=$array['price'];
          $tot+=$price*$amount;
        }
        if(count($cart)!=0 && isset($_SESSION["login"]))
        {
          echo "<input type='hidden' value='$tot' name='total'>";
          echo "<div class='container'>";
          echo "<button class='row col-sm-4 btn btn-success' name='confirm'>Confirm and pay</button>";
          echo "</div>";
        }
        //echo "</div>";

        echo "</form>";
        //echo "</div>";
        echo "</div>";
      ?>





<?php include "bottom.html"; ?>
