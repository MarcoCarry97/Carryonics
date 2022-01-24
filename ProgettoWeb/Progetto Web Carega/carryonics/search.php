<?php include "top.php"; ?>
<?php include "cart.php"; ?>


<div class="container-fluid" style="margin-top:100px">
  <form class="row" method="get">
  <div class="col-sm-6">
    <h4 class="text-center">
    <?php
      extract($_GET);
      echo "Result for $search:"
     ?>
    </h4>
  </div>
  <div class="col-sm-3">
    <?php
      foreach ($_GET as $key => $value)
      {
        echo "<input type='hidden' name='$key' value='$value'>";
      }
     ?>
     <select name="order" id="order" class="custom-select">
       <option value="price desc" selected>Lower price</option>
       <option value="price asc">Upper price</option>
       <option value="name desc">Lower name</option>
       <option value="name asc">Upper name</option>
     </select>

  </div>
     <button type="submit" class="btn btn-warning col-sm-3">Go</button>
</form>
    <?php
      extract($_POST);
      $link=mysqli_connect("localhost","root","","carryonics");
      $query="select * from products ";
      switch($search)
      {
        case 'books': $query=$query."where category='$search' "; break;
        case 'comics': $query=$query." join books on products.id=books.product where category='books' and comic=true "; break;
        case 'films': $query=$query."where category='$search' "; break;
        case 'cds': $query=$query."where category='$search' "; break;
        case 'vinils': $query=$query."where category='$search' "; break;
        case 'games': $query=$query."where category='$search' "; break;
        default: $query=$query."where name like '%$search%' ";
      }
      //echo $order;
      if(isset($order)) $query=$query."order by ".$order;
      else $query=$query."order by price desc";
      //echo $query;
      $result=mysqli_query($link,$query);
      if(!$result)
      {
        echo "there are no products named $search!";
        exit();
      }
        $check=false;
        $count=0;
        echo "<div class='row'>";
        for(;$array=mysqli_fetch_array($result);)
        {
          //$array=mysqli_fetch_array($result);
          if(!$array) break;
          $check=true;
          //print_r($array);

            $id=$array["id"];
            $name=sprintf("%8.20s",$array["NAME"])."...";
            $image=$array["photo"];
            $cat=$array["category"];
            $price=$array["price"];
            $amount=$array["amount"];
            //echo "ok";
            $desc=sprintf("%8.77s",$array["description"])."...";


                echo "<form class='col-md-3' method='get' action='product.php'>";
                  echo "<div class='card' style='width: 18rem'>";
                    echo "<img class='card-img-top' src='$image' alt='$image'/>";
                    echo "<div class='card-body'>";
                      echo "<h5 class='card-title'>$name</h5>";
                      if($amount==0) echo "<p class='card-text text-danger'>Not available!</p>";
                      else if($amount<=5) echo "<p class='card-text text-danger'>Only $amount available!</p>";
                      echo "<p class='card-text'>$desc</p>";
                      echo "<div class='container row'>";
                      echo "<button type='submit' class='btn btn-primary col-6'>Show</button>";
                      echo "<p class='col-6'>$price €</p>";
                      echo "</div>";
                    echo "</div>";
                    echo "<input type='hidden' value='$id' name='product'>";
                    echo "<input type='hidden' value='$cat' name='category'>";
                    echo "</div>";

                echo "</form>";
                $count++;
                if($count==4)
                {
                  $count=0;
                  echo "</div>";
                  echo "<div class='row'>";
                }

      }
      echo "</div>";
      if($check==false) echo("There aren't products named $search");
     ?>
</div>





<?php include "bottom.html"; ?>
