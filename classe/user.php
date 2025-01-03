<?php

require_once '../database/db.php';

class User{
    
    protected  $id_user;
    protected   $nom;
    protected $prenom;
    protected $email;
    protected  $Motdepasse;
    protected PDO $role;
    protected $DbConnection ;


   
        public function __construct(PDO $pdo) {
            $this->role = $pdo;
        }
    



    public function getIduser(){
        return $this->id_user;
    }
    public function getNom(){
        return $this->nom;
    } 
    public function getPrenom(){
        return $this->prenom;
    } 

    public function getEmail(){
        return $this->email;
    } 
    public function getPassword(){
        return $this->Motdepasse;
    }
    public function getRole(){
        return $this->role;
    }

    
    


    public function setNom( $nom){
        $this->nom = $nom;
    }
    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }
 
    public function setEmail( $email){
        $this->email = $email;
    }
    public function setPassword( $Motdepasse){
        $this->Motdepasse = password_hash($Motdepasse,PASSWORD_DEFAULT);
    }






    
    public function user($id_user) {
        try{
            $stmt = $this->DbConnection->getConnection()->prepare("SELECT * FROM user WHERE id_user = :id_user");
        
            $stmt->bindValue(":id_user", (int)$id_user, PDO::PARAM_INT); 
        
            $stmt->execute();
        
            $result = $stmt->fetch(PDO::FETCH_ASSOC); 
        
            return $result;
            
        } catch (PDOException $e) {
            return "Erreur lors de la Récupération des Données". $e->getMessage();
        }
    }
}