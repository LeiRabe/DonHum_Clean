<?php
session_start();

const DB_HOST = "127.0.0.1";
const DB_NAME = "don'hum_v2";
const DB_USER = "root";
const DB_PASS = "";

// Mysql connection class
class DBConnect{
        public static $BDD;

        public static function getInstance(){
                if(self::$BDD == null){
                try{
                        self::$BDD = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME .';charset=utf8', DB_USER, DB_PASS);
                        self::$BDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        self::$BDD->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                } catch(Exception $e){return null;}
                }
                return self::$BDD;
        }
}

//invocation des classes
require_once("inscription.class.php");
require_once("particulier.class.php");
require_once("association.class.php");
require_once("connexion.class.php");
require_once("produit.class.php");
require_once("upload.class.php");

// Langues
require_once("_languages/fr.php");

//Constantes
const MAX_DEMANDE = 30;
const TYPE_ASSOCIATION = "association";
const TYPE_PARTICULIER = "particulier";
const UPLOAD_FOLDER = "_uploads/";

const DON_DISPONIBLE = 0;
const DON_EN_ATTENTE_DE_VALIDATION = 1;
const DON_VALIDE = 2;
const DON_ASK_FOR = 3;