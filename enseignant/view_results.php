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
    header('location:login.php');
        exit();
    }

    if(isset($_POST['deconnect'])){
        header('location:deconnect.php');
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
    <?php include_once('nav.php'); ?>

    <div id="teacherSpace" class="pt-16">


    </div>
      <script src='assets/script.js'></script>
</body>
</html>