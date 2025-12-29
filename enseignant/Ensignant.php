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

        echo '<pre>';
        print_r($_SERVER);
            echo '<pre>';

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
?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMaster - Espace Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation Enseignant -->
    <?php include_once('../includes/nav.php'); ?>
    <!-- ESPACE ENSEIGNANT -->
    <div id="teacherSpace" class="pt-16">
        
        <!-- Dashboard Section -->
        <div id="dashboard" class="section-content">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <h1 class="text-4xl font-bold mb-4">Tableau de bord Enseignant</h1>
                    <p class="text-xl text-indigo-100 mb-6">Gérez vos quiz et suivez les performances de vos étudiants</p>
                    <div class="flex gap-4">
                        <form action="<?= strip_tags($_SERVER['PHP_SELF']);?>" method="post">
                            <button name="NouvelleCategorie" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition">
                                <i class="fas fa-folder-plus mr-2"></i>Nouvelle Catégorie
                            </button>
                        
                            <button name='NouvelleQuiz' class="bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-800 transition">
                                <i class="fas fa-plus-circle mr-2"></i>Créer un Quiz
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total Quiz</p>
                                <p class="text-3xl font-bold text-gray-900">24</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <i class="fas fa-clipboard-list text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Catégories</p>
                                <p class="text-3xl font-bold text-gray-900">8</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <i class="fas fa-folder text-purple-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Étudiants Actifs</p>
                                <p class="text-3xl font-bold text-gray-900">156</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <i class="fas fa-user-graduate text-green-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Taux Réussite</p>
                                <p class="text-3xl font-bold text-gray-900">87%</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-lg">
                                <i class="fas fa-chart-line text-yellow-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <script src='../script.js'></script>
</body>
</html>







                                        