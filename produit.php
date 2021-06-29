<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"])){
  header("Location: index.php");
}

if(!isset($_GET["id"]) || !is_numeric($_GET["id"])) header("Location: listeArticlesParticulier.php");

if(!Produit::productExist($_GET["id"])) header("Location: listeArticlesParticulier.php");

$produit = new Produit($_GET["id"]);

if($_SESSION["USER_TYPE"] == TYPE_PARTICULIER)
    $connectedUser = new Particulier($_SESSION["USER_EMAIL"]);
else
    $connectedUser = new Association($_SESSION["USER_EMAIL"]);

if(isset($_POST["askArticle"])){
    $besoinID = 0;
    if(isset($_POST["besoinID"]) && is_numeric($_POST["besoinID"]))
        $besoinID = $_POST["besoinID"];

    if($connectedUser->askForProduct($produit->productID, $besoinID))
        $askArticleMessage = ASK_ASKED;
    else
        $askArticleMessage = UNEXPECTED_ERROR;
}

if(isset($_POST["deleteArticle"])){
    if($connectedUser->deleteArticle($produit->productID)){
        $deleteArticleMessage = ITEM_DELETED;
        header("Location: listeArticlesParticulier.php");
    }
    else
        $deleteArticleMessage = UNEXPECTED_ERROR;
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
    <link rel="stylesheet" href="css/produitParticulier.css" type="text/css" />
    <link rel="stylesheet" href="css/_top_menu.css" type="text/css" />
    <title>Produit</title>
</head>

<body>
<!-- Menu -->

<?php require_once("_top_menu.php"); ?>

<!-- Code de la page -->

<h2>Produit</h2>

<!-- Les formulaires -->
<div class="container" id="formDonhum">

        <?php if (isset($askArticleMessage) && !empty($askArticleMessage)){ ?>
            <div class="alert alert-secondary" role="alert"><?php echo $askArticleMessage; ?></div>
		<?php } ?>

        <?php if (isset($deleteArticleMessage) && !empty($deleteArticleMessage)){ ?>
            <div class="alert alert-secondary" role="alert"><?php echo $deleteArticleMessage; ?></div>
		<?php } ?>

        <!-- traitement d'image-->    
        <div id="trtImg">
            <!-- agrandir l'image cliquée -->
            <div class="grdImg">
              <img id="expandedImg" src="<?php echo UPLOAD_FOLDER.$produit->productImage;?>">
              <div id="imgtext"></div>
            </div>
        </div>

        <div class="produitParticulier">
            <div class="form-group">
                <label for="intituleProduit">Intitulé</label>
                <input class="form-control formControl" name="intituleArticle" id="intituleArticle" type="text" value="<?php echo $produit->productName;?>" disabled>
            </div>
            <div class="form-group desc">
                <label for="descArticle">Description</label>
                <textarea class="form-control formControl" name="descArticle" id="descArticle" rows="5" disabled><?php echo $produit->productDesc;?></textarea>
            </div>
            <div class="form-group">
                <!--<label for="motsClesProduit">Mots-clés</label>-->
                <div id='motsClesZone'>                    
                    <!-- Champs caché qui regroupe tous les mots clés séparés par un espace -->
                    <input class="form-control formControl" name="listeMotsCles" id="listeMotsCles" type="text" value="<?php echo $produit->productKeywords;?>" disabled hidden>
                </div>
            </div>
            <?php
            $userPar = new Particulier(Particulier::mailFromID($produit->idPar)); ?>
            <p>Mis en offre par <a href="listeArticlesParticulier.php?id=<?php echo $produit->idPar; ?>"><?php echo $userPar->nomPar.' '.$userPar->prenomPar;?></a></p>
        </div>
        <div id="boutonsForm">

        <?php 
        if($_SESSION["USER_TYPE"] == TYPE_PARTICULIER && $userPar->idPar == $connectedUser->idPar){ ?>
             <form action="" method="POST">
                <button class="btn btn-secondary classButtonForm buttonModifier" style="background-color: red;" type="submit" name="deleteArticle">Supprimer l'article</button>
            </form>
        <?php } else { ?>
            <form action="" method="POST">
            <?php if($_SESSION["USER_TYPE"] == TYPE_ASSOCIATION){ ?>
                <select name="besoinID">
                    <?php 
                    $userAsso = new Association($_SESSION["USER_EMAIL"]);
                    foreach($userAsso->getAllDemandsAsso() as $demand){ ?>
                        <option value="<?php echo $demand["idBesoin"];?>"><?php echo $demand["articleName"];?></option>
                    <?php } ?>
                </select>
            <?php } ?>
                <button class="btn btn-primary classButtonForm buttonModifier" type="submit" name="askArticle">Demander l'article</button>
            </form>
        <?php } ?>
        </div>
</div>
</body>
<footer></footer>
</html>