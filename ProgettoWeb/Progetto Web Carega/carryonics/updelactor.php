<?php include "top.php" ?>
<?php include "cart.php" ?>


<form style="margin-top:100px" class="form.inline container" method="post" action="http://localhost:8080//Managing/UpDelActor">
  <div class="row">
    <h4 class="col-12">Insert an actor</h4>
    <label class="col-sm-2">Name:</label>
    <input class="form-control col-sm-4" type="text" id="name" name="name" required>
    <label class="col-sm-2">Surname:</label>
    <input class="form-control col-sm-4" type="text" id="surname" name="surname" required>
  </div>
  <div class="container">
    <label class="row">Which films?</label>

  <?php
    print("<h5 class='col-sm-12'>Films</h5>");
    $link=mysqli_connect("localhost","root","","carryonics");
    if(mysqli_connect_errno()) echo "Connection failed";
    mysqli_autocommit($link,FALSE);
    $result=mysqli_query($link,"select id,name from products join films where products.id=films.product");
    $num=0;
    if(!$result)
    {
      print("There aren't films in the DB!");
      exit();
    }
    for(;$array=mysqli_fetch_array($result);)
    {
      $id=$array[0];
      $film=$array[1];
      echo "<div class'row'>";
      echo "<input type='checkbox' class='custom-check col-1' value='$id' name='$num' id='$num'/>";
      echo "<label class='col-11'>$film</label>";
      echo "</div>";
      $num++;
    }
    echo "<div class='container row'>";
    print("<button class='btn btn-primary container row col-3' value='$num' type='submit' name='updel' id='updel'>Insert</button>");
    echo "<div class='col-1'></div>";
    echo "<button class='btn btn-danger col-3' name='updel' id='updel' value='delete' type='submit'>Delete</button>";
    echo "<div class='col-1'></div>";
    echo "<button class='btn btn-warning col-4' name='updel' id='updel' value='remove'>Remove actor from films</button>";
    echo "</div>";
  ?>
</div>
</form>


<?php include "bottom.html" ?>
