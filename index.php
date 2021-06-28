<?php
require_once("_classes/_config.php");

if(isset($_GET["disconnect"])){ 
    session_destroy(); 
    header("Location: index.php");
}
//connexion particulier
if(isset($_POST["btnConnection"]) && isset($_POST["emailConnexion"]) && isset($_POST["mdpConnexion"]) && isset($_POST["inlineRadioOptions"])){

    $connexionParticulier = new Connexion($_POST["emailConnexion"],$_POST["mdpConnexion"]);
    $successLogin = $connexionParticulier->Login($_POST["inlineRadioOptions"]);

    if($successLogin){
        $email = $_POST["emailConnexion"];
        $_SESSION["USER_EMAIL"]= $_POST["emailConnexion"];
        $_SESSION["USER_TYPE"]= $_POST["inlineRadioOptions"];
        if($_POST["inlineRadioOptions"] == TYPE_PARTICULIER){
            $_SESSION["USER"] = new Particulier($_POST["emailConnexion"]);
            header("Location: listeAssociation.php");
        }
        else{
            $_SESSION["USER"] = new Association($_POST["emailConnexion"]);
            header("Location: listeParticulier.php");
        }
        die();
    }
    else{
        $connexionError = LOGIN_FAILED;
    }
    
}


//Association
//récupération des variables pour transmettre aux formulaires d'inscription respectives
if(isset($_POST["btnInscription"]) && isset($_POST["emailInscription"]) && isset($_POST["inlineRadioOptions"]) && ($_POST["inlineRadioOptions"] == TYPE_ASSOCIATION || $_POST["inlineRadioOptions"] == TYPE_PARTICULIER)){
    $email = $_POST["emailInscription"];
    $_SESSION["register_user_email"] = $email;
    $_SESSION["register_user_type"] = $_POST["inlineRadioOptions"];
    if($_POST["inlineRadioOptions"] == TYPE_ASSOCIATION)
      header("Location: inscriptionAssociation.php");
    else
      header("Location: inscriptionParticulier.php");
    die();
} else {
    $displayErrorMsg = "Vous devez choisir une option";
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
		<link rel="stylesheet" href="css/connexion.css" />
		<link rel="stylesheet" href="css/_top_menu.css" />
		<title>Connexion</title>
		</head>
		<body>
		
        
        <!-- Code de la page -->

		<!-- Partie gauche de la page avec les info -->
		<div id="infoDonhum" class="container">
			<h1>Bienvenue sur Don'hum</h1>
			<img id="imgLogoDonhum" src="img/logoDonhum.png" alt="Logo de Don'hum"/>
			<h1> Favorisez l’échange en participant à la plateforme de dons simple et rapide ! </h1>
			<p> Les particuliers peuvent faire des dons aux associations et aux particuliers.</br>
				Les associations et les particuliers peuvent demander des dons.</p>
		</div>
			
		<!-- Partie droite de la page avec les formulaires -->
		<div id="formDonhum" class="container">
			<div class="formulaireAuthentification">
				<h2>Connectez-vous !</h2>
                <?php if (isset($connexionError) && !empty($connexionError)){ ?>
            <div class="alert alert-secondary" role="alert"><?php echo $connexionError; ?></div>
            <?php } ?>
        <!-- CONNEXION-->
				<form method="post" action="index.php">
				  <div class="form-group">
					<input type="email" name="emailConnexion" class="form-control" placeholder="E-mail ou Nom d'utilisateur">
				  </div>
				  <div class="form-group">
					<input type="password" class="form-control" name="mdpConnexion" placeholder="Mot de passe">
				  </div>
				  <p>Vous êtes :</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="association">
                        <label class="form-check-label" for="inlineRadio1">Association</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="particulier">
                        <label class="form-check-label" for="inlineRadio2">Particulier</label>
                    </div>
				  <div id="connexionButton">
					<button type="submit" name="btnConnection" class="btn btn-primary">Connexion</button>
					<a id="mdpOublie" href="#">Mot de passe oublié</a>
				  </div>
				</form>
			</div>
            <!-- FIN CONNEXION-->


      <!-- Création compte form -->
			<div class="formulaireAuthentification">
				<h2>Créer votre compte Don’hum</h2>
				<form method="POST" action="index.php">
					<div class="form-group">
						<input type="email" name="emailInscription" class="form-control" placeholder="E-mail">
					</div>
					<p>Vous créez un compte :</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="association">
                        <label class="form-check-label" for="inlineRadio1">Association</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="particulier">
                        <label class="form-check-label" for="inlineRadio2">Particulier</label>
                    </div>
					</br>
                    <!-- Si l'email est donné et si on a le type d'utilisateur on récupère l'email et on bascule vers la page d'inscription -->
					<button type="submit" name="btnInscription" class="btn btn-primary buttonInscription" id="buttonInscription">
                        Inscription
                    </button>
				</form>
                <!-- -->
			</div>
		</div>
	</body>
	<footer></footer>
</html>
