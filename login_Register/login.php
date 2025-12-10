
<?php


session_start();

    include_once('database.php');
    $errors = array();

if (isset($_POST['Log'])) {

    $email = trim($_POST['email'] ?? '') ;
    $pass  = trim($_POST['password'] ?? '');


    if (empty($email)) {
        array_push($errors,"Email is empty!");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors,"Email is not valid!");
    }

    if (empty($pass)) {
        array_push($errors,"Password is empty!");
    } elseif (strlen($pass) < 12) {
        array_push($errors,"Password should be at least 12 characters!");
    }


    if (count($errors) > 0) {
        try {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user_exist = $stmt->fetch();

        if (!$user_exist) {
            echo "<div style='background:#fa9595;color:red;padding:6px;border-radius:10px;margin:4px auto;font-size:large;'>Email incorrect!</div>";
        } elseif (!password_verify($pass, $user_exist['pass'])) {
            echo "<div style='background:#fa9595;color:red;padding:6px;border-radius:10px;margin:4px auto;font-size:large;'>Password incorrect!</div>";
        } else {

            echo "login success";
            header("Location: index.php");
            exit;
        }

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }

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
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    

        <form class="max-w-sm" action="" method="POST">
        <div class="mb-5">
            <label for="email-alternative" class="block mb-2.5 text-sm font-medium text-heading">Your email</label>
            <input type="email" name='email' id="email-alternative" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow placeholder:text-body" placeholder="exemple@email.com" />
        </div>
        <div class="mb-5">
            <label for="password-alternative" class="block mb-2.5 text-sm font-medium text-heading">Your password</label>
            <input type="password" name='password' id="password-alternative" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow placeholder:text-body" placeholder="password" />
        </div>
        <div class="flex items-start mb-5">
            <label for="remember-alternative" class="flex items-center h-5">
            <input id="remember-alternative" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" required />
            <p class="ms-2 text-sm font-medium text-heading select-none">I accept cookies and sessions <a href="#" class="text-fg-brand hover:underline"> also terms and conditions this site</a>.</p>
            </label>
        </div>
        <button type="submit" name="Log" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none cursor-pointer">Login</button>
        </form>


</body>
</html>
