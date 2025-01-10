<?php
require_once '../classe/classe.php';
require_once '../database/db.php';
require_once '../classe/article.php';
require_once '../classe/artiste.php';

session_start();

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: connecter.php");
    exit;
}

echo  $_SESSION['id_user'];





$db = new DbConnection();
$pdo = $db->getConnection();


$article = new  Auteur($pdo);
$use= new  Visiteur($pdo);


if (isset($_POST['id_user'])) {
    $id_auteur = $_POST['id_user'];
} else {
    
    $id_auteur = null;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifie'])) {
    $id_article = $_POST['modifie'];

    $article = $article->getArticleById($id_article);

    if ($article) {
        ?>
        <form action="updateartile.php" method="post">
            <input type="hidden" name="id_article" value="<?php echo htmlspecialchars($article['id_article']); ?>">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['Titre']); ?>"><br>
            <label for="contenu">Contenu:</label>
            <textarea id="contenu" name="contenu"><?php echo htmlspecialchars($article['Contenu']); ?></textarea><br>
            <label for="image">Image:</label>
            <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($article['Image']); ?>"><br>
            <label for="id_category">Category ID:</label>
            <input type="number" id="id_category" name="id_category" value="<?php echo htmlspecialchars($article['id_category']); ?>"><br>
            <label for="id_tag">Tag ID:</label>
            <input type="number" id="id_tag" name="id_tag" value="<?php echo htmlspecialchars($article['id_tag']); ?>"><br>
            <input type="submit" value="Modifier">
        </form>
        <?php
    } else {
        echo "Article non trouvé.";
    }
}
?>
