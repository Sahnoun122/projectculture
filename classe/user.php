<?php
require_once './../config/db.php';

class User{
    protected int $id_user;
    protected string  $nom;
    protected string $prenom;
    protected string $email;
    protected string $Motdepasse;
    protected string $role;
    protected $DbConnection ;


    public function __construct($role){
        $this->role = $role;
        $this->DbConnection= new  DbConnection(); 
    }



    // GETTERS
    public function getIduser():int{
        return $this->id_user;
    }
    public function getNom():string{
        return $this->nom;
    } 
    public function getPrenom():string{
        return $this->prenom;
    } 

    public function getEmail():string{
        return $this->email;
    } 
    public function getPassword():string{
        return $this->Motdepasse;
    }
    public function getRole():string{
        return $this->role;
    }

    
    


    //SETTERS
    public function setNom(string $nom):void{
        $this->nom = $nom;
    }
    public function setPrenom(string $prenom):void{
        $this->prenom = $prenom;
    }
 
    public function setEmail(string $email):void{
        $this->email = $email;
    }
    public function setPassword(string $Motdepasse):void{
        $this->Motdepasse = password_hash($Motdepasse,PASSWORD_DEFAULT);
    }






    // GET USER INFOS
    
    public function profile($id_user) {
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