<?php include "top.php" ?>
<?php include "cart.php" ?>


<form style="margin-top:100px" class="form.inline container" method="post" action="http://localhost:8080//Managing/AddSong">
  <div class="row">
    <h4 class="col-12">Insert a song</h4>
    <label class="col-sm-2">Name:</label>
    <input class="form-control col-sm-4" type="text" id="name" name="name" required>
    <label class="col-sm-2">Duration:</label>
    <input class="form-control col-sm-4" type="text" id="duration" name="duration" pattern="^[0-9]{1,2}:[0-9]{2}$" required>

  </div>
  <div class="container">
    <button class='btn btn-primary container row col-sm-3' type='submit' name='load' id='load'>Insert</button>

  <!--?php
    print("<h5 class='col-sm-12'>CDs</h5>");
    $link=mysqli_connect("localhost","root","","carryonics");
    if(mysqli_connect_errno()) echo "Connection failed";
    mysqli_autocommit($link,FALSE);
    $result=mysqli_query($link,"select id,name from products join cds where products.id=cds.product");
    $cds=0;
    if(!$result)
    {
      print("There aren't CDs in the DB!");
      exit();
    }
    for(;$array=mysqli_fetch_array($result);)
    {
      $id=$array[0];
      $album=$array[1];
      echo "<div class'row'>";
      echo "<input type='checkbox' class='custom-check col-1' value='$id' name='cd$cds' id='cd$cds'/>";
      echo "<label class='col-11'>$album</label>";
      echo "</div>";
      $cds++;
    }
    $result=mysqli_query($link,"select id,name from products join vinils where products.id=vinils.product");
    print("<h5 class='col-sm-12'>Vinils</h5>");
    if(!$result)
    {
      print("There aren't vinils in the DB!");
      exit();
    }
    $vinils=0;
    for(;$array=mysqli_fetch_array($result);)
    {
      $id=$array[0];
      $album=$array[1];
      echo "<div class'row'>";
      echo "<input type='checkbox' class='custom-check col-1' value='$id' name='vinil$vinils' id='vinil$vinils'/>";
      echo "<label class='col-11'>$album</label>";
      echo "</div>";
      $vinils++;
    }

    if($cds+$vinils!=0) print("<button class='btn btn-primary container row col-sm-3' value='$cds-$vinils' type='submit' name='load' id='load'>Insert</button>");

  ?-->
</div>
</form>


<?php include "bottom.html" ?>
