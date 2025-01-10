<?php

    require_once '../classe/visiteur.php';
    require_once '../database/db.php';


    class Auteur extends  Visiteur{

        private $db;
        
        public function __construct($db)
        {
            $this->db = $db;
        }

    
        public function ajouterArticle( $id_auteur, $titre, $contenu, $Image, $id_category ,$id_tag){
            try{
                echo "hhn0";

                $sql = 'INSERT INTO articles  ( id_auteur , Titre, Contenu,Image, id_category,id_tag ) VALUES ( :id_auteur ,:Titre, :Contenu,:Image, :id_category , :id_tag)';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":Titre", $titre);
                $stmt->bindParam(":Image", $Image);
                $stmt->bindParam(":Contenu", $contenu);
                $stmt->bindParam(":id_tag",   $id_tag);

                $stmt->bindParam(":id_auteur", $id_auteur);
                $stmt->bindParam(":id_category", $id_category);
                echo "before ex";

                $stmt->execute();
                
                echo "hhn0";

            } catch (PDOException $e) {
                return "Erreur lors de l'ajout de l'Article : " . $e->getMessage();
            }
        }

        public function modifierArticle($id_article, $titre, $contenu, $image, $id_category , $id_tag){
            try{
                $sql = "UPDATE articles SET Titre = :Titre, Contenu = :Contenu, Image = :Image, id_category = :id_category ,id_tag = :id_tag  WHERE id_article = :id_article";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":Titre", $titre, PDO::PARAM_STR);
                $stmt->bindParam(":Contenu", $contenu, PDO::PARAM_STR);
                $stmt->bindParam(":Image", $image, PDO::PARAM_STR);
                $stmt->bindParam(":id_category", $id_category, PDO::PARAM_INT);
                $stmt->bindParam(":id_tag", $id_article, PDO::PARAM_INT);
                $stmt->bindParam(":id_article", $id_tag, PDO::PARAM_INT);

                $stmt->execute();
        
                header("Location: ../views/addarticle.php");
            } catch (PDOException $e) {
                return "Erreur lors de modification de l'Article : " . $e->getMessage();
            }
        }
        

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


        public function getartisteData() {
            $id_user = $_SESSION['id_user'];
            $query = "SELECT * FROM user WHERE id_user = :id_user";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id_user' => $id_user]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

       
        public function getArticleById($id_article) {
            $id_user = $_SESSION['id_article'];
            $query = "SELECT * FROM articles WHERE id_article = :id_article";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);
            $stmt->execute([':id_article' => $id_user]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    }