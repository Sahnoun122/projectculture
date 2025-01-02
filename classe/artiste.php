<?php

    require_once './utilisateur.php';

    class Auteur extends  Visiteur{

    
        public function ajouterArticle(string $titre , string $contenu, int $id_auteur, int $id_category){
            try{
                $sql = 'INSERT INTO articles (Titre, Contenu, id_auteur, id_category) VALUES (:Titre, :Contenu, :id_auteur, :id_category)';
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":Titre", $titre, PDO::PARAM_STR);
                $stmt->bindParam(":Contenu", $contenu, PDO::PARAM_STR);
                $stmt->bindParam(":id_auteur", $id_auteur, PDO::PARAM_INT);
                $stmt->bindParam(":id_category", $id_category, PDO::PARAM_INT);
                $stmt->execute();

                header("location: ../views/addarticle.php");

            } catch (PDOException $e) {
                return "Erreur lors de l'ajout de l'Article : " . $e->getMessage();
            }
        }


        // MODIFY ARTICLE METHOD
        public function modifierArticle(int $id_article, string $titre , string $contenu, int $id_category){
            try{
                $sql = "UPDATE articles SET Titre = :Titre, Contenu = :Contenu, id_category = :id_category WHERE id_article = :id_article";
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":titre", $titre, PDO::PARAM_STR);
                $stmt->bindParam(":contenu", $contenu, PDO::PARAM_STR);
                $stmt->bindParam(":id_category", $id_category, PDO::PARAM_INT);
                $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);
                $stmt->execute();

                header("location: ../views/addarticle.php");
            } catch (PDOException $e) {
                return "Erreur lors de modification de l'Article : ". $e->getMessage();
            }
        }
        

        // DELETE ARTICLE METHOD
        public function supprimerArticle(int $id_article){
            try{
                $sql = "DELETE FROM articles WHERE id_article = :id_article";
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);
                $stmt->execute();

                header("location: ../views/addarticle.php");
            } catch (PDOException $e) {
                return "Erreur lors de la suppression de l'Article : ". $e->getMessage();
            }
        }

    }