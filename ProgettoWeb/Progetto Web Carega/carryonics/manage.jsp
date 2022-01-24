<%
    Class.forName("com.mysql.jdbc.Driver");
    Connection connection=DriverManager.getConnection("jdbc:mysql://localhost:3306/carryonics","root","");
    PrintWriter out=request.getWriter();
%>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Carryonics</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="form.js"></script>
    <!--script type="text/javascript" src="update.js"></script-->
  </head>
  <body>


<form class="form-group" method="post" action="http://localhost:8080/Managing/Insert" style="margin-top:100px">
  <div class="container">
    <div class="row">
      <label class="col-md-2">Name:</label>
      <input type="text" class="form-control col-md-6" placeholder="Name" name="name" id=="name" required/>
    </div>
    <div class="row">
      <label class="col-md-2">Description</label>
      <textarea class="form-control col-md-6" placeholder="Description" name="desc" id=="desc" required>
      </textarea>
    </div>
    <div class="row">
      <label class="col-md-2">Amount:</label>
      <input type="number" class="form-control col-md-6" placeholder="Amount" name="amount" id=="amount" required/>
    </div>
    <div class="row">
      <label class="col-md-2">Genre:</label>
      <input type="text" class="form-control col-md-6" placeholder="Genre" name="genre" id="genre" required/>
    </div>
    <div class="row">
      <label class="col-md-2">Price:</label>
      <input type="text" class="form-control col-md-6" placeholder="00.00" name="price" id="price" pattern="[0-9]{1,}\.[0-9]{2}" required/>
    </div>
    <div class="row">
      <label class="col-md-2">Release date:</label>
      <input type="date" class="form-control col-md-6" name="release" id=="release" required/>
    </div>
    <div class="row">
      <label class="col-md-2">Photo:</label>
      <input type="file" id="image" name="image" class="form-control col-md-6" required/>
    </div>
    <div class="row">
    <label class="col-md-2">Category:</label>
    <select  class="custom-select col-md-6" name="cat" id="cat" onchange="show()" required/>
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
      <%
      out.println("<h5 class='col-sm-12'>Songs</h5>");
      //$link=mysqli_connect("localhost","root","","carryonics");
      //if(mysqli_connect_errno()) echo "Connection failed";
      connection.setAutoCommit(false);
      String takeSql="select id,name from songs";
      PreparedStatement take=connection.prepareStatement(takeSql);
      ResultSet set=take.executeQuery();
      //$result=mysqli_query($link,"select id,name from songs");
      int num=0;
      if(!result.first())
      {
        out.println("There aren't songs in the DB!");
      }
      else do
      {
        long id=result.getLong("id");
        String song=result.getString("name");
        out.println("<div class'row'>");
        out.println("<input type='checkbox' class='custom-check col-1' value='"+id+"' name='song-"+num+"' id='song-"+num+"'/>");
        out.println("<label class='col-11'>"+song+"</label>");
        out.println("</div>");
        num++;
      }
      while(result.next())
      out.println("<input type='hidden' name='songs' value='"+num+"'>");
       %>

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
      <%
        out.println("<h5 class='col-sm-12'>Actors</h5>");
        connection.setAutoCommit(false);
        takeSql="select id,name,surname from actors";
        take=connection.prepareStatement(takeSql);
        result=take.executeUpdate();

        //$result=mysqli_query($link,"select id,name,surname from actors");
        int num=0;
        if(!result.first())
        {
          out.println("There aren't films in the DB!");
        }
        else do
        {

          id=result.getLong("id");
          String actor=result.getString("name")+" "+result.getString("surname");
          out.println("<div class='row'>");
          out.println("<input type='checkbox' class='custom-check col-1' value='"+id+"' name='actor-"+num+"' id='actor-"+num+"'/>");
          out.println("<label class='col-11'>"+actor+"</label>");
          out.println("</div>");
          num++;
        }
        while(result.next())
        //echo $num;
        out.println("<input type='hidden' name='actors' value='"+num+"'>");
        /*echo "<div class='container row'>";
        print("<button class='btn btn-primary container row col-3' value='$num' type='submit' name='updel' id='updel'>Insert</button>");
        echo "<div class='col-1'></div>";
        echo "<button class='btn btn-danger col-3' name='updel' id='updel' value='delete' type='submit'>Delete</button>";
        echo "<div class='col-1'></div>";
        echo "<button class='btn btn-warning col-4' name='updel' id='updel' value='remove'>Remove actor from films</button>";
        echo "</div>";*/
      %>
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
    <button class="btn btn-primary" type="submit" name="load" id="load">Load</button>
  </div>
</form>

<div style="margin-bottom:100px"></div>
<!--bottom-->
<div class="container-fluid bg-primary text-center ">
  <div class="row">
    <div class="col-12">
        <p>&copy; Marco Carega, All rights reserved.</p>
    </div>
  </div>
</div>
<!--fine-bottom-->


  </body>
</html>
