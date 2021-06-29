<?php
require_once("_classes/_config.php");

//verification des settings dans les inputs
if ((isset($_SESSION['register_user_email']) && !empty($_SESSION['register_user_email']))
    && (isset($_POST['nomAssociation']) && !empty($_POST['nomAssociation']))
    && (isset($_POST['mdpAssociation']) && !empty($_POST['mdpAssociation']))
    && (isset($_POST['descAssociation']) && !empty($_POST['descAssociation']))
    && (isset($_POST['telAssociation']) && !empty($_POST['telAssociation']))
    && (isset($_POST['RNAAssociation']) && !empty($_POST['RNAAssociation']))
    && (isset($_POST['mdpAssociationVerification']) && !empty($_POST['mdpAssociationVerification']))){

    $associationInscrit = new Inscription($_POST["telAssociation"], $_POST["descAssociation"],$_SESSION["register_user_email"], $_POST["nomAssociation"], $_POST["RNAAssociation"], $_POST["mdpAssociation"]);
    $displaySuccess = $associationInscrit->inscriptionUtilisateur(TYPE_ASSOCIATION);
}

?>

<script type="text/JavaScript">
    function setNomAssoFromRNA(){
        var xmlHttp = null;
        var url = "https://entreprise.data.gouv.fr/api/rna/v1/id/"
        var RNA = document.getElementById('RNAAssociation').value;
        xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "GET", url + RNA, false );
        xmlHttp.send( null );

        if(xmlHttp.status == 200)
            //document.getElementById('nomAssociation').value = JSON.parse(xmlHttp.responseText)["association"]["titre"];
        document.getElementById('nomAssociation').value = JSON.parse(xmlHttp.responseText)["association"]["titre"];
        else
            alert("NO RNA");
    }
    function setDescAssoFromRNA(){
        var xmlHttp = null;
        var url = "https://entreprise.data.gouv.fr/api/rna/v1/id/"
        var RNA = document.getElementById('RNAAssociation').value;
        xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "GET", url + RNA, false );
        xmlHttp.send( null );

        if(xmlHttp.status == 200)
            document.querySelector('#descAssociation').value = JSON.parse(xmlHttp.responseText)["association"]["objet"];
        else
            alert("Il faut que vous fournissiez le RNA");
    }
</script>

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
    <link rel="stylesheet" href="css/inscriptionAssociation.css" type="text/css" />
	<link rel="stylesheet" href="css/_top_menu.css" />
    <title>Inscription Association</title>
</head>

<body>
<!-- Menu -->

<?php require_once("_top_menu.php"); ?>

<!-- Code de la page -->

<h2 class='titlePage'>Création de votre compte Association</h2>

<!-- Les formulaires -->
<div class="container" id="formDonhum">
    <form method="post" action="inscriptionAssociation.php">
        <?php if (isset($displaySuccess) && !empty($displaySuccess)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $displaySuccess; ?></div>
        <?php if (isset($displayErrorRegister) && !empty($displayErrorRegister)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $displayErrorRegister; ?>
            <?php } ?>
            <?php } ?>
        <div class="formulaireInscriptionAssociation">
            <div class="form-group left">
                <label for="RNAAssociation">RNA</label>
                <input class="form-control formControl" name="RNAAssociation" id="RNAAssociation" placeholder="W123aVotreService" type="text" required>
            </div>
                <a class="btn btn-primary classButtonForm buttonRNA" onclick="setNomAssoFromRNA();setDescAssoFromRNA();" >Vérifier RNA</a>
            <div class="form-group ">
                <label for="nomAssociation">Nom de l'Association</label>
                <input class="form-control formControl" name="nomAssociation" id="nomAssociation" placeholder="Donhum" type="text" readonly>
            </div>
            <div class="clear"></div>
            <div class="form-group left">
                <label for="emailAssociation">E-mail</label>
                <input class="form-control formControl" name="emailAssociation" id="emailAssociation" placeholder="donhum@contact.fr"
                       type="email" required value=<?php echo $_SESSION["register_user_email"];
                ?>>
            </div>
            <div class="form-group left space">
                <label for="telAssociation">Numéro de téléphone</label>
                <input class="form-control formControl" name="telAssociation" id="telAssociation" placeholder="0112345678" type="tel" required>
            </div>
            <div class="clear"></div>
            <div class="form-group left">
                <label for="mdpAssociation">Mot de passe</label>
                <input class="form-control formControl" name="mdpAssociation" id="mdpAssociation" placeholder="c'est Secret !"
                       type="password" required>
            </div>
            <div class="form-group left space">
                <label for="mdpAssociationVerification">Vérification du Mot de passe</label>
                <input class="form-control formControl" name="mdpAssociationVerification" id="mdpAssociationVerification" placeholder="c'est aussi Secret !"
                       type="password" required>
            </div>
            <div class="clear"></div>
            <div class="form-group desc">
                <label for="descAssociation">Description</label>
                <textarea class="form-control formControl" name="descAssociation" id="descAssociation" placeholder="Présentez-vous (localisation, objectif, date de création, etc.)"
                          rows="5" required></textarea>
            </div>
        </div>
        <div>
            <a class="btn btn-primary classButtonForm buttonAnnuler" href="./connexion.html">Annuler</a>
            <button class="btn btn-primary classButtonForm buttonCreer" type="submit">Créer</button>
        </div>
    </form>
</div>
</body>
<footer></footer>
</html>