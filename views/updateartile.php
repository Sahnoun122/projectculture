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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_article = $_POST['id_article'];
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $image = $_POST['image'];
    $id_category = $_POST['id_category'];
    $id_tag = $_POST['id_tag'];

    $article->modifierArticle($id_article, $titre, $contenu, $image, $id_category, $id_tag);

    header("Location: addarticle.php");
    exit;
}



?>
