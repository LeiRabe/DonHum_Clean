<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"])){
  header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <!--Liens vers les bibliothèques externes pour utiliser Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/png" href="img/logoDonhum.png" />
    <link rel="stylesheet" href="css/listeArticlesPart.css" type="text/css" />
    <link rel="stylesheet" href="css/_top_menu.css" type="text/css" />
    <title>Liste des Articles pour Don</title>
</head>

<body>
<!-- Menu -->

<?php require_once("_top_menu.php"); ?>

<!-- Code de la page -->
<br/>
    <h2 class='titlePage'>Derniers articles mis en don</a></h2>

    <?php 
    $nbResult = 0;
    if(!isset($_POST["search"]) || empty($_POST["search"])){ 
    ?>

    <div>
      <ul class="listGrid">

    <?php foreach(Produit::getLatestProducts(0, 100) as $product) { 
      $nbResult++; 
    ?>
        <li>
          <div class="listEltBox xop-img" style="background: linear-gradient( rgba(0, 0, 0, 0.50), rgba(0, 0, 0, 0.10)), url('<?php echo UPLOAD_FOLDER.$product["productImage"];?>'); background-size:contain;background-repeat:no-repeat;
          background-position:center;">
            <a href="./produit.php?id=<?php echo $product["productID"];?>">
              <div class="listEltInfo">
                  <h3><?php echo $product["productName"];?></h3>
                  <p><?php echo substr($product["productDesc"],0,17);?>...</p>
              </div>
            </a>
          </div>
        </li>
      <?php } ?>
      </ul>

    <?php } else { ?>

      <div>
      <ul class="listGrid">

    <?php foreach(Produit::searchProducts($_POST["search"], 0, 100) as $product) { $nbResult++; ?>
        <li>
          <div class="listEltBox xop-img" style="background: linear-gradient( rgba(0, 0, 0, 0.50), rgba(0, 0, 0, 0.10)), url('<?php echo UPLOAD_FOLDER.$product["productImage"];?>'); background-size:contain;background-repeat:no-repeat;
          background-position:center;">
            <a href="./produit.php?id=<?php echo $product["productID"];?>">
              <div class="listEltInfo">
                  <h3><?php echo $product["productName"];?></h3>
                  <p><?php echo substr($product["productDesc"],0,17);?>...</p>
              </div>
            </a>
          </div>
        </li>
      <?php } ?>
      </ul>

    <?php } 
    if($nbResult == 0) { ?>

      <div style="text-align:center;margin-top:50px;">Aucun résultat</div>

    <?php } ?>
      </div>


</body>
<footer></footer>
</html>