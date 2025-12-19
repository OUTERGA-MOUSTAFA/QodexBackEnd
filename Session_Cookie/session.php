<?php 
session_start();

if(!isset($_SESSION['Name'] , $_SESSION['Role'])){

    header('location:register.php');
    exit();
}elseif(!isset($_SESSION['Email'])){
        header('location:login.php');
        exit();
}else{      
    if($_SESSION['Role'] ==='enseignant'){
        header('location:Ensignant.php');
        exit();
    }elseif($_SESSION['Role'] ==='etudiant'){
        header('location:etudiant/Etudiant.php');
        exit();
    }
}
?>