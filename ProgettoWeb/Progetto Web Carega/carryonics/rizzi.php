<?php include "top.php"; ?>
<body>
  <div class="jumbotron jumbotron-fluid">
    <h1 class="text-center">Tutti i Prodotti</h1>
  </div>
  <?php

  require 'db.php';
  $result= $db->query("SELECT articolo.nome,articolo.immagine,articolo.costo_articolo,articolo.id_categoria, articolo.id FROM articolo;");
  if(!$result)
  {
    echo "<p> ERRORE! CONTATTARE AMMINISTRATORE DB!</p>";
  }
  ?>
  <div class="col-lg-3">

  </div>
  <div class="col-lg-9">
    <div class="container">
      <div class="row">





        <?php
        $i=0;
        foreach ($result as $row) {
          $nomeArt=$row[0];
          $immagine=$row[1];
          $costoArt=$row[2];
          $id_cat=$row[3];
          $idArt=$row[4];
          ?>

          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card"style="width: 13rem";>
              <div class="card-img-top">
                <a href="show_product_info.php?id=<?= $idArt; ?>">
                  <img class="img img-fluid" src=<?php echo $immagine; ?> alt="immagine"></a>
                </div>
                <div class="card-text">
                  <a class="text-danger" href="show_product_info.php?id=<?= $idArt; ?>">  <h6><?=  $nomeArt; ?></h6></a>
                  <a class="text-danger" href="show_product_info.php?id=<?= $idArt; ?>">  <h4><?=  $costoArt; ?>&euro;</h4></a>
                </div>
                <div class="card-footer">
                  <form class="cart-form" action="cart.php" method="post">
                    <input type="submit" class="btn btn-outline-danger" name="cartButton" value="Aggiungi al carrello">
                  </form>
                </div>
              </div>
            </div>

          </div>


      <?php
    }
    ?>
  </div>
  </div>




  </body>
