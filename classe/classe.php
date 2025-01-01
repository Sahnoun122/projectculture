<?php

require_once '../database/db.php';

class Auth extends DbConnection {

    public function register( $nom, $prenom, $email,$Motdepasse, $role) {
     
        try {
            $this->connection->beginTransaction();

            $role = ($role === 'admin') ? 'admin' : 'user';

            $hashedPassword = password_hash($Motdepasse, PASSWORD_BCRYPT);

            $sqlamin = "INSERT INTO user (Email,  Motdepasse, Role) VALUES (:Email, : Motdepasse, :role)";
            $stmtadmin = $this->connection->prepare($sqlamin );
            $stmtadmin->execute([
                ':Email' => $email,
                ':Motdepasse' => $hashedPassword,
                ':role' => $role
            ]);

            $userId = $this->connection->lastInsertId();

            if ($role === 'user') {
                $sqluser = "INSERT INTO user (id_user, Nom, Prenom, Email) VALUES (:id_user, :Nom, Prenom, :Email)";
                $stmtuser = $this->connection->prepare($sqluser );
                $stmtuser->execute([
                    ':id_user' => $userId,
                    ':Nom' => $nom,
                    ':Prenom' => $prenom,
                    ':Email' => $email
                ]);
            }elseif($role === 'visiteur'){
                $sqlvisit = "INSERT INTO user (id_user, Nom, Prenom, Email) VALUES (:id_user, :Nom, Prenom, :Email)";
                $stmtvisit = $this->connection->prepare($sqlvisit );
                $stmtvisit ->execute([
                    ':id_user' => $userId,
                    ':Nom' => $nom,
                    ':Prenom' => $prenom,
                    ':Email' => $email
                ]);
            }

            $this->connection->commit();
            return $userId;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception("Registration failed. Please try again.");
        }
    }


    public function login($email, $Motdepasse) {
        try {
            $sql = "SELECT id_user, Email, Motdepasse, Role FROM user WHERE Email = :Email";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':Email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($Motdepasse, $user['Motdepasse'])) {
                throw new Exception("Login failed. Please check your credentials.");
            }

            return [
                'id_user' => $user['id_user'],
                'email' => $user['email'],
                'role' => $user['Role']
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    }


    class Utilisateur{
       
        private $pdo;
        protected $id;
        protected $nom;
        protected $prenom;
        protected $email;
        protected $Motdepasse;
        protected $role;
    
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
    
        public function setUser($id,$nom,$prenom, $email, $Motdepasse, $role) {
            $this->id = $id;
            $this->nom=$nom;
            $this->prenom=$prenom;
            $this->email = $email;
            $this->Motdepasse= $Motdepasse;
            $this->role = $role;
        }
    
        public function getUserId() {
            return $this->id;
        }

        public function getNom() {
            return $this->nom;
        }

        public function getPrenom() {
            return $this->prenom;
        }

        public function getEmail() {
            return $this->email;
        }
        public function getMotdepasse() {
            return $this->Motdepasse;
        }
        public function getUserRole() {
            return $this->role;
        }

    }



    class admin extends Utilisateur{
         
        public function creecategory(){

        }

        public function modifiercategory(){

        }

        public function supprimercategory(){

        }

       public function consultercategory(){

       }

       public function accepterarticle(){

       }

       public function refusearticle(){

       }
    }


    class visiteur extends Utilisateur{

    }

    class acteur extends visiteur{

    }



    


?>