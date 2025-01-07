<?php
require_once '../classe/classe.php';
require_once '../database/db.php';
require_once '../classe/admin.php';

session_start();

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: connecter.php");
    exit;
}

echo  $_SESSION['id_user'];


$db = new DbConnection();
$pdo = $db->getConnection();


$article = new  Admin($pdo);
$use= new  User($pdo);


if (isset($_POST['id_user'])) {
    $id_auteur = $_POST['id_user'];
} else {
    
    $id_auteur = null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['update'])) {
        $id_categorie = $_GET['id'];
        $nom = htmlspecialchars($_POST['Nom'], ENT_QUOTES, 'UTF-8');


        $article->modifieCategorie($id, $nom);
        header('Location: ./dashadmin.php');
    } else {
        echo "Invalid request method.";
    }
} else {
    echo "Invalid request method.";
}