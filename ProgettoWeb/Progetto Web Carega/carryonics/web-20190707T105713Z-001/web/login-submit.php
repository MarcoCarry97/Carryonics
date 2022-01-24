<!doctype html>
<html lang="it">
<head><title>SignupSubmitPage</title></head>
<body>
    <?php
        extract($_POST);
        $mail = $_POST['exampleInputEmail1'];
        $pwd = $_POST['exampleInputPassword1'];
        $query = "SELECT nome,email,password from utente WHERE email='$mail' && password='$pwd'";  
    
      // Connect to MySQL
      if(!($database = mysqli_connect("localhost","root","diego","test"))){
          die( "Could not connect to database" );
      }

      // query Products database
      if(!($result = mysqli_query($database,$query))){
          print( "Could not execute query! <br />" );
          die(mysqli_error($database) );
      }
    
      $row = mysqli_fetch_row($result);
      mysqli_close($database);
      if($row==NULL){
          die("Email o password non corrette!<br />");
      }
      else{
          setcookie("nome_utente", $row[0], time()+3600);
          setcookie("email",$row[1], time()+3600);
          echo "Login effettuato correttamente";
          echo "<br>";
      }
      ?>
      <button class="btn btn-outline-success my-2 my-sm-0 mr-3" type="button" onclick=" location.href='AreaPrivata.php' ">Vai alla pagina privata</button>
</body>
</html>