<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"])){
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <!--Liens vers les bibliothèques externes pour utiliser Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="icon" type="image/png" href="img/logoDonhum.png" />
  <link rel="stylesheet" href="css/listeAssociation.css" />
  <link rel="stylesheet" href="css/_top_menu.css" type="text/css" />
  <title>Demandes Association</title>
</head>
<body>
  <!-- Menu -->
  <?php require_once("_top_menu.php"); ?>

<!-- Code de la page -->
<h2 class='titlePage'> Les demandes des Associations </h2>
<div>
  <ul class="listGrid">

  <?php 
  foreach(Association::getListAsso() as $idAsso){ 
    $assoInfo = new Association(Association::mailFromID($idAsso)); ?>
  <li>
      <a href="listeBesoinAssociation.php?id=<?php echo $assoInfo->idAsso; ?>" >
        <div class="listEltBox listEltImg">
            <div class="listEltDmd">
                  <h3><?php echo $assoInfo->nomAsso;?></h3><br/>
                  <p>
  <?php
    $demands = Association::getAllDemandsAssoStatic($idAsso);
    $i = 0;
    foreach($demands as $demand){
      $i++;
  ?>
   
      <?php echo $i." - ".$demand["articleName"]; ?> </br>
            
    <?php } ?>
    </p>
    </div>
      
      <div class="listEltInfo">
          <h3><?php echo $assoInfo->nomAsso; ?></h3>
          <p><?php echo substr($assoInfo->descAsso,0,64);?>...</p>
      </div>
  </div>
</a>
</li>
<?php } ?>
    
  </ul>
</div>

</body>
<footer></footer>
</html>