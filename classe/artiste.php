<?php

    require_once '../classe/visiteur.php';
    require_once '../database/db.php';


    class Auteur extends  Visiteur{

    
        public function ajouterArticle($titre ,  $contenu ,$Image, $id_auteur,$id_category){
            try{
                $sql = 'INSERT INTO articles (Titre, Contenu,Image, id_auteur, id_category) VALUES (:Titre, :Contenu,:Image, :id_auteur, :id_category)';
                $stmt = $this->DbConnection->getConnection()->prepare($sql);
                $stmt->bindParam(":Titre", $titre, PDO::PARAM_STR);
                $stmt->bindParam(":Image", $Image, PDO::PARAM_STR);
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
        public function modifierArticle($id_article, $titre , $contenu, $id_category){
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
        public function supprimerArticle( $id_article){
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