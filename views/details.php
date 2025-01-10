
<?php
session_start();



require_once '../classe/classe.php';
require_once '../classe/visiteur.php';
require_once '../database/db.php';
require_once '../phpmailer/mail.php';
$mail->setFrom('khadijasahnoun70@gmail.com', 'khadija sahnoun');


$admin_id = $_SESSION['id_user'];

$db = new DbConnection();
$pdo = $db->getConnection();

$user = new User($pdo);
$visiteur = new Visiteur($pdo);


$sql = "SELECT Nom FROM category";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql1 = 'SELECT * FROM tags ';
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute();

$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);


$sql2 = "SELECT Nom FROM user";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();

$user = $stmt2->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contenu'])) {
    $contenu= $_POST['contenu'];
    $id_user =  $_SESSION['id_user'];
    $id_article =  $_SESSION['id_article'];

   
    $visiteur->ajouterCommentaire($id_article, $id_user, $contenu) ;
    header("Location: details.php");
    exit;
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id_co = $_POST['delete'];
    
    $visiteur->supprimercommentaires($id_co);
    
    header("Location: details.php");
    exit;
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'toggleLike') {
    $id_article = $_POST['id_article'];
    $result = $visiteur->toggleLike($id_article);
    header("Location: details.php");
    exit;
  }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="icon" href="../assets/gym.png"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
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
        <h4 class="mx-2 mt-2 font-medium" style="color: white;"><?php echo $user['Nom'] ?></h4>
        <p class="mx-2 mt-1 text-sm font-medium" style="color: white;"><?php echo $_SESSION['email']?></p>
    </div>

      <ul class="space-y-2 font-medium px-3 pb-4">
       
        <li>
            <a href="dashvisit.php" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 hover:text-black group">
               <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
        </li>
        <!-- <li>
            <a href="memberReservations.php" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 hover:text-black group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                  <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
               </svg>
               <span class="ms-3">Reservations</span>
            </a>
        </li> -->
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

<!-- Main -->

<div class="p-8 sm:ml-80">

    
<form class="max-w-md mx-auto">   
   
</form>



    <h2 class="text-4xl font-semibold text-black mb-6">Articles</h2>

    <div class="" id="articlesContainer" style="align-items: start;">
        <?php
        $activities_sql = "SELECT articles.*, category.nom  AS category_name FROM articles JOIN category ON articles.id_category = category.id_category ";
        
        $stmt_activities = $pdo->query($activities_sql);
        $activities = $stmt_activities->fetchAll(PDO::FETCH_ASSOC);

        foreach ($activities as $activity):
        ?>
        <div class="" data-category="<?php echo htmlspecialchars($activity['id_category'], ENT_QUOTES, 'UTF-8'); ?>" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="p-6">
                <h3 class="text-4xl mb-4 font-semibold text-black"><?php echo htmlspecialchars($activity['Titre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p class="text-lg text-black"><?php echo htmlspecialchars($activity['Contenu'], ENT_QUOTES, 'UTF-8'); ?></p>
                <a href="details.php"><img src="<?php echo htmlspecialchars($activity['Image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Activity Photo" class="w-full h-48 object-cover">                </a>
                <p class="text-lg text-black"><?php echo htmlspecialchars($activity['category_name'], ENT_QUOTES, 'UTF-8'); ?></p>

               
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="toggleLike">
                <input type="hidden" name="id_article" value="<?php echo $activity['id_article']; ?>">
                <div class="flex items-center gap-3">
                    <button type="submit" class="like-btn">
                        <?php
                        $liked = $visiteur->hasLiked($activity['id_article']);
                        echo $liked ? 'Unlike' : 'Like';
                        ?>
                    </button>
                </div>
            </form>


            <button type="button" onclick="pdf()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Téléchargé</button>

            
<br>
<br>
<br>
            <div>

            
            <?php


    $sql3 = "SELECT * FROM Commentaires";
     $stmt3 = $pdo->prepare($sql3);
     $stmt3->execute();
     $user = $stmt3->fetchAll(PDO::FETCH_ASSOC);
       foreach ( $user  as $activity):
       ?>
       <div class="" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
           <div class="p-6 grid">
               <h6 class="text-2xl mb-4 font-semibold text-black"><?php echo $activity['contenu']; ?></h6>
               <form method="POST" onsubmit="return confirm('Are you sure you want to delete this activity?');">
    <div class="flex items-center justify-center mt-4">
        <button type="submit" class="text-xl hover:scale-105" name="delete" value="<?php echo $activity['id_co']; ?>">🗑️</button>
    </div>
</form>
           </div>
       </div>
       <?php endforeach; ?>
            </div>


<form method="POST" class="max-w-md mx-auto"> 
    
  

    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">commenté</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <input type="search" name="contenu" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ajouter commentaire" required />
        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Commenté</button>
    </div>
</form>

        </div>

        <?php endforeach; ?>
    </div>
</div>
</div>


<script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>

<script>



function filterArticles() {
    let filter = document.getElementById("categoryFilter").value;
    let articles = document.querySelectorAll("#articlesContainer > div");

    articles.forEach(article => {
        if (filter === "all" || article.getAttribute("data-category") === filter) {
            article.style.display = "block";
        } else {
            article.style.display = "none";
        }
    });
}

AOS.init();


// function pdf(){
//     var pdfObject = jsPDFInvoiceTemplate.default(props); //returns number of pages created
//    console.log("nbdnbz" ,  pdfObject );
// }
// var props = {
//     outputType:  jsPDFInvoiceTemplate.OutputType.Save,
//     onJsPDFDocCreation?: (jsPDFDoc: jsPDF) => void, //Allows for additional configuration prior to writing among others, adds support for different languages and symbols
//     returnJsPDFDocObject: true,
//     fileName: "Invoice 2021",
//     orientationLandscape: false,
//     compress: true,
//     logo: {
//         src: "https://raw.githubusercontent.com/edisonneza/jspdf-invoice-template/demo/images/logo.png",
//         type: 'PNG', //optional, when src= data:uri (nodejs case)
//         width: 53.33, //aspect ratio = width/height
//         height: 26.66,
//         margin: {
//             top: 0, //negative or positive num, from the current position
//             left: 0 //negative or positive num, from the current position
//         }
//     },
//     stamp: {
//         inAllPages: true, //by default = false, just in the last page
//         src: "https://raw.githubusercontent.com/edisonneza/jspdf-invoice-template/demo/images/qr_code.jpg",
//         type: 'JPG', //optional, when src= data:uri (nodejs case)
//         width: 20, //aspect ratio = width/height
//         height: 20,
//         margin: {
//             top: 0, //negative or positive num, from the current position
//             left: 0 //negative or positive num, from the current position
//         }
//     },
//     business: {
//         name: "Business Name",
//         address: "Albania, Tirane ish-Dogana, Durres 2001",
//         phone: "(+355) 069 11 11 111",
//         email: "email@example.com",
//         email_1: "info@example.al",
//         website: "www.example.al",
//     },
//     contact: {
//         label: "Invoice issued for:",
//         name: "Client Name",
//         address: "Albania, Tirane, Astir",
//         phone: "(+355) 069 22 22 222",
//         email: "client@website.al",
//         otherInfo: "www.website.al",
//     },
//     invoice: {
//         label: "Invoice #: ",
//         num: 19,
//         invDate: "Payment Date: 01/01/2021 18:12",
//         invGenDate: "Invoice Date: 02/02/2021 10:17",
//         headerBorder: false,
//         tableBodyBorder: false,
//         header: [
//           {
//             title: "#", 
//             style: { 
//               width: 10 
//             } 
//           }, 
//           { 
//             title: "Title",
//             style: {
//               width: 30
//             } 
//           }, 
//           { 
//             title: "Description",
//             style: {
//               width: 80
//             } 
//           }, 
//           { title: "Price"},
//           { title: "Quantity"},
//           { title: "Unit"},
//           { title: "Total"}
//         ],
//         table: Array.from(Array(10), (item, index)=>([
//             index + 1,
//             "There are many variations ",
//             "Lorem Ipsum is simply dummy text dummy text ",
//             200.5,
//             4.5,
//             "m2",
//             400.5
//         ])),
//         additionalRows: [{
//             col1: 'Total:',
//             col2: '145,250.50',
//             col3: 'ALL',
//             style: {
//                 fontSize: 14 //optional, default 12
//             }
//         },
//         {
//             col1: 'VAT:',
//             col2: '20',
//             col3: '%',
//             style: {
//                 fontSize: 10 //optional, default 12
//             }
//         },
//         {
//             col1: 'SubTotal:',
//             col2: '116,199.90',
//             col3: 'ALL',
//             style: {
//                 fontSize: 10 //optional, default 12
//             }
//         }],
//         invDescLabel: "Invoice Note",
//         invDesc: "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.",
//     },
//     footer: {
//         text: "The invoice is created on a computer and is valid without the signature and stamp.",
//     },
//     pageEnable: true,
//     pageLabel: "Page ",
// };

</script>


</body>
</html>
