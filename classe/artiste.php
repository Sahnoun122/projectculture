<?php

    require_once '../classe/visiteur.php';
    require_once '../database/db.php';


    class Auteur extends  Visiteur{

        private $db;
        
        public function __construct($db)
        {
            $this->db = $db;
        }

    
        public function ajouterArticle( $id_auteur ,$titre ,  $contenu ,$Image,$id_category){
            try{
                $sql = 'INSERT INTO articles  ( id_auteur , Titre, Contenu,Image, id_category ) VALUES ( :id_auteur ,:Titre, :Contenu,:Image, :id_category)';
                $stmt = $this->db->prepare($sql);
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
        public function modifierArticle( $id_auteur ,$titre ,  $contenu ,$Image,$id_category){
            try{
                $sql = "UPDATE articles SET Titre = :Titre, Contenu , Image= :Contenu, :id_category , :Image = :id_category WHERE id_article = :id_article";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":titre", $titre, PDO::PARAM_STR);
                $stmt->bindParam(":contenu", $contenu, PDO::PARAM_STR);
                $stmt->bindParam(":Image", $contenu, PDO::PARAM_STR);


                $stmt->bindParam(":id_category", $id_category, PDO::PARAM_INT);
                $stmt->bindParam(":id_article", $id_auteur, PDO::PARAM_INT);
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
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);
                $stmt->execute();

                header("location: ../views/addarticle.php");
            } catch (PDOException $e) {
                return "Erreur lors de la suppression de l'Article : ". $e->getMessage();
            }
        }

    }