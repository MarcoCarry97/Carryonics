<?php include "top.php" ?>
<?php include "cart.php" ?>


<form style="margin-top:100px" class="form.inline container" method="post" action="http://localhost:8080//Managing/UpDelSong">
  <div class="row">
    <h4 class="col-12">Update/delete a song</h4>
    <label class="col-sm-2">Name:</label>
    <input class="form-control col-sm-4" type="text" id="name" name="name" required>
    <label class="col-sm-2">Duration:</label>
    <input class="form-control col-sm-4" type="text" id="duration" name="duration" pattern="^([1-9][0-9]*):[0-9]{2}$"/>
  </div>
  <div class="container">
    <label class="row">Which albums?</label>

  <?php
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
    echo "<div class='container row'>";
    print("<button class='btn btn-primary col-sm-3' value='$cds-$vinils' type='submit' name='updel' id='updel'>Update</button>");
    echo "<div class='col-sm-1'></div>";
    echo "<button class='btn btn-danger col-sm-3' type='submit' name='updel' id='updel' value='delete'>Delete</button>";
    echo "<div class='col-sm-1'></div>";
    echo "<button class='btn btn-warning col-sm-4' type='submit' name='updel' id='updel' value='remove'>Remove songs from albums</button>";
    echo  "</div>";
  ?>
</div>
</form>


<?php include "bottom.html" ?>
