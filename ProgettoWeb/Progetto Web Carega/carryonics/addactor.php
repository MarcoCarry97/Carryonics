<?php include "top.php" ?>
<?php include "cart.php" ?>


<form style="margin-top:100px" class="form.inline container" method="post" action="http://localhost:8080//Managing/AddActor">
  <div class="row">
    <h4 class="col-12">Insert an actor</h4>
    <label class="col-sm-2">Name:</label>
    <input class="form-control col-sm-4" type="text" id="name" name="name" required>
    <label class="col-sm-2">Surname:</label>
    <input class="form-control col-sm-4" type="text" id="surname" name="surname" required>
  </div>
  <div class="container">


  <button class='btn btn-primary container row col-sm-3' value='$num' type='submit' name='load' id='load'>Insert</button>
</div>
</form>


<?php include "bottom.html" ?>
