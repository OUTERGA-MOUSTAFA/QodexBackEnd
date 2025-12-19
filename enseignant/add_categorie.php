

<?php
session_start();
    if(isset($_SESSION["Role"])){
        if($_SESSION["Role"] != "enseignant"){
            header('location: ../Error401.php');
            exit();
    }}else{
    header('location:../auth/login.php');
        exit();
    }

    if(isset($_POST['deconnect'])){
        header('location:../Session_Cookie/deconnect.php');
        exit();
    }

    include('../config/database.php');
    
    function getIdEnseignant(PDO $pdo, $email): array{
        $idrequet = 'SELECT id FROM users where email =?';
    
        try {
        $stm = $pdo->prepare($idrequet);
        $stm->execute([$email]);
        $idEnseignant = $stm->fetch()?:[];

        return $idEnseignant;
        }catch(PDOException $e){
            error_log('PDO Error(prepare or execute): ' . $e->getMessage());
        }
        
    }
    function selectcats(PDO $pdo): array{
        $createdCategorie = 'SELECT * FROM Category WHERE created_by =?';
        try{
            $email = $_SESSION['Email'];
            $idEnseignant = getIdEnseignant($pdo, $email);

            $stm = $pdo->prepare($createdCategorie);
            $stm->execute([$idEnseignant['id']]);
            
            return $stm->fetchAll(); 
        }catch(PDOException $e){
            // error_log()  <=  user ل DB ما خاصّش تبان أخطاء 
            echo 'createdCategorie problem |addcategorie <=page Exception|=> ' . $e->getMessage();

        }
    }
    $categories = selectcats($pdo);
    $errorcat = $errordescription = '';
    if(isset($_POST['creer'])){
        $namecategorie = htmlspecialchars(trim($_POST['nom'] ?? ''));
        $description = htmlspecialchars(trim($_POST['description']));
        if(empty($namecategorie)){
            $errorcat = 'Nom catégotie est important';
        }
        if(empty($description)){
            $errordescription = 'description est important';
        }elseif(strlen($description)>100 || strlen($description)<20){
            $errordescription = 'descrition doit étre moin de 100 character et plus de 20';
        }


        if(strlen($errordescription) ==0 && strlen($errorcat)==0){
            
            //=> get id Enseignant from data to link it to categorie created
            
            $emailc= $_SESSION['Email'];
            $idEnseignant = getIdEnseignant($pdo, $emailc);
    
            $requet = 'INSERT INTO Category (nom,description, created_by) VALUES (?,?,?); ';
            
            try{
                $stm =  $pdo->prepare($requet);      
                $stm->execute([$namecategorie,$description,(int)$idEnseignant['id']]);
                // get data of categories for UI
                print_r("<script> alert('Catégorie ". $namecategorie . " ajouter avec succès')") ;
                global $categories;
                $categories = selectcats($pdo);
                
                header('Location: ' . $_SERVER['PHP_SELF']); // Redirects to the current page
                exit();
            }catch(PDOException $exp){
                 echo "Database error: " . $exp->getMessage();
            }
        }
    }
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
            $mesg = "";
            if($stmt->rowCount()>0){
                $mesg = "Categorie deleted successfully";
            }else{
                $mesg = "Categorie no deleted";
            }
            header('Location: '. $_SERVER['PHP_SELF']);
            exit();
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
<body class="bg-gray-50">
    <!-- Navigation Enseignant -->
    <?php include_once('nav.php'); ?>
    <!-- Categories Section -->
<div id="teacherSpace" class="pt-16">
    <div id="categorie" class="section-content">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h2>
                    <p class="text-gray-600 mt-2">Organisez vos quiz par catégories</p>
                </div>
                <button type="button" name='createCategorie' onclick="openModal('createCategoryModal')"  class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    <i class="fas fa-plus mr-2"></i>Nouvelle Catégorie
                </button>
            </div>

            <!-- Categories List -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php
                    foreach($categories as $cat): 
                ?>
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($cat['nom']); ?></h3>
                            <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($cat['description']);?></p>
                        </div>
                        <div class="flex gap-2">
                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <input type="hidden" name="idcat" value="<?= $cat['id']; ?>">
                                <button type="submit" name="edit" onclick="openModal('editCategoryModal')" class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>
                            <form action="<?= strip_tags($_SERVER['PHP_SELF']) ?>" method="POST">
                                <input type="hidden" name="idcat" value="<?= $cat['id']; ?>">
                                <button type="submit" name="trash" class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500"><i class="fas fa-clipboard-list mr-2"></i>12 quiz</span>
                        <span class="text-gray-500"><i class="fas fa-s-friends mr-2"></i>45 étudiants</span>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        
        </div>
    </div>
</div>
    <!-- Modal: Créer Catégorie -->
    <div id="createCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Nouvelle Catégorie</h3>
                    
                    <button type="button" name='openmodal' onclick="closeModal('createCategoryModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">                    
                    <div class="mb-4">
                        <?php if(strlen($errorcat)>0): ?>
                            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                                <?= $errorcat?>
                            </div>
                        <?php endif; ?>
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Nom de la catégorie *
                        </label>
                        <input type="text" name="nom" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Ex: HTML/CSS">
                    </div>

                    <div class="mb-6">
                        <?php if(strlen($errordescription)>0): ?>
                            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                                <?= $errordescription; ?>
                            </div>
                        <?php endif; ?>
                        
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Décrivez cette catégorie..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('createCategoryModal')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Annuler
                        </button>
                        <button type="submit" name='creer' class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-check mr-2"></i>Créer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Modal: Edit Catégorie -->
    <div id="editCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Edit Catégorie</h3>
                    
                    <button type="button" name='openmodal' onclick="closeModal('editCategoryModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
    
                <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">                    
                    <div class="mb-4">
                        
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Nom de la catégorie
                        </label>
                        <?php if(strlen($errornomcate)>0): ?>
                            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                                <?= $errornomcate?>
                            </div>
                        <?php endif; ?>
                        <input type="text" name="Editnom" value="<?= htmlspecialchars($nomCat)?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div class="mb-6">                        
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Description
                        </label>
                         <?php if(strlen($errordescriptioncategorie)>0): ?>
                            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                                <?= $errordescriptioncategorie; ?>
                            </div>
                        <?php endif; ?>
                        <textarea name="Editdescription" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" ><?= htmlspecialchars($descCat)?></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('editCategoryModal')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Annuler
                        </button>
                        <input type="hidden" name="categorie" value="<?= $id; ?>">
                            <button type="submit" name='update' class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-check mr-2"></i>Edit
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src='../script.js'></script>
    <?php if(strlen($errorcat)>0 || strlen($errordescription)>0): ?>
        <script>
            openModal('createCategoryModal');
        </script>
    <?php endif; ?>
    <?php if(isset($_POST['edit']) || strlen($errornomcate)>0 || strlen($errordescriptioncategorie)>0): ?>
        <script>
            openModal('editCategoryModal');
        </script>
    <?php endif; ?>
</body>
</html>