
<?php
    if(isset($_POST['btnSubmit'])){
        // filter_var($_POST['name'], FILTER_SANITIZE_STRING); ==> kathiyed tag html
        // filter_var($_POST['name'], FILTER_SANITIZE_STRING); ==> kathiyed tag html
        // htmlspecialchars ==> mkat9rax les tag html et css
        $F_name =htmlspecialchars(trim($_POST['first_name'])) ;
        $Role = htmlspecialchars(trim($_POST['roles'] ?? ''));
        $email = htmlspecialchars(trim($_POST['email']));
        $pass = htmlspecialchars(trim($_POST['password']));
        $repeat_pass = trim($_POST['repeat_password']);
        //$age = filter_var($_POST['age'],FILTER_VALIDATE_NUMBER_INT); => kat9bel num avec - ou +
        $errorsname = '';
        $errorsrole = '';
            $errorsemail = '';
            $errorspass = '';
            $errorsrepeatpass = '';
        if(empty($F_name)){
            $errorsname = "First Name is empty";
        }

        if($Role == "" ){
            $errorsrole ="Choose your Role";
        }

        if(empty($pass)){
            $errorspass = "password is empty";
        }elseif( strlen($pass)>0&&strlen($pass)<8 ){
            $errorspass = "password shold be more or equal 8 !";
        }

        if(empty($repeat_pass)){
            $errorsrepeatpass = "repeat password is empty";
        }elseif($repeat_pass !== $pass){
            $errorsrepeatpass ='repeat password not valid';
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errorsemail ='email is not valid';
        }
        include_once('../config/database.php');
        $sql = "SELECT * from users where email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $exist = $stmt->fetch();
        if($exist){
            $errorsemail = "This email is already used!";
            $pdo = null;
        }
        if($errorsname == "" && $errorsrole == ""  && $errorspass == "" && $errorsrepeatpass == "" && $errorsemail == ""){
            //insertion data to database

            // 1- connection a la database
            include('database.php');
            // let's hash password 
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
            $sql ="INSERT INTO users (Name,Role,email, Pass)
                            VALUES(?,?,?,?)";
            try {

                $stmt = $pdo->prepare($sql);
                $stmt->execute([$F_name, $Role, $email, $hashedPassword]);
                
                echo "<script>
                    alert('$F_name registered successfully!');
                    window.location.href='login.php';
                    </script>";
            } catch (PDOException $e) {
                echo "Database errors Moustafa write this problem on register page: " . $e->getMessage();
            }
            $pdo = null;
            
        }
}
   if(isset($_POST['login'])){
    header('Location:login.php');
    exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <main>
        <?php 
        
        
        ?>
        <form method="POST" >
            <fieldset class="w-sm p-10 mx-auto bg-green">
                <legend class="text-green">Register</legend>
            
     <div class="grid md:grid-cols-2 md:gap-6">
       <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="first_name" id="floating_first_name" placeholder=" "
                class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
            <label for="first_name" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Name
            </label>
        </div>
        
        <div class="relative z-0 w-full mb-5 group">
            
            <select id="roles"  name="roles" placeholder=" " class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer">
                <option value='' selected>Role</option>
                <option value='etudiant'>Etudiant</option>    
                <option value='enseignant'>Enseignant</option>
            </select>
            <label for="roles" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto"></label>
            
        </div>
         
    </div>

    <?php if (!empty($errorsname)) : ?>
        <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
            <?= $errorsname ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($errorsrole)) : ?>
        <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
            <?= $errorsrole ?>
        </div>
    <?php endif; ?>

    <div class="relative z-0 w-full mb-5 group">
        <input type="email" name="email" id="floating_email" placeholder=" " class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
        <label for="email" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Email</label>
    </div>
     <?php if (!empty($errorsemail)) : ?>
            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                <?= $errorsemail ?>
            </div>
        <?php endif; ?>
    <div class="relative z-0 w-full mb-5 group">
        <input type="password" name="password" id="floating_password" placeholder=" " class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"  />
        <label for="password" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Password</label>
    </div>
    <?php if (!empty($errorspass)) : ?>
            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                <?= $errorspass ?>
            </div>
        <?php endif; ?>
    <div class="relative z-0 w-full mb-5 group">
        <input type="password" name="repeat_password" id="floating_repeat_password" placeholder=" " class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"  />
        <label for="floating_repeat_password" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Confirm password</label>
    </div>
     <?php if (!empty($errorsrepeatpass )) : ?>
            <div style="display:block;margin:2px auto; color:red; padding:6px;border-radius:10px; background:#fa9595;font-size:large;">
                <?= $errorsrepeatpass ?>
            </div>
        <?php endif; ?>
   
        <div class="flex items-start mb-5">
            <label for="remember-alternative" class="flex items-center h-5">
            <input id="remember-alternative" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" />
            <p class="ms-2 text-sm font-medium text-heading select-none">I accept cookies and sessions <a href="#" class="text-fg-brand hover:underline"> also terms and conditions this site</a>.</p>
            </label>
        </div>
        <div class="footerForm">
            <button type="submit" name="btnSubmit" class="cursor-pointer text-white bg-green rounded-md box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Enregistre</button>
            <button  tuype="button" name='login' class="cursor-pointer text-white bg-green rounded-md box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                Login
            </button>
        </div>
    </fieldset>
    </form>
    </main>
</body>
</html>