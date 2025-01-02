<?php

require_once '../classe/classe.php';

    class Admin extends User{

        
        public function voirCategory(){
            try {
                $sql = "SELECT * FROM category";
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $category= $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $category;
                }else{
                    return "Aucune catégorie trouvée";
                }
            } catch (PDOException $e) {
                return "Erreur lors de l'affichage des catégories : " . $e->getMessage();
            }
        }

    
        public function ajouterCategorie(int $id_admin, string $nom){
            try {
                $sql = "INSERT INTO category (id_admin, nom_category, description) VALUES (:id_admin, :nom)";
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":id_admin", $id_admin, PDO::PARAM_INT);
                $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de l'ajout de la catégorie : " . $e->getMessage();
            }
        }

        
        public function modifieCategorie(int $id, string $nom){
            try {
                $sql = "UPDATE category SET nom = :nom  WHERE id_category = :id_category";
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":id_category", $id, PDO::PARAM_INT);
                $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de Modification de la catégorie :". $e->getMessage();
            }
        }

        
        public function supprimerCategorie(int $id){
            try {
                $sql = "DELETE FROM category WHERE id_categorie = :id_categorie";
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":id_categorie", $id, PDO::PARAM_INT);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de la suppression de la catégorie : " . $e->getMessage();
            }
        }

        


        public function accepterArticle($id_article){
            try {
                $sql = "UPDATE article SET  Statut = 'Accepté' WHERE id_article = :id_article";
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de la confirmation d'Article : ". $e->getMessage();
            }
        }

        



        public function refuseArticle(int $id_article){
            try {
                $sql = "UPDATE article SET  Statut = 'Refusé' WHERE id_article = :id_article";
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de la Refuse d'Article : ". $e->getMessage();
            }
        }

    }
