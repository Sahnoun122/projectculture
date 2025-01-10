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

// echo  $_SESSION['id_user'];
$db = new DbConnection();
$pdo = $db->getConnection();

$article = new Auteur($pdo);
$use = new Visiteur($pdo);


if (isset($_GET['id_user'])) {
    $id_auteur = $_GET['id_user'];
} else {
    $id_auteur = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_article = $_GET['id'];

    $article = $article->getid($id_article);

    // print_r($article);
    if ($article) {


    // print_r($article);

    } else {
        echo "Article non trouvé.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Article</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Modifier Article</h2>
        <form action="./updateartile.php" method="get">
            <input type="hidden" name="id_article" value="<?php echo htmlspecialchars($article['id_article']); ?>">
            <div class="mb-4">
                <label for="titre" class="block text-gray-700 font-semibold">Titre:</label>
                <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['Titre']); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label for="contenu" class="block text-gray-700 font-semibold">Contenu:</label>
                <textarea id="contenu" name="contenu" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"><?php echo htmlspecialchars($article['Contenu']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold">Image:</label>
                <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($article['Image']); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label for="id_category" class="block text-gray-700 font-semibold">Category ID:</label>
                <input type="number" id="id_category" name="id_category" value="<?php echo htmlspecialchars($article['id_category']); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label for="id_tag" class="block text-gray-700 font-semibold">Tag ID:</label>
                <input type="number" id="id_tag" name="id_tag" value="<?php echo htmlspecialchars($article['id_tag']); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="flex justify-end">
                <input type="submit" value="modifie" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
        </form>
    </div>

</body>
</html>


