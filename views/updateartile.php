<?php

require_once '../classe/classe.php';
require_once '../database/db.php';
require_once '../classe/article.php';
require_once '../classe/artiste.php';

session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

echo $_SESSION['id_user'];

$db = new DbConnection();
$pdo = $db->getConnection();

$article = new Auteur($pdo);
$use = new Visiteur($pdo);

$id_auteur = $_GET['id_user'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_article'], $_GET['titre'], $_GET['contenu'], $_GET['image'], $_GET['id_category'], $_GET['id_tag'])) {
    $id_article = (int)$_GET['id_article'];
    $titre = $_GET['titre'];
    $contenu = $_GET['contenu'];
    $image = $_GET['image'];
    $id_category = (int)$_GET['id_category'];
    $id_tag = (int)$_GET['id_tag'];

    if ($article->modifierArticle($id_article, $titre, $contenu, $image, $id_category, $id_tag)) {
        header("Location: addarticle.php");
        exit;
    } else {
        echo "Error updating article.";
    }
} else {
    echo "Invalid request.";
}
?>
