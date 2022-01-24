<?php include "top.php";?>
<?php include "cart.php"; ?>

<form class="container form-group" style="margin-top:100px;" method="post" action="signup-submit.php">
  <h3 class="row col-12">Sign up</h3>
  <div style="margin-top:10px;"></div>
  <div class="row">
  <div class="col-sm-1">
      <label>Name:</label>
  </div>
  <input type="text" placeholder="Name" name="name" class="col-md-5 form-control" required/>
  <div class="col-sm-1">
      <label>Surname:</label>
  </div>
  <input type="text" placeholder="Surname" name="surname" class="col-md-5 form-control" required/>
</div>
<div style="margin-top:10px;"></div>
<div class="row">
  <div class="col-sm-1">
      <label>Email:</label>
  </div>
  <input type="email" placeholder="Email" name="email" class="col-md-5 form-control" required/>
  <div class="col-sm-1">
      <label>Password:</label>
  </div>
  <input type="password" placeholder="Password" name="pass" pattern="[a-zA-Z0-9!?/*]{8,}" class="col-md-5 form-control" required/>
  </div>

  <div style="margin-top:10px;"></div>

  <div class="row">
  <div class="col-sm-1">
      <label>Address:</label>
  </div>
  <input type="text" placeholder="Address" name="address" class="col-md-3 form-control" required/>
  <div class="col-sm-1">
      <label>Street number:</label>
  </div>
  <input type="text" placeholder="Street number"name="street" class="col-md-3 form-control" required/>
  <div class="col-sm-1">
      <label>Postcode:</label>
  </div>
  <input type="text" placeholder="Postcode" name="postcode" class="col-md-3 form-control" pattern="[0-9]{5}" required/>

  </div>

  <div class="row">
  <div class="col-sm-1">
      <label>City:</label>
  </div>
  <input type="text" placeholder="City" name="city" class="col-md-3 form-control" required/>
  <div class="col-sm-1">
      <label>Credit card:</label>
  </div>
  <input type="text" placeholder="Credit card" name="credit" class="col-md-3 form-control" pattern="[0-9]{16}" required/>


      <div class="col-sm-1">
          <label>Expiraton date:</label>
      </div>
      <input type="text" placeholder="00/00" name="expdate" class="col-md-3 form-control" pattern="^((0[1-9]{1})|(1[0-2]{1}))/((0[1-9]{1})|[1-9]{2}|([1-9]{1}0))$" required/>

      </div>
    </div>
    <div class="row col-12" style="margin-top:10px"></div>
    <div class="row">
      <div class="col-sm-1">
          <label>Security code:</label>
      </div>
      <input type="text" placeholder="000" name="sec" class="col-md-3 form-control" pattern="[0-9]{3}" required/>
    </div>
  </div>
  <button type="submit" class="btn btn-primary row col-sm-12" name="signup" style="margin-top:10px" >Sign up</button>

</form>

<?php include "bottom.html"; ?>
