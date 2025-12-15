<?php



    
    if(!isset($_SESSION['Name'] , $_SESSION['Role'])){
    
        header('location:register.php');
    }elseif(!isset($_SESSION['Email'])){
         header('location:login.php');
    }else{      
        if($_SESSION['Role'] ==='enseignant'){
            header('location:Ensignant.php');
        }elseif($_SESSION['Role'] ==='etudiant'){
            header('location:Etudiant.php');
        }
    }

?>