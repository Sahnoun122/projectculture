<?php


require_once '../database/db.php';




class Auth extends DbConnection {

    public function register($nom,$prenom, $email ,$Motdepasse, $role ,$PROFILE) {
        try {

            $allowedRoles = ['admin', 'user', 'visiteur'];
            if (!in_array($role, $allowedRoles)) {
                throw new Exception("Invalid role provided.");
            }
            $this->connection->beginTransaction();

            // $role = ($role === 'user') ? 'user' : 'visiteur';
            $Motdepasse = password_hash($Motdepasse, PASSWORD_BCRYPT);

            $sqlUser = "INSERT INTO user (Nom , Prenom , Email, Motdepasse, Role , PROFILE) VALUES ( :Nom , :Prenom ,:Email, :Motdepasse, :role , :PROFILE)";
            $stmtUser = $this->connection->prepare($sqlUser);
            $stmtUser->execute([
                ':Nom' => $nom,
                ':Prenom' => $prenom,
                ':Email' => $email,
                ':Motdepasse' => $Motdepasse,
                ':role' => $role,
                ':PROFILE' => $PROFILE

            ]);


            $userId = $this->connection->lastInsertId();

            $this->connection->commit();
            return $userId;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception("Registration failed. Please try again.");
        }
    }

    public function login($email, $Motdepasse) {
        try {
            $sql = "SELECT id_user, Email, Motdepasse, Role, profile, Nom FROM user WHERE Email = :Email";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':Email' => $email]);
            // $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() > 0){
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($Motdepasse,$user['Motdepasse'])){
                    return [
                            'id_user' => $user['id_user'],
                            'Email' => $user['Email'],
                            'role' => $user['Role'],
                            'profile' => $user['profile'],
                            'Nom' => $user['Nom'],
                    ];
                }else{
                    throw new Exception('Password Incorrect !');
                }
            }

            
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>