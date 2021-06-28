<?php
require_once("_classes/_config.php");
require_once("_classes/inscription.class.php");


//verification des settings dans les inputs
if ((isset($_POST["nomParticulier"]) && !empty($_POST["nomParticulier"]))
    && (isset($_POST["prenomParticulier"]) && !empty($_POST["prenomParticulier"]))
    && (isset($_POST["telParticulier"]) && !empty($_POST["telParticulier"]))
    && (isset($_POST["mdpParticulierVerification"]) && !empty($_POST["mdpParticulierVerification"]))
    && (isset($_POST["descParticulier"]) && !empty($_POST["descParticulier"]))
    && (isset($_POST['mdpParticulierVerification']) && !empty($_POST['mdpParticulierVerification']))) {

    //insertion des éléments dans la base
    $particulierInscrit = new Inscription($_POST["telParticulier"], $_POST["descParticulier"], $_SESSION["register_user_email"], $_POST["nomParticulier"], $_POST["prenomParticulier"], $_POST["mdpParticulier"]);

    $displaySuccess = $particulierInscrit->inscriptionUtilisateur(TYPE_PARTICULIER);

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
    <link rel="icon" type="image/png" href="../img/logoDonhum.png" />
    <link rel="stylesheet" href="../css/inscriptionParticulier.css"/>
		<link rel="stylesheet" href="css/_top_menu.css" />
    <title>Inscription Particulier</title>
</head>
<body>
<!-- Menu -->

<?php require_once("_top_menu.php"); ?>

<!-- Code de la page -->

<h2>Création de votre compte Particulier</h2>

<!-- Les formulaires -->
<div id="formDonhum" class="container">
    <form method="post" action="inscriptionParticulier.php">
        <?php if (isset($displaySuccess) && !empty($displaySuccess)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $displaySuccess; ?></div>
        <?php if (isset($displayErrorRegister) && !empty($displayErrorRegister)){ ?>
        <div class="alert alert-secondary" role="alert"><?php echo $displayErrorRegister; ?>
            <?php } ?>
            <?php } ?>

            <div class="formulaireInscriptionAssociation">
                <div class="form-group left">
                    <label for="nomParticulier">Nom</label>
                    <input type="text" name="nomParticulier" class="form-control formControl" id="nomParticulier"
                           placeholder="Donhum">
                </div>
                <div class="form-group left space">
                    <label for="prenomParticulier">Prénom</label>
                    <input type="text" name="prenomParticulier" class="form-control formControl" id="prenomParticulier"
                           placeholder="Donhum">
                </div>
                <div class="clear"></div>
                <div class="form-group, left">
                    <label for="emailParticulier">E-mail</label>
                    <input type="email" name="emailParticulier" class="form-control formControl" id="emailParticulier"
                           value=<?php echo $_SESSION["register_user_email"];
                           ?>
                    >
                </div>
                <div class="form-group left space">
                    <label for="telParticulier">Numéro de téléphone</label>
                    <input type="tel" name="telParticulier" class="form-control formControl" id="telParticulier"
                           placeholder="0112345678">
                </div>
                <div class="clear"></div>
                <div class="form-group left">
                    <label for="mdpParticulier">Mot de passe</label>
                    <input type="password" name="mdpParticulier" class="form-control formControl" id="mdpParticulier"
                           placeholder="c'est Secret !">
                </div>
                <div class="form-group left space">
                    <label for="mdpParticulierVerification">Vérification du Mot de passe</label>
                    <input type="password" name="mdpParticulierVerification" class="form-control formControl"
                           id="mdpParticulierVerification" placeholder="c'est aussi Secret !">
                </div>
                <div class="clear"></div>
                <div class="form-group desc">
                    <label for="descParticulier">Description</label>
                    <textarea rows="5" class="form-control formControl" name="descParticulier" id="descParticulier"
                              placeholder="Présentez-vous (localisation, motivations, produits proposés, etc.)"></textarea>
                </div>
            </div>
            <div>
                <a class="btn btn-primary classButtonForm buttonAnnuler" href="./connexion.html">Annuler</a>
                <button type="submit" name="btnConnexion" class="btn btn-primary classButtonForm buttonCreer">Créer
                </button>
            </div>
    </form>
</div>
</body>
<footer></footer>
</html>