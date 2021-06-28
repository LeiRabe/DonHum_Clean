<?php

class Inscription{

    private $email;
    private $tel;
    private $desc;
    private $nom;
    private $prenomOuRNA;
    private $mdp;

    public function __construct(string $tel, string $desc, string $email, string $nom, string $prenomOuRNA, string $mdp)
    {
        $this->email = $email;
        $this->mdp = $mdp;
        $this->tel = $tel;
        $this->desc = $desc;
        $this->nom = $nom;
        $this->prenomOuRNA = $prenomOuRNA;
    }

    function inscriptionUtilisateur($type){
        if($type == TYPE_PARTICULIER){
            // On vérifie les champs
            if(Particulier::particulierExiste($this->email)) return USER_ALREADY_EXISTS;
            if(!Inscription::verifMail($this->email)) return INVALID_EMAIL;
            if(!Inscription::verifTailleMdp($this->mdp)) return PASS_TOO_SHORT;
            if(!Inscription::verifCorresMdp($_POST["mdpParticulierVerification"],$this->mdp)) return PASS_DIFFERENT;
            
            try{
                $particulierInscrit = DBConnect::getInstance()->prepare('INSERT INTO particulier(emailPar,numTelPar,mdpPar,descPar,nomPar,prenomPar,cptDmd) VALUES(?,?,?,?,?,?,?)');
                $particulierInscrit->execute([
                    $this->email,
                    $this->tel,
                    md5($this->mdp),
                    $this->desc,
                    strtoupper($this->nom),
                    $this->prenomOuRNA,
                    MAX_DEMANDE
                ]);
            } catch (PDOException $exception){
                // return $exception->getMessage();
                return UNEXPECTED_ERROR;
            }

            return REGISTER_SUCCESS;
        }
        elseif ($type == TYPE_ASSOCIATION){
            // On vérifie les champs
            if(Association::associationExiste($this->email)) return USER_ALREADY_EXISTS;
            if(!Inscription::verifMail($this->email)) return INVALID_EMAIL;
            if(!Inscription::verifTailleMdp($this->mdp)) return PASS_TOO_SHORT;
            if(!Inscription::verifCorresMdp($_POST["mdpAssociationVerification"],$this->mdp)) return PASS_DIFFERENT;

            try {
                $associationInscrit = DBConnect::getInstance()->prepare( 'INSERT INTO association(emailAsso,numTelAsso,mdpAsso,descAsso,nomAsso,RNA) VALUES(?,?,?,?,?,?)' );
                $associationInscrit->execute([
                    $this->email,
                    $this->tel,
                    md5($this->mdp),
                    $this->desc,
                    strtoupper($this->nom),
                    $this->prenomOuRNA
                ]);
            } catch (PDOException $exception){
                // return $exception->getMessage();
                return UNEXPECTED_ERROR;
            }

            return REGISTER_SUCCESS;
        }
    }

    //vérifier que le mot de passe n'est pas trop court
    public static function verifTailleMdp($mdp){
        if(strlen($mdp) < 8)
            return false;
        return true;
    }

    //vérifier que l'email est valide
    public static function verifMail($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            return false;
        return true;
    }

    //vérifier que le mot de passe de vérification correspond au premier mdp
    public static function  verifCorresMdp($mdpVerif,$mdp){
        if($mdpVerif!=$mdp)
            return false;
        return true;
    }
}