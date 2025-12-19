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

    if(isset($_SESSION["Role"])){
        if($_SESSION["Role"] != "enseignant"){
            header('location: Error401.php');
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
    <?php include_once('../includes/nav.php'); ?>
    <!-- Results Section -->
<div id="teacherSpace" class="pt-16">
    <div id="results" class="section-content ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Résultats des Étudiants</h2>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Étudiant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quiz</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold mr-3">
                                            YK
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">Youssef Kadiri</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Les Bases de HTML5</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-green-600">18/20</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">04 Déc 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Réussi
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
  <script src='../script.js'></script>
</body>
</html>