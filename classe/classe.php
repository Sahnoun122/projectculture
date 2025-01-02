<?php
require_once '../database/db.php';

// class Auth extends DbConnection {

//     public function register($nom, $prenom, $email, $password,$role = 'visiteur') {
//         try {
//             $this->connection->beginTransaction();

//             if ($role === 'visiteur') {
//                 $sqlvisiteur = "INSERT INTO user (id_user, Nom, Prenom, Email) VALUES (:id_user, :Nom, :Prenom, :Email)";
//                 $stmtvisiteur = $this->connection->prepare( $sqlvisiteur );
//                 $stmtvisiteur->execute([
//                     ':id_user' => $id_user,
//                     ':Nom' => $nom,
//                     ':Prenom' => $prenom,
//                     ':Email' => $email
//                 ]);
//             }

//             $userId = $this->connection->lastInsertId();

//             if ($role === 'user') {
//                 $sqladmin = "INSERT INTO user (id_user, Nom, Prenom, Email) VALUES (:id_user, :Nom, :Prenom, :Email)";
//                 $stmtadmin = $this->connection->prepare( $sqladmin );
//                 $stmtadmin->execute([
//                     ':id_user' => $id_user,
//                     ':Nom' => $nom,
//                     ':Prenom' => $prenom,
//                     ':Email' => $email
//                 ]);
//             }
//             // elseif ($role === 'user') {
//             //     $sqlartiste = "INSERT INTO user (id_user, Nom, Prenom, Email) VALUES (:id_user, :Nom, :Prenom, :Email)";
//             //     $stmtartiste = $this->connection->prepare  ( $sqlartiste );
//             //     $stmtartiste ->execute([
//             //         ':id_user' => $id_user,
//             //         ':Nom' => $nom,
//             //         ':Prenom' => $prenom,
//             //         ':Email' => $email
//             //     ]);
//             // }

//             $this->connection->commit();
//             return $userId;
//         } catch (Exception $e) {
//             $this->connection->rollBack();
//             throw new Exception("Registration failed. Please try again.");
//         }
//     }

//     public function login($username, $password) {
//         try {
//             $sql = "SELECT id_user, Email, Motdepasse, Role FROM user WHERE Email = :Email";
//             $stmt = $this->connection->prepare($sql);
//             $stmt->execute([':Email' => $email]);
//             $user = $stmt->fetch(PDO::FETCH_ASSOC);

//             if (!$user || !password_verify($Motdepasse, $user['Motdepasse'])) {
//                 throw new Exception("Login failed. Please check your credentials.");
//             }

//             return [
//                 'id' => $user['id_user'],
//                 'username' => $user['Email'],
//                 'role' => $user['Role']
//             ];
//         } catch (Exception $e) {
//             throw $e;
//         }
//     }
// }


class Auth extends DbConnection {

    public function register($nom,$prenom, $email ,$Motdepasse, $role) {
        try {

            $allowedRoles = ['admin', 'user', 'visiteur'];
            if (!in_array($role, $allowedRoles)) {
                throw new Exception("Invalid role provided.");
            }
            $this->connection->beginTransaction();

            // $role = ($role === 'user') ? 'user' : 'visiteur';

            $hashedPassword = password_hash($Motdepasse, PASSWORD_BCRYPT);

            $sqlUser = "INSERT INTO user (Nom , Prenom , Email, Motdepasse, Role) VALUES ( :Nom , :Prenom ,:Email, :Motdepasse, :role)";
            $stmtUser = $this->connection->prepare($sqlUser);
            $stmtUser->execute([
                ':Nom' => $nom,
                ':Prenom' => $prenom,
                ':Email' => $email,
                ':Motdepasse' => $Motdepasse,
                ':role' => $role
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
            $sql = "SELECT id_user, Email, Motdepasse, Role FROM user WHERE Email = :Email";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':Email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($Motdepasse, $user['Motdepasse'])) {
                throw new Exception("Login failed. Please check your credentials.");
            }

            return [
                'id_user' => $user['id_user'],
                'Email' => $user['Email'],
                'role' => $user['Role']
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>