<?php

class Particulier{

    public $idPar;
    public $produitPart;
    public $emailPar;
    public $telPar;
    public $descPar;
    public $nomPar;
    public $prenomPar;
    public $cptDmd;

    public function __construct($email){
        $this->emailPar = $email;
        if(Particulier::particulierExiste($email)) $this->loadParticulierInfos();
    }

    public static function particulierExiste($email){
        $loginParticulier = DBConnect::getInstance()->prepare('SELECT idPar FROM particulier WHERE emailPar = ?');
        $loginParticulier->execute(array($email));

        return ($loginParticulier->rowCount() != 0);
    }

    public function loadParticulierInfos(){
        $loginParticulier = DBConnect::getInstance()->prepare('SELECT * FROM particulier WHERE emailPar = ?');
        $loginParticulier->execute(array($this->emailPar));
        $infoParticulier = $loginParticulier->fetch();

        $this->idPar = $infoParticulier["idPar"];
        $this->descPar = $infoParticulier["descPar"];
        $this->telPar = $infoParticulier["numTelPar"];
        $this->nomPar = $infoParticulier["nomPar"];
        $this->prenomPar = $infoParticulier["prenomPar"];
        $this->cptDmd = $infoParticulier["cptDmd"];
    }

    public function updateProfile($tel, $desc, $email, $nom, $prenom){
            if(Particulier::particulierExiste($this->emailPar) && $this->emailPar != $email) return USER_ALREADY_EXISTS;
            if(!Inscription::verifMail($email)) return INVALID_EMAIL;
            
            try{
                $particulierUpdate = DBConnect::getInstance()->prepare('UPDATE particulier SET emailPar = ?, numTelPar = ?, descPar = ?, nomPar = ?, prenomPar = ? WHERE emailPar = ?');
                $particulierUpdate->execute([
                    $email,
                    $tel,
                    $desc,
                    $nom,
                    $prenom,
                    $this->emailPar
                ]);
            } catch (PDOException $exception){
                //return $exception->getMessage();
                return UNEXPECTED_ERROR;
            }

            return PROFIL_UPDATED;
    }

    public static function mailFromID($id){
        $loginParticulier = DBConnect::getInstance()->prepare('SELECT emailPar FROM particulier WHERE idPar = ?');
        $loginParticulier->execute(array($id));
        $infoParticulier = $loginParticulier->fetch();

        return $infoParticulier["emailPar"];
    }

    public function getProductList(){
        $listProductRequest = DBConnect::getInstance()->prepare('SELECT * FROM produit WHERE idPar = ? AND productValidite = ? ORDER BY productID DESC');
        $listProductRequest->execute(array($this->idPar, DON_DISPONIBLE));
        $listProduct = $listProductRequest->fetchAll();

        return $listProduct;
    }

    public function produitIsMine($productID){
        if(Produit::productExist($productID)){
            $produit = new Produit($productID);
            return ($produit->idPar && $this->idPar && ($produit->productValidite == DON_DISPONIBLE || $produit->productValidite == DON_ASK_FOR));
        }
        return false;
    }

    public function giveProduit($itemID, $newOwnerID, $user_type, $besoinID){
        if(!$this->produitIsMine($itemID))
            return false;

            try{
                $particulierUpdate = DBConnect::getInstance()->prepare('UPDATE produit SET productValidite = ?, productOwnerType = ?, productNewOwnerID = ?, productBesoinID = ? WHERE productID = ?');
                $particulierUpdate->execute([
                    DON_EN_ATTENTE_DE_VALIDATION,
                    $user_type,
                    $newOwnerID,
                    $besoinID,
                    $itemID
                ]);
            } catch (PDOException $exception){
                //return $exception->getMessage();
                return false;
            }

        return true;
    }

    public function askForProduct($productID){
        $produit = new Produit($productID);

        try{
            $particulierUpdate = DBConnect::getInstance()->prepare('UPDATE produit SET productValidite = ?, productOwnerType = ?, productNewOwnerID = ?, productBesoinID = ? WHERE productID = ?');
            $particulierUpdate->execute([
                DON_ASK_FOR,
                TYPE_PARTICULIER,
                $this->idPar,
                0,
                $productID
            ]);
        } catch (PDOException $exception){
            //return $exception->getMessage();
            return false;
        }

        return true;
    }

    public function validateDon($itemID){
        if(!$this->produitIsMine($itemID))
            return false;

        $produit = new Produit($itemID);
        $productIDPar = $produit->idPar;
        $productNewOwnerType = $produit->productOwnerType;
        $productIDNewOwner = $produit->productNewOwnerID;
        try{
            if($productNewOwnerType == TYPE_PARTICULIER){
                $particulierUpdate = DBConnect::getInstance()->prepare('UPDATE produit SET idPar = ?, productValidite = ?, productOwnerType = ?, productNewOwnerID = ?, productBesoinID = ? WHERE productID = ?');
                $particulierUpdate->execute([
                    $productIDNewOwner,
                    DON_DISPONIBLE,
                    null,
                    null,
                    null,
                    $itemID
                ]);
            } else {
                $particulierUpdate = DBConnect::getInstance()->prepare('UPDATE produit SET productValidite = ? WHERE productID = ?');
                $particulierUpdate->execute([
                    DON_VALIDE,
                    $itemID
                ]);
            }
        } catch (PDOException $exception){
            //return $exception->getMessage();
            var_dump($exception->getMessage());
            return false;
        }

        return true;
    }

    public function rejectDon($itemID){
        if(!$this->produitIsMine($itemID))
            return false;

        try{
            $particulierUpdate = DBConnect::getInstance()->prepare('UPDATE produit SET productValidite = ?, productOwnerType = ?, productNewOwnerID = ?, productBesoinID = ? WHERE productID = ?');
            $particulierUpdate->execute([
                DON_DISPONIBLE,
                null,
                null,
                null,
                $itemID
            ]);
        } catch (PDOException $exception){
            //return $exception->getMessage();
            return false;
        }

        return true;
    }

    public function getProductsWaitingForValidation(){
        $waitVerif = DBConnect::getInstance()->prepare('SELECT * FROM produit WHERE productValidite = ? and idPar = ?');
        $waitVerif->execute(array(DON_ASK_FOR, $this->idPar));
        $verifs = $waitVerif->fetchAll();

        return $verifs;
    }

    public function getNBProductsWaitingForValidation(){
        $waitVerif = DBConnect::getInstance()->prepare('SELECT * FROM produit WHERE productValidite = ? and idPar = ?');
        $waitVerif->execute(array(DON_ASK_FOR, $this->idPar));

        return $waitVerif->rowCount();
    }

    public function deleteArticle($itemID){
        if(!$this->produitIsMine($itemID))
            return false;

        $deleteArticle = DBConnect::getInstance()->prepare('DELETE FROM produit WHERE idPar = ? and productValidite = ? and productID = ?');
        $deleteArticle->execute(array($this->idPar, DON_DISPONIBLE, $itemID));

        return true;
    }
}