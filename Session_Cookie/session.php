<?php

session_start();

$_SESSION['Email'] = $_POST['email'];

header('location:index.php');
?>