<?php

require_once '../database/db.php';

    class Article{

        private  $id_article;
        private  $titre;
        private  $contenu;
        private  $DateCreation;

        
        private $db;
        
        public function __construct($db)
        {
            $this->db = $db;
        }
    
     
        
        public function getId(){
            return $this->id_article;
        }
        public function getTitre(){
            return $this->titre;
        }
        public function getContent(){
            return $this->contenu;
        }
        public function getDate(){
            return $this->DateCreation;
        }


    
        public function setId($id_article){
            $this->id_article = $id_article;
        }
        public function setTitle( $titre){
            $this->titre = $titre;
        }
        public function setContent( $contenu){
            $this->contenu = $contenu;
        }
        public function setDate( $date){
            $this->DateCreation = $date;
        }


        public function afficherstatu() {
            try {
                $query = "SELECT Titre, Statut, DateCreation 
                          FROM articles 
                          ORDER BY DateCreation DESC";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                return "Erreur lors de la Récupération des Articles: " . $e->getMessage();
            }
        }
        


        public function toutArticles(){
            try{
                $query = "SELECT * FROM articles A JOIN category C ON A.id_category = C.id_category
                        JOIN user U ON U.id_user = A.id_auteur ORDER BY A.DateCreation DESC ";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
                }else{
                    return false;
                }
            }catch(PDOException $e){
                return "Erreur lors de la Récupération des Articles". $e->getMessage();
            }
        }



        public function voirArticle( $id){
            try{
                $query = "SELECT * FROM articles WHERE id_article = :id_article ";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":id_article", (int)$id, PDO::PARAM_INT);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $result;
                }else{
                    return false;
                }
            }catch(PDOException $e){
                return "Erreur lors de la Récupération de l'Article". $e->getMessage();
            }
        }
    }