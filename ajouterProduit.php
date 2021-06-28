<?php
require_once("_classes/_config.php");

if(!isset($_SESSION["USER_EMAIL"]) || $_SESSION["USER_TYPE"] != TYPE_PARTICULIER){
  header("Location: index.php");
}
$userPar = new Particulier($_SESSION["USER_EMAIL"]);

if ((isset($_FILES["productImage"]))
    && (isset($_POST["productKeywords"]) && !empty($_POST["productKeywords"]))
    && (isset($_POST["productDesc"]) && !empty($_POST["productDesc"]))
    && (isset($_POST["productName"]) && !empty($_POST["productName"]))) {

    $addProduct = Produit::addProduct($userPar->idPar, $_FILES["productImage"], $_POST["productName"], $_POST["productDesc"], $_POST["productKeywords"]);
    
    if(!$addProduct)
      $uploadProduitMessage = UNEXPECTED_ERROR;
    else
      header("Location: listeArticlesParticulier.php");
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
    <link rel="stylesheet" href="css/produitParticulier.css" type="text/css" />
    <link rel="stylesheet" href="css/_top_menu.css" type="text/css" />
    <title>Produit</title>

    <script type="text/JavaScript">
        cptMot = 0;
        cptImg = 0;
        function AjouterMotCle(){
          cptMot++;
          if(document.getElementById('motCleProduit').value != ""){
            //création des éléments html pour le tag
            var divMotCle = document.createElement("div");
            var pMotCle = document.createElement("p");
            var iMotCle = document.createElement("i");
            var motCle = document.getElementById('motCleProduit').value;
            
            //emboîtement des éléments pour créer le tag
            pMotCle.innerHTML = motCle;
            divMotCle.append(pMotCle,iMotCle);
            document.getElementById('motsClesTag').append(divMotCle);

            //ajout des spécifications des éléments
            divMotCle.className= "btn-group";
            divMotCle.style.margin = "O.5em";
            divMotCle.style.marginRight = "1em";
            pMotCle.className = "form-control";
            pMotCle.readOnly = true;
            pMotCle.style.display ="flex";
            pMotCle.style.flexWrap = "wrap";
            iMotCle.className = "fa fa-times";
            iMotCle.id = "croixMot"+cptMot;
            iMotCle.onclick= function(){ RemoveTagMot(this); };
            
            //remise à zéro du champs mots clés
            document.getElementById('motCleProduit').value="";

            //mise à jour du champs input mots clés du formulaire
            refreshInputMotsCles();
          }
        }

        function RemoveTagMot(croix){
          var bloc = croix.getAttribute("id");
          var blocASupprimer = document.getElementById(bloc);
          
          /*on se place au bon niveau pour supprimer le tag*/
          blocASupprimer.parentNode.parentNode.removeChild(blocASupprimer.parentNode);
          /*mise à jour de la visualisation*/
          refreshInputMotsCles();
        }

        function RemoveImg(croix){
          var bloc = croix.getAttribute("id");
          var blocASupprimer = document.getElementById(bloc);
          var srcImgSupp = blocASupprimer.parentNode.children[0].src;
          var divImgPrd = document.getElementById("imagesProduit");
          
          /*on se place au bon niveau pour supprimer l'image*/
          blocASupprimer.parentNode.parentNode.removeChild(blocASupprimer.parentNode);

          /*mise à jour de la visualisation*/
          //vérification qu'on a des images
          if(divImgPrd.children.length != 0){
            //si oui on regarde si la source de la grande image est la même que l'image supprimée
            if(document.getElementById("expandedImg").src == srcImgSupp){
              //si c'est le cas il faut modifier l'image avec la première de la liste
              //récupération de la première image ajoutée
              myFunction(divImgPrd.children[0].children[0]);

              //sinon on laisse l'image telle qu'elle
            }
          }
          //s'il n'y a plus d'images on met l'image par défaut
          else{
            var img = document.createElement("img");
            img.src="../img/aucuneImage.png";
            myFunction(img);
          }
          
          
        }
        
        //mise à jour du champs input avec les bons mots clés
        function refreshInputMotsCles(){
          //récupératio des éléments 
          var spanMotCle = document.getElementById("motsClesTag");
          var inputFinal = document.getElementById("listeMotsCles");
          //réinitialisation du champs input
          inputFinal.value = "";
          //vérification s'il y a des tag sinon on ne fait pas de traitement
          if (spanMotCle.hasChildNodes()) {
            var children = spanMotCle.childNodes;
            //mise à jour du champs d'input final
            for(var i=0; i<children.length; i++){
              inputFinal.value = inputFinal.value + " " + children[i].children[0].value;
            }
          }
        }

        function myFunction(imgs) {
          // récupération de la grande image
          var expandImg = document.getElementById("expandedImg");
          // l'image source et l'image cible ont la même source
          expandImg.src = imgs.src;
      }



        var loadFile = function(event) {
          cptImg++;
          //récupération de la div cible
          var divImg = document.getElementById('imagesProduit');

          //création du contenu avec la div qui regroupe
          //l'image et le bouton de suppression
          var divCol = document.createElement('div');
          var image = document.createElement('img');
          var iImgProd = document.createElement("i");
          //ajout d'un espace entre deux images
          var espace = document.createElement("span");        
          
          divCol.className = "column divImage"; 
          divCol.id="divCol"+cptImg;
          image.onclick = function(){ myFunction(this); };
          image.src = URL.createObjectURL(event.target.files[0]);
          image.className = "imgProduit";
          image.id="imgProduit"+cptImg;
          iImgProd.className = "fa fa-times";
          iImgProd.id = "croixImg"+cptImg;
          iImgProd.onclick= function(){ RemoveImg(this); };
          espace.style.marginRight="1em";

          //emboîtement des éléments sur la page html
          divCol.append(image, iImgProd,espace);
          divImg.append(divCol);

          //mise à jour de la grande image 
          myFunction(image);
      };


      </script>
</head>

<body>
<!-- Menu -->

<?php require_once("_top_menu.php"); ?>

<!-- Code de la page -->

<h2>Produit</h2>

<!-- Les formulaires -->
<div class="container" id="formDonhum">
    <form enctype="multipart/form-data" method="post" action="">
    <?php if (isset($uploadProduitMessage) && !empty($uploadProduitMessage)){ ?>
            <div class="alert alert-secondary" role="alert"><?php echo $uploadProduitMessage; ?></div>
            <?php } ?>
        <!-- traitement d'image-->    
        <div id="trtImg">
        <h3> Ajouter une image </h3><br/><br/>
            <!-- agrandir l'image cliquée 
            <div class="grdImg">
              <img id="expandedImg" src="../img/aucuneImage.png">
              <div id="imgtext"></div>
            </div>

            Liste des images
            <div class="row" id="imagesProduit">
            </div>-->

            <!-- ajouter une image produit -->
            <input type="file" accept="image/gif, image/jpeg, image/png" name="productImage" id="file">
            <!--<p class="btn ajoutImg"><label for="file" style="cursor: pointer;">Ajouter une image</label></p>
            <img id="output" width="200" />-->
        </div>

        <div class="produitParticulier">
            <div class="form-group">
                <label for="intituleProduit">Intitulé</label>
                <input class="form-control formControl" name="productName" id="intituleArticle" type="text">
            </div>
            <div class="form-group desc">
                <label for="descArticle">Description</label>
                <textarea class="form-control formControl" name="productDesc" id="descArticle" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="motsClesProduit">Mots-clés (séparés par une virgule)</label>
                <div id='motsClesZone'>                    
                    <!-- Champs caché qui regroupe tous les mots clés séparés par un espace -->
                    <input class="form-control formControl" name="productKeywords" id="listeMotsCles" type="text">

                    <!--mots clés sous forme d'étiquette-->
                    <span id="motsClesTag"></span>  
                    <!-- Saisie des mots clés-->
                    <!-- non autorisation des espaces -->
                    <!--<input class="form-control formControl" name="motCleProduit" id="motCleProduit" type="text" onkeydown="if(event.keyCode==32) return false;">
                    <div class=" btn btn-group btnAjouter" onclick="AjouterMotCle()">Ajouter</div>-->
                </div>
            </div>
        </div>
        <div id="boutonsForm">
            <a class="btn btn-primary classButtonForm buttonAnnuler" href="./listeArticlePart.php">Annuler</a>
            <!-- si on modifie une fiche existante, il faut avoir l'option de la supprimer et NON de l'annuler
            <a class="btn btn-primary classButtonForm buttonAnnuler" href="./listeArticlePart.html">Supprimer</a>
                  -->
            <button class="btn btn-primary classButtonForm buttonModifier" type="submit">Valider</button>
        </div>
    </form>
</div>
</body>
<footer></footer>
</html>