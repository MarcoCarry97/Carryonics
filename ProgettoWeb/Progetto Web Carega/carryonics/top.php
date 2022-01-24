<?php
session_start();
if(!isset($_SESSION["cart"]))
{
  //echo "\n\n\n\n\n\n\n\n\n\n ok" ;
  $_SESSION["cart"]=array();
}
//session_unset();
//print("1\n2\n3\n4");
/*extract($_POST);
if(isset($_SESSION["login"]))
  session_unset();
*/
?>

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




<!--top-->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="topNav">

  <button class="navbar-toggler btn-primary" type="button" data-toggle="collapse" data-target="#navcontent"
    aria-controls="topNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon "></span>
    </button>

  <a class="navbar-brand collapse navbar-collapse" href="index.php">Carryonics</a>


  <form class="form-inline" method="get" action="search.php">
    <div class="input-group">
      <select name="order" id="order" class="custom-select">
        <option value="price desc" selected>Lower price</option>
        <option value="price asc">Upper price</option>
        <option value="name desc">Lower name</option>
        <option value="name asc">Upper name</option>
      </select>
        <input type="search" class="form-control input-append" name="search" id="search" required>
        <button type="submit" id="searchButton" class="btn btn-warning" aria-describedby="search">
          <img src="search.png"/>
        </button>

    </div>
  </form>

    <div class="collapse navbar-collapse" id="navcontent">

      <form method="get" action="search.php">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item dropdown">
        <button class="btn nav-link" type="submit" name="search" value="books">Books</button>
      </li>
      <li class="nav-item dropdown">
        <button class="btn nav-link" type="submit" name="search" value="comics">Comics</button>
      </li>
      <li class="nav-item dropdown">
        <button class="btn nav-link" type="submit" name="search" value="games">Games</button>
      </li>
      <li class="nav-item dropdown">
        <button class="btn nav-link" type="submit" name="search" value="films">Films</button>
      </li>
      <li class="nav-item dropdown">
        <button class="btn nav-link" type="submit" name="search" value="cds">CDs</button>
      </li>
      <li class="nav-item dropdown">
        <button class="btn nav-link" type="submit" name="search" value="vinils">Vinils</button>
      </li>

    <!--a class="nav-link dropdown-toggle" href="#" id="bookdrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Books
    </a>
    <div class="dropdown-menu" aria-labelledby="bookdrop">
      <a class="dropdown-item" href="#">Crime</a>
      <a class="dropdown-item" href="#">Love</a>
      <a class="dropdown-item" href="#">Fun</a>
      <a class="dropdown-item" href="#">Biography</a>
      <a class="dropdown-item" href="#">Literature</a>
      <a class="dropdown-item" href="#">Horror</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Show all books</a>
    </div>
    </li>
      <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="comicdrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     Comics
    </a>
    <div class="dropdown-menu" aria-labelledby="comicdrop">
      <a class="dropdown-item" href="#">Crime</a>
      <a class="dropdown-item" href="#">Love</a>
      <a class="dropdown-item" href="#">Fun</a>
      <a class="dropdown-item" href="#">Superheroes</a>
      <a class="dropdown-item" href="#">Graphic novels</a>
      <a class="dropdown-item" href="#">Horror</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Show all comics</a>
    </div>
    </li>
      <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="filmdrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Films
    </a>
    <div class="dropdown-menu" aria-labelledby="filmdrop">
      <a class="dropdown-item" href="#">Crime</a>
      <a class="dropdown-item" href="#">Love</a>
      <a class="dropdown-item" href="#">Fun</a>
      <a class="dropdown-item" href="#">Documentaries</a>
      <a class="dropdown-item" href="#">Adventury</a>
      <a class="dropdown-item" href="#">Horror</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Show all films</a>
    </div>
    </li>
      <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="gamesdrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Games
    </a>
    <div class="dropdown-menu" aria-labelledby="gamesdrop">
      <a class="dropdown-item" href="#">Platform</a>
      <a class="dropdown-item" href="#">Action</a>
      <a class="dropdown-item" href="#">Stealth</a>
      <a class="dropdown-item" href="#">Adventury</a>
      <a class="dropdown-item" href="#">Shooter</a>
      <a class="dropdown-item" href="#">Horror</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Show all games</a>
    </div>
    </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="musicdrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Music
      </a>
      <div class="dropdown-menu" aria-labelledby="musicdrop">
        <a class="dropdown-item" href="#">Pop</a>
        <a class="dropdown-item" href="#">Rock</a>
        <a class="dropdown-item" href="#">Metal</a>
        <a class="dropdown-item" href="#">Indie</a>
        <a class="dropdown-item" href="#">Progressive</a>
        <a class="dropdown-item" href="#">Soundtrack</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">Show all musics</a-->

      </ul>
        </form>
  </div>
    <div class="btn-group">
      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
        <?php
          extract($_POST);
          if(isset($_SESSION))
          {
            $name="";
            if(!isset($logoutBtn) && isset($_SESSION["user_name"]))
              $name=$_SESSION["user_name"];
            else
            {
              unset($_SESSION["user_name"]);
              unset($_SESSION["user_email"]);
              unset($_SESSION["login"]);
              //print_r($_SESSION);
            }
            if(isset($login))
            {
                $link=mysqli_connect("localhost","root","","carryonics");
                if (mysqli_connect_errno())
                {
                  echo "Failed to connect to MySQL: " . mysqli_connect_error();
                  print("no");
                }
                $sql="select name from users where email='$email' and pass='$pass'";
                $result=mysqli_query($link,$sql);
                if(isset($result))
                {
                  $line=mysqli_fetch_array($result,MYSQLI_ASSOC);
                  if($line["name"]!="")
                  {
                    $_SESSION["user_name"]=$line["name"];
                    $_SESSION["user_email"]=$email;
                    $_SESSION["login"]=true;
                    $_SESSION["max"]=500;
                    $_SESSION["spent"]=0;
                    $name=$_SESSION["user_name"];
                  }
                }
                else
                {

                }
                mysqli_close($link);
            }
            print("Hi $name!");
          }
          else print("Hi!");
        ?>
      </button>
    <div class="dropdown-menu dropdown-menu-lg-right dropdown-menu-left">
    <?php
        extract($_POST);
        //print_r($_SESSION);
        if(isset($_SESSION))
        {
          if(!isset($_SESSION["login"]))
          {
            unset($_SESSION["user_name"]);
            unset($_SESSION["user_email"]);
            unset($_SESSION["login"]);
            unset($_SESSION["max"]);
             print("  <button class='dropdown-item' type='button' data-toggle='modal' data-target='#loginModal'>Login</button>");
          }
          else
          {
            print("<form method='post' >");
            print("<button class='dropdown-item' type='submit' name='logoutBtn'>Logout</button>");
            print("</form>");
          }
        }
    ?>
    <!--button class="dropdown-item" type="button">Orders</button-->
    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#cartModal">Shopping cart</button>
  </div>
</div>
</nav>
<!--fine-top-->

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex='-1' role='dialog' aria-labelledby='loginModalLabel' aria-hidden='false'>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">

                <h5 class='modal-title' id='loginModalLabel'>
                  Login
                </h5>
                <button  type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>

      </div>

        <form class="form-group" method="post" >
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <label>E-mail:</label>
              </div>
              <div class="col-sm-6">
                <input type="email" class="form-control" name="email" id="email" placeholder="user@domain.com" required/>
                <small>
                <a href="signup.php">Not signed?</a>
                </small>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                  <label>Password:</label>
              </div>
              <div class="col-sm-6">
                  <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" required/>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="login" id="submit">Login</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
<!--fine-modal-->
