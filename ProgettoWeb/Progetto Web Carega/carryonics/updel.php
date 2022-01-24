<?php include "top.php";?>
<?php include "cart.php";?>

<form class="form-group" method="post" action="http://localhost:8080/Managing/UpDelProduct" style="margin-top:100px">
  <div class="container">
    <div class="row">
      <label class="col-md-2">Name:</label>
      <input type="text" class="form-control col-md-6" placeholder="Name" name="name" id=="name" required/>
    </div>
    <div class="row">
      <label class="col-md-2">Description</label>
      <textarea class="form-control col-md-6" placeholder="Description" name="desc" id=="desc">
      </textarea>
    </div>
    <div class="row">
      <label class="col-md-2">Amount:</label>
      <input type="number" class="form-control col-md-6" placeholder="Amount" name="amount" id=="amount"/>
    </div>
    <div class="row">
      <label class="col-md-2">Genre:</label>
      <input type="text" class="form-control col-md-6" placeholder="Genre" name="genre" id="genre"/>
    </div>
    <div class="row">
      <label class="col-md-2">Price:</label>
      <input type="text" class="form-control col-md-6" placeholder="00.00" name="price" id="price" pattern="[0-9]{1,}\.[0-9]{2}"/>
    </div>
    <div class="row">
      <label class="col-md-2">Release date:</label>
      <input type="date" class="form-control col-md-6" name="release" id=="release"/>
    </div>
    <div class="row">
      <label class="col-md-2">Photo:</label>
      <input type="file" id="image" name="image" class="custom-file col-md-6"/>
    </div>
    <div class="row">
    <label class="col-md-2">Category:</label>
    <select  class="custom-select col-md-6" name="cat" id="cat" onchange="show()"/>
      <option value="books" selected>Books</option>
      <option value="musics">Music</option>
      <option value="films">Films</option>
      <option value="games">Games</option>
    </select>
  </div>
    <div class="container-fluid" id="bookform">
      <h3 class="row">Books</h3>
      <div class="row">
        <label class="col-md-2">Author:</label>
        <input type="text" id="bookauthor" name="bookauthor" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">Publisher:</label>
        <input type="text" id="bookpublisher" name="bookpublisher" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">ISBN:</label>
        <input type="num" id="isbn" name="isbn" pattern="97[7-9]{1}[0-9]{10}" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">Number of pages:</label>
        <input type="text" id="pages" name="pages" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">Is comic?</label>
        <input type="checkbox" id="iscomic" name="iscomic" class="custom-form col-md-6"/>
      </div>
    </div>
    <div class="container-fluid" id="musicform">
      <h3 class="row">Music</h3>
      <div class="row">
        <label class="col-md-2">Author:</label>
        <input type="text" id="musicauthor" name="musicauthor" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">Format:</label>
        <label class="col-sm-1">CD</label>
        <input type="radio" class="custom-radio col-sm-1" name="format" id="format" value="cds" checked>
        <label class="col-sm-1">Vinil</label>
        <input type="radio" class="custom-radio col-sm-1" name="format" id="format" value="vinils">
      </div>
      <?php
      print("<h5 class='col-sm-12'>Songs</h5>");
      $link=mysqli_connect("localhost","root","","carryonics");
      if(mysqli_connect_errno()) echo "Connection failed";
      mysqli_autocommit($link,FALSE);
      $result=mysqli_query($link,"select id,name from songs");
      $num=0;
      if(!$result)
      {
        print("There aren't songs in the DB!");
      }
      else for(;$array=mysqli_fetch_array($result);)
      {
        $id=$array[0];
        $song=$array[1];
        echo "<div class'row'>";
        echo "<input type='checkbox' class='custom-check col-1' value='$id' name='song-$num' id='song-$num'/>";
        echo "<label class='col-11'>$song</label>";
        echo "</div>";
        $num++;
      }
      echo "<input type='hidden' name='songs' value='$num'>";
      //echo "<form method='get' action='http://localhost:8080/Managing/RemoveSong?id=$id'>";
      echo "<a href='http://localhost:8080/Managing/RemoveSong?id=$id' class='btn btn-warning'>Delete Songs</a>";
    //echo "</form>";
       ?>

    </div>
    <div class="container-fluid" id="filmform">
      <h3 class="row">Film</h3>
      <div class="row">
        <label class="col-md-2">Director:</label>
        <input type="text" id="director" name="director" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">Producer:</label>
        <input type="text" id="filmproducer" name="filmproducer" class="form-control col-md-6"/>
      </div>
      <?php
        print("<h5 class='col-sm-12'>Actors</h5>");
        $link=mysqli_connect("localhost","root","","carryonics");
        if(mysqli_connect_errno()) echo "Connection failed";
        mysqli_autocommit($link,FALSE);
        $result=mysqli_query($link,"select id,name,surname from actors");
        $num=0;
        if(!$result)
        {
          print("There aren't films in the DB!");
        }
        else for(;$array=mysqli_fetch_array($result);)
        {

          $id=$array[0];
          $actor=$array[1]." ".$array[2];
          echo "<div class='row'>";
          echo "<input type='checkbox' class='custom-check col-1' value='$id' name='actor-$num' id='actor-$num'/>";
          echo "<label class='col-11'>$actor</label>";
          echo "</div>";
          $num++;
        }
        //echo $num;
        echo "<input type='hidden' name='actors' value='$num'>";
        /*echo "<div class='container row'>";
        print("<button class='btn btn-primary container row col-3' value='$num' type='submit' name='updel' id='updel'>Insert</button>");
        echo "<div class='col-1'></div>";
        echo "<button class='btn btn-danger col-3' name='updel' id='updel' value='delete' type='submit'>Delete</button>";
        echo "<div class='col-1'></div>";
        echo "<button class='btn btn-warning col-4' name='updel' id='updel' value='remove'>Remove actor from films</button>";
        echo "</div>";*/
      ?>
    </div>
    <div class="container-fluid" id="gameform">
      <h3 class="row">Game</h3>
      <div class="row">
        <label class="col-md-2">Developer:</label>
        <input type="text" id="developer" name="developer" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">Publisher:</label>
        <input type="text" id="gamepublisher" name="gamepublisher" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">Console:</label>
        <input type="text" id="console" name="console" class="form-control col-md-6"/>
      </div>
      <div class="row">
        <label class="col-md-2">PEGI:</label>
        <select id="pegi" name="pegi" class="form-control col-md-6">
          <option value="3" selected>3</option>
          <option value="7">7</option>
          <option value="12">12</option>
          <option value="16">16</option>
          <option value="18">18</option>
        </select>
      </div>

    </div>
    <div class="container row">
      <button class="btn btn-primary col-sm-3" type="submit" value="update" name="updel" id="updel">Load</button>
      <div class="col-sm-1"></div>
      <button class="btn btn-danger col-sm-3" type="submit" value="delete" name="updel" id="updel">Delete</button>

    </div>
  </div>
</form>

<?php include "bottom.html";?>
