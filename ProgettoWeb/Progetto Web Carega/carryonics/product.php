<?php include "top.php";?>


<div class="container-fluid"  style="margin-top:100px">
  <?php
    extract($_POST);
    extract($_GET);
    if(isset($add) )
    {
        $cart=$_SESSION["cart"];

        if(!isset($cart[$product]))
        {
          //echo $cart[$product];
          $cart[$product]=$amount;
          //echo $cart[$product];
        }
        else $cart[$product]=$cart[$product]+$amount;
        //print_r($cart);
        $_SESSION['cart']=$cart;

      echo "<div class='row alert alert-primary' role='alert'>";
      echo "Now your product is in the cart!";
      echo "</div>";
      //print_r($cart);
    }
  if(isset($_SESSION["login"]))
  {
    if(isset($reserve))
    {
      $email=$_SESSION['user_email'];
      $link=mysqli_connect("localhost","root","","carryonics");
      $query="insert into bookings set site_user='$email', product=$product";
      mysqli_autocommit($link,FALSE);
      try {
        mysqli_query($link,$query);
        mysqli_commit($link);
        echo "<div class='row alert alert-warning' role='alert'>";
        echo "Product reserved, an email will be sent when it will return available!";
        echo "</div>";
        //print("ok");
      } catch (\Exception $e) {
        print($e);
        mysqli_rollback($link);
      }
    }
    if(isset($send))
    {
      if(strlen($text)<80 || strlen($text)>512)
      {
        echo "<div class='row alert alert-danger' role='alert'>";
        echo "Your review is too long or too short!";
        echo "</div>";
      }
      else {
        $email=$_SESSION["user_email"];
        $link=mysqli_connect("localhost","root","","carryonics");
        mysqli_autocommit($link,FALSE);
        $query="select * from reviews where site_user='$email' and product=$send";
        $result=mysqli_query($link,$query);
        $array=mysqli_fetch_array($result);
        if(!isset($array))
        {
          $query="insert into reviews set rev_text='$text',points=$points, site_user='$email', product=$send";
          //echo $query;
          try {
            mysqli_query($link,$query);
            mysqli_commit($link);
            echo "<div class='row alert alert-success' role='alert'>";
            echo "Review sent!";
            echo "</div>";
            //print("ok");
          } catch (\Exception $e) {
            print($e);
            mysqli_rollback($link);
          }
        }
        else {
          echo "<div class='row alert alert-danger' role='alert'>";
          echo "You're already written a review for this product!";
          echo "</div>";
        }
      }

    }
  }
  else
  {
    echo "<div class='row alert alert-danger' role='alert'>";
    echo "You must be logged for reserving or reviewing products";
    echo "</div>";
  }
  ?>
  <div class="row">
    <div class="col-sm-6">
      <?php
          extract($_GET);
          $link=mysqli_connect("localhost","root","","carryonics");
          $query="select photo from products where id=$product";
          $result=mysqli_query($link,$query);
          if($result)
          {
              $array=mysqli_fetch_array($result);
              $image=$array["photo"];
              echo "<img class='rounded mx-auto d-block' style='width:250px' src='$image'/>";
          }
          else
          {
            echo "Error: image not found!";
            exit();
          }

       ?>
    </div>
    <div class="container col-sm-6">
      <form method="post">
        <div class="container-fluid row">
          <label class="col-lg-3">Amount:</label>
          <input type="number" name="amount" value=1 min=1 class="form-control col-lg-3"/>
        </div>
        <?php
        extract($_GET);
          $link=mysqli_connect("localhost","root","","carryonics");
          $query="select amount from products where id=$product";
          $result=mysqli_query($link,$query);
          $array=mysqli_fetch_array($result);
          $amount=$array['amount'];
          //$amount=0;
          if($amount!=0)
          {
            echo "<button type='submit' name='add' class='btn btn-warning col-lg-6'>";
              echo "Add to cart!";
            echo "</button>";
          }
          else
          {
            echo "<button type='submit' name='reserve' class='btn btn-warning col-lg-6'>";
              echo "Reserve!";
            echo "</button>";
          }
        ?>

      </form>
      <div class="row">
        <!-- cambiare con prenotazione se non ci sono scorte"-->
        <table class=" table col-lg-6">
          <!--compilare con le info sul prodotto-->
          <thead >
            <tr>
              <td><h3 class="text-left"> Details </h3></td>
            </tr>
          </thead>
          <?php
              extract($_GET);
              $link=mysqli_connect("localhost","root","","carryonics");
              $query="select * from products join $category on products.id=$category.product where id=$product";
              $result=mysqli_query($link,$query);
              if(!$result)
              {
                echo "Error!";
                exit();
              }
              $array=mysqli_fetch_array($result);
              $name=$array['NAME'];
              $desc=$array["description"];
              $price=$array["price"];
              $genre=$array["genre"];
              $release=$array["release_date"];

              echo "<tr>";
                echo "<th scope='col'> Name:</th>";
                echo "<td scope='col'> $name</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<th scope='col'> Description:</th>";
                echo "<td scope='col'> $desc</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<th scope='col'> Genre:</th>";
                echo "<td scope='col'> $genre</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<th scope='col'> Release date:</th>";
                echo "<td scope='col'> $release</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<th scope='col'> Price:</th>";
                echo "<td scope='col'> $price €</td>";
              echo "</tr>";
              if($category=="books" || $category=="comics")
              {
                $author=$array['author'];
                $publish=$array["publisher"];
                $isbn=$array["isbn"];
                $pages=$array["pages"];

                echo "<tr>";
                  echo "<th scope='col'> Author:</th>";
                  echo "<td scope='col'> $author</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> Publisher:</th>";
                  echo "<td scope='col'> $publish</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> Number of pages:</th>";
                  echo "<td scope='col'> $pages</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> ISBN:</th>";
                  echo "<td scope='col'> $isbn</td>";
                echo "</tr>";
              }
              else if($category=="films")
              {
                $director=$array["director"];
                $producer=$array["producer"];
                echo "<tr>";
                  echo "<th scope='col'> Director:</th>";
                  echo "<td scope='col'> $director</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> Producer:</th>";
                  echo "<td scope='col'> $producer</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> Actors:</th>";
                  $query="select * from film_actor join actors on film_actor.actor=actors.id where film_actor.film=$product";
                  $actors=mysqli_query($link,$query);
                  if(!$actors) echo "<td scope='col'>None</td>";
                  else
                  {
                    echo "<td scope='col'>";
                    for(;$set=mysqli_fetch_array($actors);)
                    {
                      echo $set["name"]." ".$set["surname"].", ";
                    }
                    echo "</td>";
                  }
                echo "</tr>";
              }
              else if($category=="cds" or $category=="vinils")
              {
                $author=$array["author"];
                //$producer=$array["producer"];
                echo "<tr>";
                  echo "<th scope='col'> Author:</th>";
                  echo "<td scope='col'> $author</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> Songs:</th>";
                  $query="";
                  if($category=="cds")
                    $query="select * from cd_song join songs on cd_song.song=songs.id where cd_song.album=$product";
                  else if($category=="vinils")
                    $query="select * from vinil_song join songs on vinil_song.song=songs.id where vinil_song.album=$product";
                  $songs=mysqli_query($link,$query);
                  if(!$songs) echo "<td scope='col'>None</td>";
                  else
                  {
                    echo "<td scope='col'>";
                    for(;$set=mysqli_fetch_array($songs);)
                    {
                      $parts=explode(".",$set["duration"]);
                      echo $set["name"].": ".$parts[0]."m &  ".$parts[1]."s\n";
                    }
                    echo "</td>";
                  }
                echo "</tr>";

              }
              else if($category=="games")
              {
                $developer=$array["developer"];
                $publisher=$array["publisher"];
                $console=$array["console"];
                $pegi=$array["pegi"];
                echo "<tr>";
                  echo "<th scope='col'> Developer:</th>";
                  echo "<td scope='col'> $developer</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> Publisher:</th>";
                  echo "<td scope='col'> $publisher</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> Console:</th>";
                  echo "<td scope='col'> $console</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<th scope='col'> PEGI:</th>";
                  echo "<td scope='col'> $pegi</td>";
                echo "</tr>";
              }
           ?>
        </table>
      </div>
    </div>
  </div>
</div>



<div class="container">
  <form class="row" method="post">
    <h4 class=" col-sm-5">Reviews</h4>
    <p class=" col-sm-6 align-right">Sort: </p>
    <select name="sort" class="col-sm-3 custom-select">
      <option value="asc">Ascendant</option>
      <option value="desc">Descendant</option>
    </select>
    <button type="submit" class="btn btn-primary col-sm-1">Go</button>
  </form>
  <!-- qui vanno le recensioni, codice PHP/J2EE per prenderle-->
  <div class="row">
    <?php
      extract($_GET);

      $link=mysqli_connect("localhost","root","","carryonics");
      $query="select * from reviews join users on users.email=reviews.site_user where product=$product order by points ";
      if(isset($_POST["sort"])) $query=$query.$_POST["sort"];
      else $query=$query."asc";
      //echo $query;
      $result=mysqli_query($link,$query);
      if(!$result)
      {
        echo "There are no reviews for this product!";
      }
      else
      {
        for(;$array=mysqli_fetch_array($result);)
        {
          $name=$array["name"];
          $surname=$array["surname"];
          $points=$array["points"];
          $text=$array["rev_text"];
          echo "<div class='container-fluid'>";
            echo "<div class='row'>";
              echo "<div class='col-4'>";
              echo "$name $surname";
              echo "</div>";
              $user=$array["email"];
              $control="select * from orders where site_user='$user' and product=$product";
              $res=mysqli_query($link,$control);
              $array=mysqli_fetch_array($res);
              if($array)
              {
                echo "<div class='col-4'>";
                  echo "Verified!";
                echo "</div>";
              }
              echo "<div class='col-4'>";
                for($i=0;$i<$points;$i++)
                  echo "★";
                  for($i=$points;$i<5;$i++)
                    echo "☆";

              echo "</div>";
            echo "</div>";
            echo "<div class='row col-12'>";
              echo $text;
            echo "</div>";
          echo "</div>";
        }

      }
     ?>


  </div>
  <?php
   $product=$_GET["product"];
   if(isset($_SESSION["user_email"]))
   {
     echo "<form method='post' class='form-group container'>";
     echo "<div class='row'>";
     echo "<h4 class='col-sm-2'>Write a review</h4>";
     echo "<div class='col-sm-3'></div>";
     //echo"<input type='hidden' name='product' value='$product'>";
     echo "<input type='range' min='1' max='5' step='1' name='points' class='custom-range form-control-range col-sm-2'/>";
     echo "<div class='col-sm-3'></div>";
     echo "<button type='submit' name='send' value='$product' class='btn btn-primary col-sm-2'>Send</button>";
     echo "</div>";
     echo "<textarea name='text' class='form-control custom-textarea row col-sm-12' style='margin-top:10px' required></textarea>";
     echo "</form>";

   }
   else echo "if you want to write a review, please log in!";
   ?>
</div>
<?php include "cart.php"; ?>


<?php include "bottom.html"; ?>
