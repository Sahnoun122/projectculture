<?php


require_once '../database/db.php';
require_once '../classe/classe.php';
require_once '../classe/user.php';


    class Admin extends User{


        private $db;
        
        public function __construct($db)
        {
            $this->db = $db;
        }

        public function voirCategory(){
            try {
                $sql = "SELECT * FROM category";
                $stmt = $this->db->prepare($sql);
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

    
        public function ajouterCategorie( $id_admin, $nom){
            try {
                $sql = "INSERT INTO category (id_admin, Nom) VALUES (:id_category, :Nom)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_category", $id_admin, PDO::PARAM_INT);
                $stmt->bindParam(":Nom", $nom, PDO::PARAM_STR);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de l'ajout de la catégorie : " . $e->getMessage();
            }
        }

        
        public function modifieCategorie($id, $nom){
            try {
                $sql = "UPDATE category SET Nom = :Nom  WHERE id_admin = :id_category";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_category", $id, PDO::PARAM_INT);
                $stmt->bindParam(":Nom", $nom, PDO::PARAM_STR);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de Modification de la catégorie :". $e->getMessage();
            }
        }

        
        public function supprimerCategorie($id){
            try {
                $sql = "DELETE FROM category WHERE id_admin= :id_category";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_category", $id, PDO::PARAM_INT);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de la suppression de la catégorie : " . $e->getMessage();
            }
        }

        


        public function accepterArticle($id_article){
            try {
                $sql = "UPDATE articles SET  Statut = 'Accepté' WHERE id_article = :id_article";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de la confirmation d'Article : ". $e->getMessage();
            }
        }

        



        public function refuseArticle( $id_article){
            try {
                $sql = "UPDATE articles SET  Statut = 'Refusé' WHERE id_article = :id_article";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_article", $id_article, PDO::PARAM_INT);
                $stmt->execute();
                header("location: ../views/addcategory.php");
            } catch (PDOException $e) {
                return "Erreur lors de la Refuse d'Article : ". $e->getMessage();
            }
        }
         


        



    
    public function ajoutertags($id_admin, $nom) {
        try {
            $sql = "INSERT INTO tags (id_admin, Nom) VALUES (:id_admin, :Nom)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_admin", $id_admin, PDO::PARAM_INT);
            $stmt->bindParam(":Nom", $nom, PDO::PARAM_STR);
            $stmt->execute();
            header("location: ../views/creetag.php");
        } catch (PDOException $e) {
            return "Erreur lors de l'ajout de la catégorie : " . $e->getMessage();
        }
    }

    
    public function modifietags($id, $nom){
        try {
            $sql = "UPDATE tags SET Nom = :Nom  WHERE id_admin = :id_admin";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":iid_admin", $id, PDO::PARAM_INT);
            $stmt->bindParam(":Nom", $nom, PDO::PARAM_STR);
            $stmt->execute();
            header("location: ../views/addcategory.php");
        } catch (PDOException $e) {
            return "Erreur lors de Modification de la catégorie :". $e->getMessage();
        }
    }

    
    public function supprimertags($id){
        try {
            $sql = "DELETE FROM tags WHERE id_admin= :id_admin";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_admin", $id, PDO::PARAM_INT);
            $stmt->execute();
            header("location: ../views/addcategory.php");
        } catch (PDOException $e) {
            return "Erreur lors de la suppression de la catégorie : " . $e->getMessage();
        }
    }


    public function afficheprofile() {
        $sql = "SELECT * FROM user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function supprimerProfil($id) {
        $sql = "DELETE FROM user WHERE id_user = :id_user";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_user', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount(); 
    }

    
    public function affichecommentaires() {
        $sql = "SELECT * FROM commentaires";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function supprimerCommentaire($id_co) {
        $sql = "DELETE FROM commentaires WHERE id_co = :id_co";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_co', $id_co, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount(); 
    }
    
}

    








    