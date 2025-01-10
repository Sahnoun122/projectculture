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
     
       
        
            public function ajouterCommentaire($id_article, $id_user, $contenu) {
                $query = "INSERT INTO Commentaires (id_article, id_user, contenu) VALUES (:id_article, :id_user, :contenu)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id_article', $id_article, PDO::PARAM_STR);
                $stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);
                $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            }

            public function getUserData() {
                $id_user = $_SESSION['id_user'];
                $query = "SELECT * FROM user WHERE id_user = :id_user";
                $stmt = $this->db->prepare($query);
                $stmt->execute([':id_user' => $id_user]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }


            public function supprimercommentaires($id_co) {
                try {
                    $sql = "DELETE FROM Commentaires WHERE id_co = :id_co";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindValue(':id_co', $id_co, PDO::PARAM_INT);
                    $stmt->execute();
                } catch (PDOException $e) {
                    return "Erreur lors de la suppression du commentaire : " . $e->getMessage();
                }
            }





     // Toggle like functionality
     public function toggleLike($id_article) {
        $id_user = $_SESSION['id_user'];

        $sql = "SELECT * FROM likes WHERE id_article = :id_article AND id_user = :id_user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_article' => $id_article, ':id_user' => $id_user]);

        if ($stmt->rowCount() > 0) {
            // User has already liked the article, so remove the like
            $sql = "DELETE FROM likes WHERE id_article = :id_article AND id_user = :id_user";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id_article' => $id_article, ':id_user' => $id_user]);
        } else {
            // User hasn't liked the article, so add a like
            $sql = "INSERT INTO likes (id_article, id_user) VALUES (:id_article, :id_user)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id_article' => $id_article, ':id_user' => $id_user]);
        }
    }

    // Check if the user has already liked the article
    public function hasLiked($id_article) {
        $id_user = $_SESSION['id_user'];
        $sql = "SELECT * FROM likes WHERE id_article = :id_article AND id_user = :id_user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_article' => $id_article, ':id_user' => $id_user]);

        return $stmt->rowCount() > 0;
    }

}


        
        
    







