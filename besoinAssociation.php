<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"]) || $_SESSION["USER_TYPE"] != TYPE_ASSOCIATION){
  header("Location: index.php");
}

$userAsso = new Association($_SESSION["USER_EMAIL"]);

if(isset($_POST["articleName"]) && !empty($_POST["articleName"]) && isset($_POST["articleQuantite"]) && !empty($_POST["articleQuantite"])){

	if($userAsso->createNewDemande($_POST["articleName"], $_POST["articleQuantite"]))
		$newDemandAddedConfirm = NEW_ADDED_DEMANDE;

}

if(isset($_GET["delete"]) && is_numeric($_GET["delete"])){
	if($userAsso->deleteDemande($_GET["delete"]))
		$deletetDemandeSuccess = DELETED_DEMAND;
}

if(isset($_POST["itemID"]) && is_numeric($_POST["itemID"]) && isset($_POST["validateDon"])){
	if($userAsso->validateDon($_POST["itemID"]))
        $productValidatedOrNot = ITEM_VALIDATED;
    else
        $productValidatedOrNot = UNEXPECTED_ERROR;     
}
if(isset($_POST["itemID"]) && is_numeric($_POST["itemID"]) && isset($_POST["rejectDon"])){
	if($userAsso->rejectDon($_POST["itemID"]))
        $productValidatedOrNot = ITEM_REJECTED;
    else
        $productValidatedOrNot = UNEXPECTED_ERROR;     
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
		<h2 class='titlePage'> Vos demandes</h2>
<div class="row justify-content-center">
	<div class="col-auto">
	<?php if (isset($deletetDemandeSuccess) && !empty($deletetDemandeSuccess)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $deletetDemandeSuccess; ?>
            <?php } ?>
			</div>
		<table id='tableBesoinAssociation' class='table-responsive table'>
						<thead>
						<tr>
							<th>Article</th>
							<th>Quantité</th>
							<th>Nombre de dons</th>
							<th>Supprimer</th>
						</tr>
						</thead>
						<tbody>	
						<?php 
						foreach($userAsso->getAllDemandsAsso() as $demand){ ?>
						<tr>
							<td><?php echo $demand["articleName"]; ?></td>
							<td><?php echo $demand["articleQuantite"]; ?></td>
							<td><?php echo $userAsso->countDonBesoin($demand["idBesoin"]); ?></td>
							<td><a style="color:red;" href="besoinAssociation.php?delete=<?php echo $demand["idBesoin"]; ?>">X</a></td>
						</tr>
							<?php } ?>
						</tbody>				
					</table>
	</div>
</div>

		<h2 class='titlePage'>Créer une nouvelle demande</h2>
		
		<div class="row justify-content-center">
    <div class="col-auto">
		<!-- Formulaire pour indiquer les besoins de l'association -->
		<?php if (isset($newDemandAddedConfirm) && !empty($newDemandAddedConfirm)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $newDemandAddedConfirm; ?>
            <?php } ?>
		</div>
		<form id='formBesoinAssociation' name="formBesoinAssociation" method="post" action="">
			<div id='formDivBesoinAssociation'>
				<table id='tableBesoinAssociation' class='table-responsive table-hover'>
					<thead>
					<tr>
						<th>Article</th>
						<th>Quantité</th>
					</tr>
					</thead>
					<tbody>	
						<td><input type="name" name="articleName" /></td>
						<td><input type="number" name="articleQuantite" /></td>
					</tbody>				
				</table>
			</div>
			
			<input type="submit" id='btnValider' value="Créer">
			
		</form>
		</div>
</div>

<h2 class='titlePage'>Dons en attente de validation</h2>
<div class="row justify-content-center">
	<div class="col-auto">
	<?php if (isset($productValidatedOrNot) && !empty($productValidatedOrNot)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $productValidatedOrNot; ?>
		<?php } ?>
	</div>
		<table id='tableBesoinAssociation' class='table-responsive table'>
						<thead>
						<tr>
							<th>Nom du produit</th>
							<th>Description</th>
							<th></th>
							<th></th>
						</tr>
						</thead>
						<tbody>	
						<?php 
						foreach($userAsso->getProductsWaitingForValidation() as $product){ ?>
						<tr>
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
	</body>
	<footer></footer>
</html>