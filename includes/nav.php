<?php
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['dashboard'])){
        header('Location: ../enseignant/Ensignant.php');
        exit();
        } 
        if(isset($_POST['NouvelleQuiz'])){
            header('Location: add_quiz.php');
            exit();
        } 
        if(isset($_POST['NouvelleCategorie'])){
            header('Location: ../enseignant/add_categorie.php');
            exit();
        } 
        if(isset($_POST['Results'])){
            header('Location: ../enseignant/manage_quizzes.php');
            exit();
        }
        if(isset($_POST['creerQuiz'])){
            header('Location: ../enseignant/add_quiz.php');
            exit();
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Navigation Enseignant -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-graduation-cap text-3xl text-indigo-600"></i>
                        <span class="ml-2 text-2xl font-bold text-gray-900">QuizMaster</span>
                        <span class="ml-3 px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">Enseignant</span>
                    </div>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <form action="<?php strip_tags($_SERVER['PHP_SELF']); ?>" method="post">
                            <button type='submit' name="dashboard" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-home mr-2"></i>Tableau de bord
                            </button>

                            <button type='submit' name="NouvelleCategorie" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-folder mr-2"></i>Catégories
                            </button>

                            <button type='submit' name="NouvelleQuiz" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-clipboard-list mr-2"></i>Mes Quiz
                            </button>

                            <button type='submit' name="Results" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-chart-bar mr-2"></i>Résultats
                            </button>
                        </Form>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="hidden md:flex md:items-center md:space-x-4">
                        <button class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                        <div class="relative">
                            <button class="flex items-center space-x-3 focus:outline-none" onclick="toggleDropdown()">
                                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                                    AB
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="text-sm font-medium text-gray-900"><?php echo $_SESSION['Name']; ?></div>
                                    <div class="text-xs text-gray-500"><?php echo $_SESSION['Role']; ?></div>
                                </div>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Mon Profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Paramètres
                                </a>
                                <hr class="my-1">
                                <form method="post">
                                    <button name="deconnect" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 w-full text-left">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

</body>
</html>