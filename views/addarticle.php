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





if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Titre'])) {
    $id_auteur = $_SESSION['id_user'];
    $titre = $_POST['Titre'];
    $contenu = $_POST['Contenu'];
    $Image = $_POST['Image'];
    $id_category = $_POST['id_category'];
    $id_tag = $_POST['id_tag'];



    $article->ajouterArticle($id_auteur, $titre, $contenu, $Image, $id_category ,   $id_tag);

    header("Location: addarticle.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifie'])) {
    $id_auteur = $_SESSION['modifie'];
    $titre = $_POST['Titre'];
    $contenu = $_POST['Contenu'];
    $Image = $_POST['Image'];
    $id_category = $_POST['id_category'];
    $id_tag = $_POST['id_tag'];



    $article-> modifierArticle($id_article, $titre, $contenu, $image, $id_category , $id_tag);

    header("Location: addarticle.php");
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $id_article = $_POST['delete'];

    $article-> supprimerArticle($id_article);

    header("Location: addarticle.php");
    exit;
}


$sql = 'SELECT * FROM category ';
$stmt = $pdo->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql1 = 'SELECT * FROM tags ';
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute();

$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="../assets/gym.png"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

        <!-- AOS Animation CDN -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="bg-gray-100">

<!-- Main -->
<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-80 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full overflow-y-auto bg-black">
    <!-- Sidebar Menu -->
    <div class="flex flex-col items-center mt-6 -mx-2">
        <img class="object-cover w-24 h-24 mx-2 rounded-full" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="avatar">
        <h4 class="mx-2 mt-2 font-medium" style="color: white;"><?php echo $_SESSION['Nom']?></h4>
        <p class="mx-2 mt-1 text-sm font-medium" style="color: white;"><?php echo $_SESSION['email']?></p>

    </div>

      <ul class="space-y-2 font-medium px-3 pb-4">
        <li>
            <a href="dashuser.php" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 hover:text-black group">
                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                </svg>
               <span class="ms-3">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="addarticle.php" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 hover:text-black group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                  <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
               </svg>
               <span class="ms-3">Articles</span>
            </a>
        </li>
        <li>
            <a href="logout.php" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 hover:text-black group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Log Out</span>
            </a>
        </li>
      </ul>
   </div>
</aside>


<div class="p-8 sm:ml-80">
    <h2 class="text-4xl font-semibold text-black mb-6">Articles</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-12" id="articlesContainer" style="align-items: start;">
        <?php
        $activities_sql = "SELECT articles.*, category.nom  AS category_name FROM articles JOIN category ON articles.id_category = category.id_category ";
        
        $stmt_activities = $pdo->query($activities_sql);
        $activities = $stmt_activities->fetchAll(PDO::FETCH_ASSOC);

        foreach ($activities as $activity):
        ?>
        <div class="bg-black shadow-lg rounded-lg overflow-hidden" data-category="<?php echo htmlspecialchars($activity['id_category'], ENT_QUOTES, 'UTF-8'); ?>" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="p-6">
                <h3 class="text-4xl mb-4 font-semibold text-white"><?php echo htmlspecialchars($activity['Titre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p class="text-lg text-white"><?php echo htmlspecialchars($activity['Contenu'], ENT_QUOTES, 'UTF-8'); ?></p>
                <a href="details.php"><img src="<?php echo htmlspecialchars($activity['Image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Activity Photo" class="w-full h-48 object-cover">                </a>
                <p class="text-lg text-white"><?php echo htmlspecialchars($activity['category_name'], ENT_QUOTES, 'UTF-8'); ?></p>

                <form method="POST" >
                    <div class="flex items-center justify-center mt-4">
                        <button type="submit" name="delete" class="text-xl hover:scale-105" value="<?php echo htmlspecialchars($activity['id_article'], ENT_QUOTES, 'UTF-8'); ?>">🗑️</button>
                    </div>
                    <button type="submit" name="modifie" value="<?php echo htmlspecialchars($activity['id_article'], ENT_QUOTES, 'UTF-8'); ?>" class="text-xl hover:scale-105">🔏</button>

                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>





<!-- Main -->


    <h2 class="text-4xl font-semibold text-black mb-6">Add New Articles</h2>
    <div class="flex items-center justify-center my-8 bg-gray-100">
        <div class="w-full mx-0 relative z-10 max-w-2xl lg:mt-0 lg:w-5/12">
            <div class="p-10 bg-white shadow-2xl rounded-xl relative z-10" data-aos="fade-right">

                <form method="POST" class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an category</label>
            <select id="category" name="id_category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
       <?php
        
      foreach ($result as $row) {
      echo "<option value=".$row['id_category'] . ">" . $row['Nom'] . "</option>";
       }
        ?>
  </select>



  <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an tags</label>
            <select id="category" name="id_tag" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
       <?php
        
      foreach ($result1 as $row) {
      echo "<option value=".$row['id_tag'] . ">" . $row['Nom'] . "</option>";
       }
        ?>
  </select>
            

                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600
                            absolute">Titre</p>
                        <input type="text" id="Titre" name="Titre" required class="border placeholder-gray-400 focus:outline-none
                            focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white
                            border-gray-300 rounded-md"/>
                    </div>
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600
                            absolute">Contenu</p>
                        <textarea id="Contenu" name="Contenu" rows="3" required class="border placeholder-gray-400 focus:outline-none
                            focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white
                            border-gray-300 rounded-md"></textarea>
                    </div>
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600
                            absolute">Image</p>
                        <input type="URL" id="Image" name="Image" required class="border placeholder-gray-400 focus:outline-none
                            focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white
                            border-gray-300 rounded-md"/>
                    </div>
                    <div class="relative">
                        <button type="submit" name="modifi" class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white bg-green-500
                            rounded-lg transition duration-200 hover:bg-green-600 ease">Add Articles</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

<script>
  AOS.init();
</script>

</body>
</html>