<?php

    require_once '../config/db.php';

    class Article{
        private  $id_article;
        private  $titre;
        private  $contenu;
        private  $DateCreation;
        private $DbConnection;

    
        public function __construct(){
            $this->DbConnection= new DbConnection();;
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


        public function allArticles(){
            try{
                $query = "SELECT * FROM articles A JOIN category C ON A.id_category = C.id_category
                        JOIN user U ON U.id_user = A.id_auteur ORDER BY A.DateCreation DESC";
                $stmt = $this->DbConnection->getConnection()->prepare($query);
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

        public function showArticle( $id){
            try{
                $query = "SELECT * FROM articles WHERE id_article = :id_article";
                $stmt = $this->DbConnection->getConnection()->prepare($query);
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