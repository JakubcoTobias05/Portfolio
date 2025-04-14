<?php
    require_once('../Db.php');
    session_start();
    Db::connect('localhost', 'validationdb', 'root', '');

    if ($_POST && isset($_POST['username']) && isset($_POST['password'])) 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = Db::queryOne('SELECT * FROM users WHERE username = ?', $username);

        if ($user && password_verify($password, $user['password'])) 
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../index.php");
            exit();
        } 
        else 
        {
            $error = "Nesprávné uživatelské jméno nebo heslo.";
        }
    }
?>

<!doctype html>
<html lang="cs">
<head>
    <meta charset="utf-8"/>
    <title>Přihlašovací stránka</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
</head>
<body>
    <div class="center">
        <h2>Přihlášení</h2>
        <?php if (isset($error)): ?>
            <p><?= $error ?></p>
        <?php endif; ?>
   
        <form method="POST">
            <input type="text" name="username" placeholder="Uživatelské jméno" required>
            <input type="password" name="password" placeholder="Heslo" required>
            <button type="submit">Přihlásit</button>
        </form>
    </div>
</body>
</html>