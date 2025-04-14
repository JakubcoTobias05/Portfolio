<?php
    require_once('../Db.php');
    Db::connect('localhost', 'validationdb', 'root', '');

    if ($_POST && isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        Db::insert('users', [
            'username' => $username,
            'password' => $password
        ]);

        header("Location: login.php");
        exit();
    }
?>

<!doctype html>
<html lang="cs">
<head>
    <meta charset="utf-8"/>
    <title>Registrace</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
</head>
<body>
    <div class="center">
        <h2>Registrace</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Uživatelské jméno" required>
            <input type="password" name="password" placeholder="Heslo" required>
            <button type="submit">Registrovat</button>
        </form>
    </div>
</body>
</html>