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
    <link rel="icon" type="image/png" href="../img/logoDonhum.png" />
    <link rel="stylesheet" href="css/suiviDon.css" type="text/css" />
    <title>Suivi des dons</title>
</head>

<body>
<!-- Menu -->
<nav class="navbar navbar-expand-md navbar-light menu">
		  <a class="navbar-brand" href="./listeAssociation.php">
			<img id="imgMenuDonhum" src="../img/menuDonhum.png" alt="Don'hum"/>
		  </a>
		  <button id='btnMenuCollapse' class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="collapsibleNavbar">
			<form id="formSearch" class="form-inline mx-auto" aria-readonly="true">
			  <input class="form-control" id='inputSearch' type="search" placeholder="Rechercher" aria-label="Rechercher" readonly>
			  <button id='btnSearch' class="btn btn-secondary" type="submit" aria-readonly="true"><i class='fa fa-search'></i></button>
			</form>
			
			<ul class="navbar-nav my-2 my-lg-0">
			  <li class="nav-item">
				  <a class="nav-link" href="./listeAssociation.php">Associations</a>
			  </li>
			  <li class="nav-item">
				  <a class="nav-link" href="./listeParticulier.php">Particuliers</a>
			  </li>

        <?php
                if (isset($_SESSION["email"]))
                {
        ?>
                <li class="nav-item">
                  <a class="nav-link" href="./suiviDon.php">Dons</a>
                </li>   
                <li class="nav-item dropdown">
                  <a class="nav-link btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Connexion
                  </a>

                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Articles</a>
                    <a class="dropdown-item" href="#">Profil</a>
                    <div class="dropdown-divider"></div> 
                    <a class="dropdown-item" href="#">Déconnexion</a>
                  </div>
                </li> 
                <?php
                    }
                    else
                    {
                ?>
                      <li class="nav-item">
                        <a class="nav-link" href="../index.php">Dons</a>
                      </li>   
                      <li class="nav-item">
                        <a class="nav-link" href="../index.php" role="button">
                          Connexion
                        </a>
                      </li> 
                <?php
                    }
                ?>
			</ul>
		  </div>  
		</nav>

<!-- Code de la page -->

<h2 class='titlePage'>Suivi des dons</h2>

<!-- Partie gauche : Demande en attente -->
<div id="dmdAttente">
    <h3>Demandes en attente</h3>
    <p>Cliquez sur les noms pour atteindre la page produit !</p>

    <table id='tableDemandeAttente' class='table-responsive table-hover'>
        <tbody>	
            <tr>
                <td><a id="nomArticleDemande"></a></td>
                <td id="statutDemande"></td>
            </tr>
        </tbody>				
    </table>
</div>

<!-- Partie droite : Dons proposés -->
<div id="dmdProposes">
    <h3>Dons proposés</h3>
    <p>Vous avez la main ! Acceptez ou Déclinez les offres</p>

    <table id='tableDemandeAttente' class='table-responsive table-hover'>
        <tbody>	
            <tr>
                <td><a id="nomArticleDemande"></a></td>
                <td id="accepterDemande"><i class="fa fa-check" aria-hidden="true"></i></td>
                <td id="refuserDemande"><i class="fa fa-times" aria-hidden="true"></i></td>
            </tr>
        </tbody>				
    </table>
</div>

</body>
<footer></footer>
</html>