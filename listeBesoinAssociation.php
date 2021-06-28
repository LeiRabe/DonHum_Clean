<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"])){
  header("Location: index.php");
}

if(isset($_GET["id"]) && is_numeric($_GET["id"])){
    if(Association::associationExiste(Association::mailFromID($_GET["id"])))
      $userAsso = new Association(Association::mailFromID($_GET["id"]));
    else
     header("Location: index.php");
  }
  else
header("Location: index.php");

if(isset($_POST["itemID"]) && is_numeric($_POST["itemID"])
    && isset($_POST["besoinID"]) && is_numeric($_POST["besoinID"])
    && $_SESSION["USER_TYPE"] == TYPE_PARTICULIER){

    $userPar = new Particulier($_SESSION["USER_EMAIL"]);

    if($userPar->giveProduit($_POST["itemID"], $_GET["id"], TYPE_ASSOCIATION, $_POST["besoinID"]))
        $giveItemMessage = ITEM_GIVEN;
    else
        $giveItemMessage = UNEXPECTED_ERROR;     

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
		<link rel="icon" type="image/png" href="../img/logoDonhum.png" />
		<link rel="stylesheet" href="css/modifBesoinAssociation.css" />
		<link rel="stylesheet" href="css/listeAssociation.css" />
		<link rel="stylesheet" href="css/_top_menu.css" />
		<title>Besoin Association</title>
	</head>
		
	<!-- dans le body j'affiche donc ma première ligne de formulaire
	je le fais en javascript pour pouvoir la supprimer plus facilement-->
	<body onload="init();">
		<!-- Menu -->
		
		<?php require_once("_top_menu.php"); ?>
		
		<!-- Code de la page -->
		<h2 class='titlePage'>Demandes de <a href="listeBesoinAssociation.php?id=<?php echo $userAsso->idAsso; ?>"><?php echo $userAsso->nomAsso; ?></a></h2>
<div class="row justify-content-center">

	<div style="width:100%;text-align:center; margin-top:50px;margin-bottom:75px;">
		<?php echo $userAsso->descAsso; ?>
	</div>
	<div class="col-auto">
	<?php if (isset($giveItemMessage) && !empty($giveItemMessage)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $giveItemMessage; ?>
            <?php } ?>
			</div>
		<table id='tableBesoinAssociation' class='table-responsive table'>
						<thead>
						<tr>
							<th>Article</th>
							<th>Quantité</th>
                            <?php if($_SESSION["USER_TYPE"] == TYPE_PARTICULIER) { ?>
							<th>Faire un don</th>
                            <?php } ?>
						</tr>
						</thead>
						<tbody>	
						<?php 
						foreach($userAsso->getAllDemandsAsso() as $demand){ ?>
						<tr>
							<td><?php echo $demand["articleName"]; ?></td>
							<td><?php echo $demand["articleQuantite"]; ?></td>
                            <?php if($_SESSION["USER_TYPE"] == TYPE_PARTICULIER) { ?>
							<td>
                            <form method="POST" action="">
                                <select name="itemID">
                                    <option value="-1">--</option>
                                    <?php
                                    $userPar = new Particulier($_SESSION["USER_EMAIL"]);
                                    foreach($userPar->getProductList() as $produit) { ?>
                                        <option value="<?php echo $produit["productID"]; ?>"><?php echo $produit["productName"]; ?></option>
                                    <?php } ?>
                                </select>

                                <input type="hidden" name="besoinID" value="<?php echo $demand["idBesoin"]; ?>" />    
                                <input type="submit" name="giveItem" value="Don" />
                            </form>
                            </td>
                            <?php } ?>
						</tr>
							<?php } ?>
						</tbody>				
					</table>
	</div>
</div>

		
	</body>
	<footer></footer>
</html>