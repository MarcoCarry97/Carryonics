<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"

	crossorigin="anonymous">

    <title>MeoShop</title>
  </head>
  <body style="background-color:#778899">
  <nav class="navbar navbar-dark bg-dark text-white">
  		<a class="navbar-brand">MeoShop</a>

		<div class="btn-group">
			<form class="form-inline" method="post" action="search.php">
                      <select class="browser-default custom-select" name="sel">
                        <option selected>Choose the category</option>
                        <option value="vid" >Videogiochi</option>
                        <option value="lib">Libri</option>
                        <option value="fum">Fumetti</option>
                        <option value="cd">CD</option>
                        <option value="dvd">DVD</option>
                      </select>
                      <input type="text" class="form-control" name="oggetto" aria-label="Text input with dropdown button">
                    
    				<button class="btn btn-outline-success my-2 my-sm-0 mr-3" type="submit">Search</button>
  			</form>
			<div class="input-group-prepend">
                <button type="button" class="btn btn-secondary dropdown-toggle mr-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php
// verifico se il cookie esiste
if (isset($_COOKIE['nome_utente'])) {
  $nome = $_COOKIE['nome_utente']; 
  echo $nome;
}
else{ echo "Area privata";}
?></button>
                <div class="dropdown-menu dropdown-menu-right">
                        <?php  if(isset($_COOKIE['nome_utente'])){?>
                             
                            <button class="dropdown-item" type="button" onClick=" location.href='logout.php'">Logout</button>
                        <?php
                            
                        }
                        else{
                        ?>
                            <button class="dropdown-item" type="button" onClick="location.href='login.html'">Login</button>
                            <button class="dropdown-item" type="button" onClick="location.href='register.html'">Registrati</button>
                        <?php
                        }
                        ?>
                </div>
            </div>
            <button class="btn btn-light" type="submit">Carrello</button>
		</div>
      
     
      
             
	</nav>


	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" background>
  		<ol class="carousel-indicators">
    			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  		</ol>
  		<div class="carousel-inner" >
    			<div class="carousel-item active">
      				<img src="cr7.jpg" class="d-block mx-auto" width="700px" alt="ronaldo">
    			</div>
    			<div class="carousel-item">
      				<img src="neymar.jpeg" class="d-block mx-auto"  width="700px" alt="neymar">
    			</div>
    			<div class="carousel-item">
      				<img src="messi.jpeg" class="d-block mx-auto"  width="700px" alt="messi">
    			</div>
  		</div>

  		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
    			<span class="sr-only">Previous</span>
  		</a>
  		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" color="#d0417e">
    			<span class="carousel-control-next-icon" aria-hidden="true"></span>
    			<span class="sr-only">Next</span>
  		</a>
	</div>
  <br>
  <br>
    <div align="center"> <h1><strong>Articoli venduti in questo negozio</strong></h1></div>
  <br>
<div class="card mb-4" style=" max-width: absolute; background-color:#20b2aa;">
  <div class="row no-gutters">
    <div class="col-md-3">
      <img src="game.jpeg" class="card-img" alt="...">
    </div>
    <div class="col-md-10" style="height: 300px;">
      <div class="card-body">
        <h5 class="card-title">VIDEOGAMES</h5>
        <p class="card-text">This is the part of the shop about videogames. Visit it and choose the best for you.</p>
        <label for="a">Nome </label>
        <input type="text" name="a" style="margin-top:10px;"><br>
        <label for="b">Console </label>
        <input type="text" name="b" style="margin-top:10px;"><br>
        <label for="c">Genere </label>
        <input type="text" name="c" style="margin-top:10px;"><br>
        <button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
      </div>
    </div>
  </div>
</div>
    
<div class="card mb-4" style=" max-width: absolute; background-color:#20b2aa;">
  <div class="row no-gutters">
    <div class="col-md-3">
      <img src="libri.jpeg" class="card-img" alt="...">
    </div>
    <div class="col-md-10" style="height: 300px;">
      <div class="card-body">
        <h5 class="card-title">BOOK</h5>
        <p class="card-text">This is the part of the shop about books. If you love reading is the right place for you.</p>
        <label for="a">Titolo </label>
        <input type="text" name="a" style="margin-top:10px;">
        <label for="c">Numero pagine </label>
        <input type="text" name="c" style="margin-top:10px;"><br>
        <label for="b">Autore </label>
        <input type="text" name="b" style="margin-top:10px;">
        <label for="c">EDITORE </label>
        <input type="text" name="c" style="margin-top:10px;"><br>
        <label for="c">ISBN </label>
        <input type="text" name="c" style="margin-top:10px;"><br>
        
        <button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
      </div>
    </div>
  </div>
</div>
    
<div class="card mb-4" style=" max-width: absolute; background-color:#20b2aa;">
  <div class="row no-gutters">
    <div class="col-md-3">
      <img src="bracciodiferro.jpeg" class="card-img" alt="...">
    </div>
    <div class="col-md-10" style="height: 300px;">
      <div class="card-body">
        <h5 class="card-title">COMIC STRIPS</h5>
        <p class="card-text">This is the part of the shop about comic strips. Choose your favourite.</p>
        <label for="a">Titolo </label>
        <input type="text" name="a" style="margin-top:10px;">
        <label for="b">Nome personaggio </label>
        <input type="text" name="b" style="margin-top:10px;"><br>
        <label for="b">Autore </label>
        <input type="text" name="b" style="margin-top:10px;"><br>
        <label for="c">ISBN </label>
        <input type="text" name="c" style="margin-top:10px;"><br>
        <button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
      </div>
    </div>
  </div>
</div>
    
<div class="card mb-4" style=" max-width: absolute; background-color:#20b2aa;">
  <div class="row no-gutters">
    <div class="col-md-3">
      <img src="cd.jpeg" class="card-img" alt="...">
    </div>
    <div class="col-md-10" style="height: 300px;">
      <div class="card-body">
        <h5 class="card-title">CD</h5>
        <p class="card-text">This is the part of the shop about songs. Id you usually listen to music, search your favourite.</p>
        <label for="a">Titolo </label>
        <input type="text" name="a" style="margin-top:10px;"><br>
        <label for="b">Autore </label>
        <input type="text" name="b" style="margin-top:10px;"><br>
        <button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
      </div>
    </div>
  </div>
</div>
    
<div class="card mb-4" style=" max-width: absolute; background-color:#20b2aa;">
  <div class="row no-gutters">
    <div class="col-md-3">
      <img src="dvd.png" class="card-img" alt="...">
    </div>
    <div class="col-md-10" style="height: 300px;">
      <div class="card-body">
        <h5 class="card-title">DVD</h5>
        <p class="card-text">This is the part of the shop about movies. There many kind of movies.</p>
        <label for="a">Titolo </label>
        <input type="text" name="a" style="margin-top:10px;">
        <label for="c">Direttore </label>
        <input type="text" name="c" style="margin-top:10px;"><br>
        <label for="c">Nome di un attore </label>
        <input type="text" name="c" style="margin-top:10px;">
        <label for="b">Anno di uscita </label>
        <input type="text" name="b" style="margin-top:10px;"><br>
        <label for="c">Genere </label>
        <input type="text" name="c" style="margin-top:10px;"><br>
        
        <button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
      </div>
    </div>
  </div>
</div>

  <footer class="page-footer font-small bg-dark">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2018 Copyright:
    <a href="https://mdbootstrap.com/education/bootstrap/"> MDBootstrap.com</a>
  </div>
  <!-- Copyright -->

  </footer>
  </body>
</html>


