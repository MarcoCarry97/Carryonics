<?php include "top.php";?>
<?php include "cart.php"; ?>
<!--Slider-->
  <div style="margin-top:100px" id="carouselExampleIndicators" class="container-fluid carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php
      $link=mysqli_connect("localhost","root","","carryonics");
      $query="select count(distinct(category)) as num from products";
      $result=mysqli_query($link,$query);
      $array=mysqli_fetch_array($result);
      //$first=false;
      $num=$array["num"];
      for($i=0;$i<$num;$i++)
        echo "<li data-target='#carouselExampleIndicators' data-slide-to='$i'></li>";

     ?>
    <!--li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li-->
  </ol>
  <div class="carousel-inner">
    <?php
    $link=mysqli_connect("localhost","root","","carryonics");
    $query="select * from products where price in (select min(price) from products group by category) group by category";
    $result=mysqli_query($link,$query);
    $first=false;
    if(!$result)
    {
      echo "Error!";
      exit();
    }
    else for(;$array=mysqli_fetch_array($result);)
    {
      $id=$array['id'];
      $cat=$array['category'];
      $photo=$array['photo'];
      $dest="product.php?product=$id&category=$cat";
      //echo "<a href='$dest'>";
      echo "<a href='$dest' class='carousel-item ".(!$first ? "active" : "")."'>";

      echo "<img src='$photo' class='rounded mx-auto d-block w-20' style='width:250px' >";

      echo "</a>";
    //  echo "</a>";
      //echo($photo);
      $first=true;
    }
     ?>
    <!--div class="carousel-item active">
      <!--prendere immagini da db qui>
      <img src="image.jpg" class=" rounded mx-auto d-block w-20" alt="...">
    </div>

    <div class="carousel-item">
      <img src="image2.jpg" class=" rounded mx-auto d-block w-20" alt="...">
    </div-->
  </div>
  <a class="carousel-control-prev rounded bg-primary" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon " aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next rounded bg-primary" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon " aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<!--fine-slider-->


<!--?php
  extract($_POST);
  if(!$email)
  {
    session_start();
    //$_SESSION["email"]=$email;
    $_SESSION["user_email"]=$email;
    print($email);
  }
?-->


<!--cards-->
<!--i cinque prodotti col prezzo più basso-->
  <div class="container-fluid">
    <div class="row">
      <h5 class="text-left col-12"> Da non perdere:</h5>
    </div>

    <div class="row">
      <!--div class="carousel-inner"-->
        <?php
        $link=mysqli_connect("localhost","root","","carryonics");
        $query="select * from products where price in (select min(price) from products group by category) group by category";
        $result=mysqli_query($link,$query);
        $first=false;
        if(!$result)
        {
          echo "Error!";
          exit();
        }
        else for(;$array=mysqli_fetch_array($result);)
        {
          $id=$array['id'];
          $name=sprintf("%8.20s",$array["NAME"])."...";
$desc=sprintf("%8.77s",$array["description"])."...";
          $price=$array['price'];
          $photo=$array['photo'];
          $cat=$array['category'];
          $amount=$array["amount"];

          echo "<form class='col-md-3' method='get' action='product.php'>";
            echo "<div class='card' style='width: 18rem'>";
              echo "<img class='card-img-top img-thumbnail'  src='$photo' />";
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
        }
         ?>
  <!--/div-->
</div>
</div>
<!--fine-cards-->
<?php include "bottom.html"; ?>
