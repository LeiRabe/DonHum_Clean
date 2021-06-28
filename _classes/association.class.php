<?php

class Association{

    public $idAsso;
    public $emailAsso;
    public $mdpAsso;
    public $numTelAsso;
    public $descAsso;
    public $nomAsso;
    public $RNA;

    public function __construct($emailAsso){
        $this->emailAsso = $emailAsso;
        //verification de l'existance des info en base: associationExiste($emailAsso)
        $this->loadAssociationInfos();
    }

    public static function associationExiste($email){
        $loginAssociation = DBConnect::getInstance()->prepare('SELECT idAsso FROM association WHERE emailAsso = ?');
        $loginAssociation->execute(array($email));
        return ($loginAssociation->rowCount() != 0);
    }

    public function loadAssociationInfos(){
        $loginAssociation = DBConnect::getInstance()->prepare('SELECT * FROM association WHERE emailAsso = ?');
        $loginAssociation->execute(array($this->emailAsso));
        $infoAssociation = $loginAssociation->fetch();

        $this->idAsso = $infoAssociation["idAsso"];
        $this->mdpAsso = $infoAssociation["mdpAsso"];
        $this->numTelAsso = $infoAssociation["numTelAsso"];
        $this->descAsso = $infoAssociation["descAsso"];
        $this->nomAsso = $infoAssociation["nomAsso"];
        $this->RNA = $infoAssociation["RNA"];
    }

    public function updateProfile($tel, $desc, $email, $nom){
        if(Association::associationExiste($this->emailAsso) && $this->emailAsso != $email) return USER_ALREADY_EXISTS;
        if(!Inscription::verifMail($email)) return INVALID_EMAIL;
        
        try{
            $associationUpdate = DBConnect::getInstance()->prepare('UPDATE association SET emailAsso = ?, numTelAsso = ?, descAsso = ?, nomAsso = ? WHERE emailAsso = ?');
            $associationUpdate->execute([
                $email,
                $tel,
                $desc,
                $nom,
                $this->emailAsso
            ]);
        } catch (PDOException $exception){
            // return $exception->getMessage();
            return UNEXPECTED_ERROR;
        }

        return PROFIL_UPDATED;
    }

    public static function mailFromID($id){
        $loginAssociation = DBConnect::getInstance()->prepare('SELECT emailAsso FROM association WHERE idAsso = ?');
        $loginAssociation->execute(array($id));
        $infoAssociation = $loginAssociation->fetch();

        return $infoAssociation["emailAsso"];
    }

    public function createNewDemande($articleName, $articleQuantite){

        $particulierInscrit = DBConnect::getInstance()->prepare('INSERT INTO besoin(idAsso, articleName, articleQuantite) VALUES(?, ?, ?)');
        $particulierInscrit->execute([
            $this->idAsso,
            $articleName,
            $articleQuantite
        ]);

        return true;
    }

    public function getAllDemandsAsso(){
        $listAllDemands = DBConnect::getInstance()->prepare('SELECT * FROM besoin WHERE idAsso = ?');
        $listAllDemands->execute(array($this->idAsso));
        $demands = $listAllDemands->fetchAll();

        return $demands;
    }

    public static function getAllDemandsAssoStatic($idAsso){
        $listAllDemands = DBConnect::getInstance()->prepare('SELECT * FROM besoin WHERE idAsso = ?');
        $listAllDemands->execute(array($idAsso));
        $demands = $listAllDemands->fetchAll();

        return $demands;
    }

    public static function getListAsso(){
        $listAllAsso = DBConnect::getInstance()->prepare('SELECT idAsso FROM association');
        $listAllAsso->execute(array());
        $listAllAssoQuery = $listAllAsso->fetchAll();
        $liste = array();
        
        foreach($listAllAssoQuery as $ID)
            array_push($liste, $ID["idAsso"]);

        return $liste;
    }

    public function deleteDemande($id){
        $deleteSpecificDemande = DBConnect::getInstance()->prepare('DELETE FROM besoin WHERE idAsso = ? and idBesoin = ?');
        $deleteSpecificDemande->execute(array($this->idAsso, $id));

        return ($deleteSpecificDemande->rowCount() > 0);
    }

    public function getProductsWaitingForValidation(){
        $waitVerif = DBConnect::getInstance()->prepare('SELECT * FROM produit WHERE productValidite = ? and productOwnerType = ? and productNewOwnerID = ?');
        $waitVerif->execute(array(DON_EN_ATTENTE_DE_VALIDATION, TYPE_ASSOCIATION, $this->idAsso));
        $verifs = $waitVerif->fetchAll();

        return $verifs;
    }

    public function countDonBesoin($besoinID){
        $countDonBesoin = DBConnect::getInstance()->prepare('SELECT * FROM produit WHERE productBesoinID = ? and productValidite = ? and productOwnerType = ? and productNewOwnerID = ?');
        $countDonBesoin->execute(array($besoinID, DON_VALIDE, TYPE_ASSOCIATION, $this->idAsso));

        return $countDonBesoin->rowCount();
    }

    public function isProductDonatedToMe($productID){
        if(Produit::productExist($productID)){
            $produit = new Produit($productID);
            return ($produit->productNewOwnerID && $this->idAsso && $produit->productValidite != DON_DISPONIBLE);
        }
        return false;
    }

    public function validateDon($itemID){
        if(!$this->isProductDonatedToMe($itemID))
            return false;

        try{
            $particulierUpdate = DBConnect::getInstance()->prepare('UPDATE produit SET productValidite = ? WHERE productID = ?');
            $particulierUpdate->execute([
                DON_VALIDE,
                $itemID
            ]);
        } catch (PDOException $exception){
            //return $exception->getMessage();
            return false;
        }

        return true;
    }

    public function rejectDon($itemID){
        if(!$this->isProductDonatedToMe($itemID))
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

    public function askForProduct($productID, $besoinID){
        $produit = new Produit($productID);

        try{
            $particulierUpdate = DBConnect::getInstance()->prepare('UPDATE produit SET productValidite = ?, productOwnerType = ?, productNewOwnerID = ?, productBesoinID = ? WHERE productID = ?');
            $particulierUpdate->execute([
                DON_ASK_FOR,
                TYPE_ASSOCIATION,
                $this->idAsso,
                $besoinID,
                $productID
            ]);
        } catch (PDOException $exception){
            //return $exception->getMessage();
            return false;
        }

        return true;
    }
}