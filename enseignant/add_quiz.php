<?php
session_start();

    // echo '<pre>';
    // print_r($_SERVER);
    // echo '</pre>';
    // if($_SERVER['REQUEST_METHOD'] === "POST"){
    //     echo $_POST['email'];
    //     echo '<pre>';
    // print_r($_SERVER);
    // echo '</pre>';
    // }
    function generate_csrf_token(){
        if(empty($_SESSION['csrf_token'])){
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    if(isset($_SESSION["Role"])){
        if($_SESSION["Role"] != "enseignant"){
            header('location: Error401.php');
            exit();
    }}else{
    header('location:login.php');
        exit();
    }

    if(isset($_POST['deconnect'])){
        header('location:deconnect.php');
        exit();
    }
    
include_once('database.php');
    //function remplissage list categorie and id cat hidden 
    function getIdEnseignant(PDO $pdo, $email): array{
        $requet = 'SELECT id FROM users where email =?';
    
        try {
        $stm = $pdo->prepare($requet);
        $stm->execute([$email]);
        $idEnseignant = $stm->fetch()?:[];

        return $idEnseignant;
        }catch(PDOException $e){
            error_log('PDO Error(prepare or execute): ' . $e->getMessage());
            return [];
        }
        
    }
    function selectCats(PDO $pdo): array{
        $email = $_SESSION['Email'];
        $idEnseignant = getIdEnseignant($pdo, $email);
        $createdQuiz= 'SELECT id,nom,created_by FROM Category WHERE created_by =?';
        try{
            
            $stm = $pdo->prepare($createdQuiz);
            $stm->execute([(int)$idEnseignant['id']]);
    
            return $stm->fetchAll();

        }catch(PDOException $e){
            // error_log($e->getMessage())  <=  user ل DB ما خاصّش تبان أخطاء 
            echo 'createdCategorie problem |addcategorie <=page Exception|=> ' . $e->getMessage();
            return [];
        }
    }
        // get nom and id, created_by categories of user
        $categories = [];
        $categories = selectCats($pdo);
    
        // remplaire form edit bottun
    $nomCat = $descCat = '';
    if(isset($_POST['edit'])){
        global $id;
        $id = (int)$_POST['idcat'];
        $sql = "SELECT * FROM Category where id = ?";
        try{
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $cats = $stmt->fetch();

            $nomCat = $cats['nom'];
            $descCat = $cats['description'];
            // exit();
        }catch(PDOException $exp){
            echo "categorie errors" . $exp->getMessage();
        }         
    }
    // update data button Edit clicked
    
    $errornomcate = $errordescriptioncategorie = '';
    if(isset($_POST['update'])){
        //global $id;
        $id = $_POST['categorie'];
        $namecategorie = strip_tags(trim($_POST['Editnom']));
        $description = strip_tags(trim($_POST['Editdescription']));
        if(empty($namecategorie)){
            $errornomcate = 'Nom catégotie est important';
        }
        if(empty($description)){
            $errordescriptioncategorie = 'description est important';
        }elseif(strlen($description)<20 || strlen($description)>100){
            $errordescriptioncategorie = 'descrition doit étre moin de 100 character et plus de 20';
        }   
        if(strlen($errordescriptioncategorie) ==0 && strlen($errornomcate)==0){
            
            //=> get id Enseignant from data to link it to categorie created
            
            
             echo '<pre>';
            echo $id . "hello update";
        echo '</pre>';
            $requet = 'UPDATE Category
                        SET nom = ?, description = ? 
                        WHERE id = ?';
            try{
                $stm =  $pdo->prepare($requet);       
                $stm->execute([$namecategorie,$description,$id]);
                // get data of categories for UI
                $categories = selectcats($pdo);
                header('Location: ' . $_SERVER['PHP_SELF']);  
                exit();
            }catch(PDOException $exp){
                echo "Database error: " . $exp->getMessage();
            }
        }

    }


    if(isset($_POST['trash'])){
        $Id = (int)$_POST['idcat'];
        $sql = "DELETE FROM Category WHERE id = ?";
        try{
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$Id]);
            if($stmt->rowCount()>0){
                $mesg = "Categorie deleted successfully";
            }else{
                $mesg = "Categorie no deleted";
            }
            header('Location: '. $_SERVER['PHP_SELF']);
        }catch(PDOException $e) {
            echo "Error deleting record: " . $pdo->error . ". ".$e->getMessage();
        }
    }
$pdo =null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>QuizMaster - Espace Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation Enseignant -->
    <?php include_once('nav.php'); ?>
    <!-- Quiz Section -->
    <div id="teacherSpace" class="pt-16">
        <?= $categories['id'];?>
        <div id="quiz" class="section-content">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Mes Quiz</h2>
                        <p class="text-gray-600 mt-2">Créez et gérez vos quiz</p>
                    </div>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post"></form>
                    <button onclick="openModal('createQuizModal')" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        <i class="fas fa-plus mr-2"></i>Créer un Quiz
                    </button>
                </div>
            </div>
            <!-- Quiz List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full"><?= $categories['nom'];?></span>
                            <div class="flex gap-2">
                                <button class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Les Bases de HTML5</h3>
                        <p class="text-gray-600 mb-4 text-sm">Testez vos connaissances sur les éléments HTML5</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-question-circle mr-1"></i>20 questions</span>
                            <span><i class="fas fa-user-friends mr-1"></i>45 participants</span>
                        </div>
                        <button class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                            <i class="fas fa-eye mr-2"></i>Voir les résultats
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Modal: Créer Quiz -->
    <div id="createQuizModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Créer un Quiz</h3>
                    <button onclick="closeModal('createQuizModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form method='post'>
                    <?= $userCategories['id']; ?>
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Titre du quiz *
                            </label>
                            <input type="text" name="titre" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Ex: Les Bases de HTML5">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Catégorie *
                            </label>
                            <select name="categorie_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Sélectionner une catégorie</option>
                                <?php foreach($userCategories as $cat): ?>
                                <option value="<?= $cat['id'];?>"><?= $cat['id'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Décrivez votre quiz..."></textarea>
                    </div>

                    <hr class="my-6">
                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('createQuizModal')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Annuler
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-check mr-2"></i>Créer le Quiz
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src='assets/script.js'></script>
</body>
</html>