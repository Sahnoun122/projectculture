<?php

    require_once '../classe/classe.php';
    require_once '../classe/user.php';

    require_once '../database/db.php';


    class Visiteur extends User{

       
        private $db;
        
        public function __construct($db)
        {
            $this->db = $db;
        }

        public function voirArticles(){
            try {
                $sql = "SELECT * FROM articles ORDER BY DateCréation DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $result = $stmt->fetchAll();
                    return $result;
                }else{
                    return "Aucun article trouvé";
                }
            } catch (PDOException $e) {
                return "Erreur lors de la récupération des articles : " . $e->getMessage();
            }
        }


        public function filterArticles($category){
            try {
                $sql = "SELECT * FROM articles A JOIN categorie C ON A.id_category = C.id_category WHERE C.Nom = :category ORDER BY A.DateCréation DESC";
                $stmt = $this-> db->prepare($sql);
                $stmt->bindParam(':category', $category, PDO::PARAM_STR);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $result = $stmt->fetchAll();
                    return $result;
                }else{
                    return "Aucun Article Trouvé !";
                }
            } catch (PDOException $e) {
                return "Erreur lors de la récupération des articles : " . $e->getMessage();
            }
        }
    }