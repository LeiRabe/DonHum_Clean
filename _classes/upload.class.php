<?php

//define("error_uploadTooBig", "La taille du fichier ne doit pas dépasser". UPLOAD_MAX_SIZE."Bytes");
define("error_WrongExtension", "Le format de fichier n'est pas accepté");

class Upload{
    
    public $FILE;
    public $FILE_NAME;
    public $FILE_SIZE;
    public $FILE_TMP_NAME;
    public $FILE_UPLOAD_NAME;
    public $FILE_EXTENSION;
    public $allowedExtensions;

    public $errorMessage;

    function __construct($FILE){
        $this->FILE = $FILE;
        $this->FILE_SIZE = $FILE["size"];
        $this->FILE_NAME = $FILE["name"];
        $this->FILE_TMP_NAME = $FILE["tmp_name"];
        if(!empty(pathinfo($this->FILE_NAME)["extension"]))
            $this->FILE_EXTENSION = pathinfo($this->FILE_NAME)["extension"];
        $this->allowedExtensions = ["png", "jpg", "jpeg"];
    }

    function upload(){
        /*if($this->FILE_SIZE > UPLOAD_MAX_SIZE){
            $this->errorMessage = error_uploadTooBig;
            return false;
        }*/
        if(!in_array($this->FILE_EXTENSION, $this->allowedExtensions)){
            $this->errorMessage = error_WrongExtension;
            return false;
        }
        if(empty($this->FILE_EXTENSION)){
            $this->errorMessage = error_WrongExtension;
            return false;
        }
        
        $newFileName = "upload_".$this->generateUniqueName();
        move_uploaded_file($this->FILE_TMP_NAME, UPLOAD_FOLDER.$newFileName);
        $this->FILE_UPLOAD_NAME = $newFileName;
        return true;
    }

    function generateUniqueName(){
        $newName = uniqid().uniqid();
        return $newName.".".$this->FILE_EXTENSION;
    }

    function getError(){
        $currentError = $this->errorMessage;
        $this->errorMessage = "";
        return $currentError;
    }

}