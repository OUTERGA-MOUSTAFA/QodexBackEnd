<?php 
session_start();

if(!isset($_SESSION['Name'] , $_SESSION['Role'])){

    header('location:../auth/register.php');
    exit();
}elseif(!isset($_SESSION['Email'])){
        header('location:../auth/login.php');
        exit();
}else{      
    if($_SESSION['Role'] ==='enseignant'){
        header('location:../enseignant/Ensignant.php');
        exit();
    }elseif($_SESSION['Role'] ==='etudiant'){
        header('location:../etudiant/Etudiant.php');
        exit();
    }
}
?>