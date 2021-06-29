<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"])){
  header("Location: index.php");
}

if(isset($_GET["id"]) && is_numeric($_GET["id"])){
  if(Particulier::particulierExiste(Particulier::mailFromID($_GET["id"])))
    $userPar = new Particulier(Particulier::mailFromID($_GET["id"]));
  else
   header("Location: index.php");
} else if($_SESSION["USER_TYPE"] == TYPE_PARTICULIER)
  $userPar = new Particulier($_SESSION["USER_EMAIL"]);
else
  header("Location: index.php");

if(isset($_POST["itemID"]) && is_numeric($_POST["itemID"]) && isset($_POST["validateDon"]) && $_SESSION["USER_TYPE"] == TYPE_PARTICULIER){
  $currentUser = new Particulier($_SESSION["USER_EMAIL"]);
  if($currentUser->validateDon($_POST["itemID"]))
        $productValidatedOrNot = ITEM_VALIDATED;
    else
        $productValidatedOrNot = UNEXPECTED_ERROR;     
}

if(isset($_POST["itemID"]) && is_numeric($_POST["itemID"]) && isset($_POST["rejectDon"])  && $_SESSION["USER_TYPE"] == TYPE_PARTICULIER){
  $currentUser = new Particulier($_SESSION["USER_EMAIL"]);
  if($currentUser->rejectDon($_POST["itemID"]))
        $productValidatedOrNot = ITEM_REJECTED;
    else
        $productValidatedOrNot = UNEXPECTED_ERROR;     
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

<?php

if($_SESSION["USER_TYPE"] == TYPE_PARTICULIER && !isset($_GET["id"])){ 
$currentUser = new Particulier($_SESSION["USER_EMAIL"]); 
  if($currentUser->getNBProductsWaitingForValidation() > 0){?>

<h2 class='titlePage'>Dons en attente de validation</h2>
<div class="row justify-content-center">
	<div class="col-auto">
	<?php if (isset($productValidatedOrNot) && !empty($productValidatedOrNot)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $productValidatedOrNot; ?></div>
		<?php } ?>
	
		<table id='tableBesoinAssociation' class='table-responsive table'>
						<thead>
						<tr>
              <th>Demandeur</th>
							<th>Nom du produit</th>
							<th>Description</th>
							<th></th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($currentUser->getProductsWaitingForValidation() as $product){ ?>
						<tr>
              <td>
                  <?php 
                  if($product["productOwnerType"] == TYPE_PARTICULIER){ ?>
                  <a href="listeArticlesParticulier.php?id=<?php echo $product["productNewOwnerID"]; ?>">
                  <?php
                    $userAsking = new Particulier(Particulier::mailFromID($product["productNewOwnerID"]));
                    echo $userAsking->nomPar." ".$userAsking->prenomPar; 
                  } else if ($product["productOwnerType"] == TYPE_ASSOCIATION) { ?>
                  <a href="listeBesoinAssociation.php?id=<?php echo $product["productNewOwnerID"]; ?>">
                  <?php 
                    $userAsking = new Association(Association::mailFromID($product["productNewOwnerID"]));
                    echo $userAsking->nomAsso; 
                  }
                  ?>
                </a>
              </td>
							<td><a href="produit.php?id=<?php echo $product["productID"]; ?>"><?php echo $product["productName"]; ?></a></td>
							<td><?php echo $product["productDesc"]; ?></td>
							<td>
								<form action="" method="POST">
									<input type="hidden" name="itemID" value="<?php echo $product["productID"]; ?>"/>
									<input type="submit" name="validateDon" value="Valider"/>
								</form>
							</td>
							<td>
							<form action="" method="POST">
									<input type="hidden" name="itemID" value="<?php echo $product["productID"]; ?>"/>
									<input type="submit" name="rejectDon" value="Rejeter"/>
								</form>
							</td>
						</tr>
							<?php } ?>
						</tbody>				
					</table>
	</div>
</div>

<?php } 
}?>

<!-- Code de la page -->
<br/>
    <h2 class='titlePage'>Liste des Articles pour Don de <a href="#"><?php echo $userPar->nomPar.' '.$userPar->prenomPar;?></a></h2>

    <div>
      <ul class="listGrid">

    <?php foreach($userPar->getProductList() as $product) { ?>
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
    </div>
     

    <!--si on vient de fiche association (et qu'on est un particulier)
    <a class=" btn btn-primary btnAjout classButtonForm" href="./suiviDon.php">Confirmer</a> -->

</body>
<footer></footer>
</html>