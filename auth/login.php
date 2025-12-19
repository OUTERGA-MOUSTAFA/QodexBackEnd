
<?php
if (session_status() === 'PHP_SESSION_NONE') {
    session_start();
}
if(isset($_POST['register'])){
    header('Location:register.php');
    exit();
}
if(isset($_SESSION['Name'] , $_SESSION['Role'])){
    if($_SESSION['Role']!='etudiant'){
        header('location:../enseignant/Ensignant.php');
        exit();
    }elseif($_SESSION['Role']!='enseignant'){
        header('location:../etudiant/Etudiant.php');
        exit();
    }
    header('location:register.php');
    exit();
}
    include_once('../config/database.php');
    $errorsEmail ='';
    $errorspass = '';

if (isset($_POST['Log'])) {

    $email =htmlspecialchars(trim($_POST['email'] ?? '')) ;
    $pass  = htmlspecialchars(trim($_POST['password'] ?? ''));

    if (empty($pass)) {
        $errorspass = "Password is empty!";
    } elseif (strlen($pass) < 8) {
        $errorspass = "your password at least was 8 characters!";
    }
    
    if (empty($email)) {
        $errorsEmail = "Email is empty!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorsEmail = "Email is not valid!";
    }
    if(strlen($errorspass) == 0 && strlen($errorsEmail) ==0){

        $sql = "SELECT * FROM users WHERE email = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $user_exist = $stmt->fetch();
            if (!$user_exist) {
                $errorsEmail = "Email incorrect!";
            }elseif (!password_verify($pass, $user_exist['Pass'])) {
                $errorspass = "Password incorrect!";
            }
        } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        }

    }
    if (strlen($errorspass) == 0 && strlen($errorsEmail) ==0) {
        
        echo "<script>alert('login success!');</script>";
        $_SESSION['Name']  = $user_exist['Name'];
        $_SESSION['Role']  = $user_exist['Role'];
        $_SESSION['Email'] = $email;
        header("location: session.php");
        $pdo = null;
    }       
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    

        <form class="max-w-sm" method="POST">
        <?php  if(strlen($errorsEmail)>0): ?>
            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                <?= $errorsEmail ?>
            </div>
        <?php endif; ?>
        <div class="mb-5">
            <label for="email-alternative" class="block mb-2.5 text-sm font-medium text-heading">Your email</label>
            <input type="email" name='email' id="email-alternative" class="bg-neutral-secondary-medium border border-default-medium hover:bg-[#005461] text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow placeholder:text-body" placeholder="exemple@email.com" />
        </div>
        <?php if(strlen($errorspass)>0): ?>
            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                <?= $errorspass?>
            </div>
        <?php endif; ?>
        <div class="mb-5">
            <label for="password-alternative" class="block mb-2.5 text-sm font-medium text-heading">Your password</label>
            <input type="password" name='password' id="password-alternative" class="bg-neutral-secondary-medium border border-default-medium text-heading hover:bg-[#005461] text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow placeholder:text-body" placeholder="password" />
        </div>
                
        <div class="flex items-start mb-5">
            <label for="remember-alternative" class="flex items-center h-5">
            <input id="remember-alternative" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" />
            <p class="ms-2 text-sm font-medium text-heading select-none">I accept cookies and sessions <a href="#" class="text-fg-brand hover:underline"> also terms and conditions this site</a>.</p>
            </label>
        </div>
        <div class="footerForm">
            <button type="submit" name="Log" class="text-white bg-[#0f1419] hover:bg-[#00B7B5]/90 focus:ring-4 focus:outline-none focus:ring-[#0f1419]/50 box-border border border-transparent font-medium leading-5 rounded-md text-sm px-4 py-2.5 text-center inline-flex items-center dark:hover:bg-[#24292F] dark:focus:ring-[#24292F]/55">Login</button>
            <button type="submit" name='register' class="text-white bg-[#0f1419] hover:bg-[#00B7B5]/90 focus:ring-4 focus:outline-none focus:ring-[#0f1419]/50 box-border border border-transparent font-medium leading-5 rounded-md text-sm px-4 py-2.5 text-center inline-flex items-center dark:hover:bg-[#24292F] dark:focus:ring-[#24292F]/55">Register</button>
        </div>
        </form>


</body>
</html>
