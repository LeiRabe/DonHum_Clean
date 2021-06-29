<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"]) || $_SESSION["USER_TYPE"] != TYPE_ASSOCIATION){
  header("Location: index.php");
}

$userAsso = new Association($_SESSION["USER_EMAIL"]);

if ((isset($_POST['nomAssociation']) && !empty($_POST['nomAssociation']))
    && (isset($_POST['descAssociation']) && !empty($_POST['descAssociation']))
    && (isset($_POST['emailAssociation']) && !empty($_POST['emailAssociation']))
    && (isset($_POST['telAssociation']) && !empty($_POST['telAssociation']))){

    $associationUpdateMessage =  $userAsso->updateProfile($_POST["telAssociation"], $_POST["descAssociation"], $_POST["emailAssociation"], $_POST["nomAssociation"]);

}

$userAsso = new Association($_SESSION["USER_EMAIL"]);
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
    <link rel="stylesheet" href="css/profilAssociation.css" type="text/css" />
    <link rel="stylesheet" href="css/_top_menu.css" type="text/css" />
    <title>Profil Association</title>
</head>

<body>
<!-- Menu -->

<?php require_once("_top_menu.php"); ?>

<!-- Code de la page -->

<h2>Profil Association</h2>

<!-- Les formulaires -->
<div class="container" id="formDonhum">
    <form method="post" action="" >
    <?php if (isset($associationUpdateMessage) && !empty($associationUpdateMessage)){ ?>
            <div class="alert alert-secondary" role="alert"><?php echo $associationUpdateMessage; ?></div>
            <?php } ?>
        <div class="formulaireInscriptionAssociation">
            <div class="form-group left">
                <label for="RNAAssociation">RNA</label>
                <input class="form-control formControl" name="RNAAssociation" id="RNAAssociation" type="text" value="<?php echo $userAsso->RNA;?>" disabled>
            </div>
            <div class="form-group left space">
                <label for="nomAssociation">Nom de l'Association</label>
                <input class="form-control formControl" name="nomAssociation" id="nomAssociation" type="text" value="<?php echo $userAsso->nomAsso;?>">
            </div>
            <div class="clear"></div>
            <div class="form-group left">
                <label for="emailAssociation">E-mail</label>
                <input class="form-control formControl" name="emailAssociation" id="emailAssociation" type="email" value="<?php echo $userAsso->emailAsso;?>">
            </div>
            <div class="form-group left space">
                <label for="telAssociation">Numéro de téléphone</label>
                <input class="form-control formControl" name="telAssociation" id="telAssociation" type="tel" value="<?php echo $userAsso->numTelAsso;?>">
            </div>
            <div class="clear"></div>
            <div class="form-group desc">
                <label for="descAssociation">Description</label>
                <textarea class="form-control formControl" name="descAssociation" id="descAssociation" rows="5" ><?php echo $userAsso->descAsso;?></textarea>
            </div>
        </div>
        <div>
            <button class="btn btn-primary classButtonForm buttonModifier" type="submit">Valider</button>
        </div>
    </form>
</div>
</body>
<footer></footer>
</html>