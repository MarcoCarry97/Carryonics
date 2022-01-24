<?php include "top.php"?>
<?php include "cart.php"?>

<form class="container form-group" style="margin-top:100px" method="post" action="http://localhost:8080/Managing/Amount">
  <div class="row">
    <label class="col-sm-3">Name: </label>
    <input type="text" name="name" ind="name" class="form-control col-sm-9">
  </div>
  <div class="row">
    <label class="col-sm-3">Amount: </label>
    <input type="number" name="amount" ind="amount" class="form-control col-sm-9">
  </div>
  <button type="submit" class="btn btn-primary col-sm-3">Add</button>
</form>

<?php include "bottom.html"?>
