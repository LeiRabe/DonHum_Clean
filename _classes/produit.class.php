<?php

class Produit{

    public $productID;
    public $idPar;
    public $productName;
    public $productDesc;
    public $productImage;
    public $productKeywords;
    public $productValidite;
    public $productOwnerType;
    public $productNewOwnerID;

    public function __construct($productID){
        $this->productID = $productID;

        if(Produit::productExist($productID)) $this->loadProductInfos();
    }

    public function loadProductInfos(){
        $productLoad = DBConnect::getInstance()->prepare('SELECT * FROM produit WHERE productID = ?');
        $productLoad->execute(array($this->productID));
        $infoProduct = $productLoad->fetch();

        $this->productName = $infoProduct["productName"];
        $this->idPar = $infoProduct["idPar"];
        $this->productDesc = $infoProduct["productDesc"];
        $this->productImage = $infoProduct["productImage"];
        $this->productKeywords = $infoProduct["productKeywords"];
        $this->productValidite = $infoProduct["productValidite"];
        $this->productOwnerType = $infoProduct["productOwnerType"];
        $this->productNewOwnerID = $infoProduct["productNewOwnerID"];
    }

    public static function productExist($id){
        $productExist = DBConnect::getInstance()->prepare('SELECT idPar FROM produit WHERE productID = ?');
        $productExist->execute(array($id));

        return ($productExist->rowCount() != 0);
    }
    public static function addProduct($idPar, $prodImage, $prodName, $prodDesc, $prodKeywords){

        $uploadFile = new Upload($prodImage);
        if(!$uploadFile->upload()) {
            var_dump($uploadFile->getError());
            return false;
        }
       
        try{
            $addProduct = DBConnect::getInstance()->prepare('INSERT INTO produit(idPar, productImage, productName, productDesc, productKeywords) VALUES(?,?,?,?,?)');
            $addProduct->execute([
                $idPar,
                $uploadFile->FILE_UPLOAD_NAME,
                $prodName,
                $prodDesc,
                $prodKeywords
            ]);
        } catch(Exception $e) { return false; }

        return true;
    }

    public static function getLatestProducts($from, $to){
        $listProductRequest = DBConnect::getInstance()->prepare('SELECT * FROM produit WHERE productValidite = ? ORDER BY productID DESC LIMIT '. intval($from). ','. intval($to));
        $listProductRequest->execute(array(DON_DISPONIBLE));
        $listProduct = $listProductRequest->fetchAll();

        return $listProduct;
    }

    public static function searchProducts($term, $from, $to){
        $searchQuery = '%'.$term.'%';

        $listProductRequest = DBConnect::getInstance()->prepare('SELECT * FROM produit WHERE productValidite = ? and (productName LIKE ? or productDesc LIKE ? or ProductKeywords LIKE ?) ORDER BY productID DESC LIMIT '. intval($from). ','. intval($to));
        $listProductRequest->execute(array(DON_DISPONIBLE, $searchQuery, $searchQuery, $searchQuery));
        $listProduct = $listProductRequest->fetchAll();

        return $listProduct;
    }
}