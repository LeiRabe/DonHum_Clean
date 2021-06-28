
  <nav class="navbar navbar-expand-md navbar-light menu">
		  <a class="navbar-brand" href="./listeAssociation.php" id="imgMenuDonhum">
			<img src="../img/menuDonhum.png" alt=""/>
		  </a>
		  
          <div id="menuButtonCat">
			<ul class="navbar-nav my-2 my-lg-0">
			  <li class="nav-item">
				  <a class="nav-link" href="./listeAssociation.php">Associations</a>
			  </li>
			  <li class="nav-item">
				  <a class="nav-link" href="./listeParticulier.php">Particuliers</a>
			  </li>

        <?php if(isset($_SESSION["USER"]) && !is_null($_SESSION["USER"])){ ?>
          <!--<li class="nav-item">
            <a class="nav-link" href="./suiviDon.php">Dons</a>
          </li>   -->
          <li class="nav-item dropdown">

            <?php if(isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == TYPE_ASSOCIATION){ 
              $menuUserAsso = new Association($_SESSION["USER_EMAIL"]);?>
              <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Mon compte (<?php echo $menuUserAsso->nomAsso; ?>)
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="./updateProfilAssociation.php">Profil</a>

            <?php } else if(isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == TYPE_PARTICULIER) { 
               $menuUserPar = new Particulier($_SESSION["USER_EMAIL"]);?>
              <a class="nav-link  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Mon compte (<?php echo $menuUserPar->nomPar; ?>) <?php if($menuUserPar->getNBProductsWaitingForValidation() > 0) { ?>
                <span style="color:white;background:red;padding-left:2px;padding-right:2px;"><?php echo $menuUserPar->getNBProductsWaitingForValidation(); ?></span>
              <?php } ?>
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="./listeArticlesParticulier.php">Articles</a>
              <a class="dropdown-item" href="./updateProfilParticulier.php">Profil</a>
            <?php } ?>

              <div class="dropdown-divider"></div> 
              <a class="dropdown-item" href="index.php?disconnect=true">Déconnexion</a>
            </div>
          </li> 
              
          <?php
          if($_SESSION["USER_TYPE"] == TYPE_PARTICULIER){ ?>
          <li class="nav-item">
            <a style="color:white;" class="nav-link btn btn-secondary" href="ajouterProduit.php">
                Ajouter un produit
            </a>
          </li> 
            <?php } else { ?>
              <li class="nav-item">
                <a style="color:white;" class="nav-link btn btn-secondary" href="besoinAssociation.php">
                Espace de don
                </a>
              </li> 
            <?php } ?>
    <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Dons</a>
          </li>   
          <li class="nav-item">
            <a class="nav-link" href="index.php" role="button">
              Connexion
            </a>
          </li> 
    <?php } ?>
			</ul>
            </div>


        <form id="formSearch" class="" method="POST" action="listeParticulier.php">
            <input class="form-control" id='inputSearch' type="search" placeholder="Rechercher" name="search" aria-label="Rechercher">
            <button id='btnSearch' class="btn btn-secondary" type="submit"><i class='fa fa-search'></i></button>
        </form>
		</nav>