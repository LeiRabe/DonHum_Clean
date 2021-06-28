<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"]) || $_SESSION["USER_TYPE"] != TYPE_PARTICULIER){
  header("Location: index.php");
}

$userPar = new Particulier($_SESSION["USER_EMAIL"]);

if ((isset($_POST["nomParticulier"]) && !empty($_POST["nomParticulier"]))
    && (isset($_POST["prenomParticulier"]) && !empty($_POST["prenomParticulier"]))
    && (isset($_POST["telParticulier"]) && !empty($_POST["telParticulier"]))
    && (isset($_POST["emailParticulier"]) && !empty($_POST["emailParticulier"]))
    && (isset($_POST["descParticulier"]) && !empty($_POST["descParticulier"]))) {
    
    $particulierUpdateMessage =  $userPar->updateProfile($_POST["telParticulier"], $_POST["descParticulier"], $_POST["emailParticulier"], $_POST["nomParticulier"], $_POST["prenomParticulier"]);

}

$userPar = new Particulier($_SESSION["USER_EMAIL"]);
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
    <link rel="icon" type="image/png" href="../img/logoDonhum.png" />
    <link rel="stylesheet" href="css/profilParticulier.css"/>
		<link rel="stylesheet" href="css/_top_menu.css" />
    <title>Profil Particulier</title>
</head>
<body>
<!-- Menu -->

<?php require_once("_top_menu.php"); ?>

<!-- Code de la page -->

<h2>Profil Particulier</h2>

<!-- Les formulaires -->
<div id="formDonhum" class="container">
    <form method="post" action="">
    <?php if (isset($particulierUpdateMessage) && !empty($particulierUpdateMessage)){ ?>
            <div class="alert alert-secondary" role="alert"><?php echo $particulierUpdateMessage; ?></div>
            <?php } ?>
        <div class="formulaireProfilParticulier">
                <div class="form-group left">
                    <label for="nomParticulier">Nom</label>
                    <input type="text" name="nomParticulier" class="form-control formControl" id="nomParticulier" value="<?php echo $userPar->nomPar;?>">
                </div>
                <div class="form-group left space">
                    <label for="prenomParticulier">Prénom</label>
                    <input type="text" name="prenomParticulier" class="form-control formControl" id="prenomParticulier" value="<?php echo $userPar->prenomPar;?>"> 
                </div>
                <div class="clear"></div>
                <div class="form-group, left">
                    <label for="emailParticulier">E-mail</label>
                    <input type="email" name="emailParticulier" class="form-control formControl" id="emailParticulier" value="<?php echo $userPar->emailPar;?>">
                </div>
                <div class="form-group left space">
                    <label for="telParticulier">Numéro de téléphone</label>
                    <input type="tel" name="telParticulier" class="form-control formControl" id="telParticulier" value="<?php echo $userPar->telPar;?>">
                </div>
                <div class="clear"></div>
                <div class="form-group desc">
                    <label for="descParticulier">Description</label>
                    <textarea rows="5" class="form-control formControl" name="descParticulier" id="descParticulier"><?php echo $userPar->descPar;?></textarea>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary classButtonForm buttonModifier">Valider</button>
            </div>
    </form>
</div>
</body>
<footer></footer>
</html>