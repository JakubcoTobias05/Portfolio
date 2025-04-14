<?php  
session_start();
require_once('Db.php');

//Db::connect('sql6.webzdarma.cz', 'portfolioxfc4005', 'portfolioxfc4005', '0,^A7*TeXEmYsJrlfYxS');
Db::connect('localhost', 'validationdb', 'root', '');

$allCategories = Db::queryAll('SELECT * FROM categories');
$allClanky = Db::queryAll('SELECT * FROM articles');
$clanky = $allClanky;

if ($_POST && isset($_POST['title']) && isset($_POST['category_id']) && isset($_SESSION['username'])) 
{
    Db::insert('articles', [
        'title' => $_POST['title'],
        'text' => $_POST['text'],
        'author' => $_SESSION['username'],
        'category_id' => $_POST['category_id']
    ]);

    header("Location: index.php");
    exit();
}

if ($_POST && isset($_POST['delete_titleID']))
 {
    Db::query('DELETE FROM articles WHERE id = ?', $_POST['delete_titleID']);
    header("Location: index.php");
    exit();
}

if ($_POST && isset($_POST['update_titleID'])) 
{
    Db::update('articles', [
        'text' => $_POST['update_text']
    ], 'WHERE id = ?', $_POST['update_titleID']);
    header("Location: index.php");
    exit();
}

if ($_GET && isset($_GET['category_id'])) 
{
    $category_id = $_GET['category_id'];
    $clanky = Db::queryAll('SELECT * FROM articles WHERE category_id = ?', $category_id);
}

if ($_POST && isset($_POST['search'])) 
{
    $search = '%' . $_POST['search'] . '%';
    $clanky = Db::queryAll('SELECT * FROM articles WHERE title LIKE ?', $search);
}
?>

<!doctype html>
<html lang="cs">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <title>webDb</title>
</head>
<body>
    <section class="main">
        <div class="container">
            <div class="user-container">
                <?php if (isset($_SESSION['username'])): ?>
                    <p>Přihlášen jako: <?= $_SESSION['username'] ?></p>
                <?php else: ?>
                    <a href="./pages/login.php">Přihlásit se</a>
                    <a href="./pages/registration.php">Registrovat se</a>
                <?php endif; ?>
            </div>

            <div class="Search-bar">
                <h2>Vyhledávání</h2>
                <form method="POST">
                    <input type="search" name="search" id="search" placeholder="Vyhledat článek">
                    <button type="submit">Vyhledat</button>
                </form>
            </div>

            <form method="GET">
                <select name="category_id">
                    <option value="" disabled selected>Všechny kategorie</option>
                    <?php foreach ($allCategories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Filtruj</button>
            </form>

            <table id="customers">
                <tr>
                    <th>ID</th>
                    <th>Titulek</th>
                    <th>Text</th>
                    <th>Nový text</th>
                    <th>Akce</th>
                </tr>
                <?php foreach ($clanky as $clanek): ?>
                    <tr>
                        <td><?= $clanek['id'] ?></td>
                        <td><?= $clanek['title'] ?></td>
                        <td><?= $clanek['text'] ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="update_titleID" value="<?= $clanek['id'] ?>" required>
                                <textarea name="update_text" required><?= $clanek['text'] ?></textarea>
                                <button type="submit">Aktualizovat</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="delete_titleID" value="<?= $clanek['id'] ?>" required>
                                <button type="submit">Smazat</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php if (isset($_SESSION['username'])): ?>
                <form class="insert-form" method="POST">
                    <h2>Vložit článek</h2>
                    <input type="text" name="title" placeholder="Název článku" required>
                    <input type="text" name="text" placeholder="Text" required>
                    <input type="text" name="author" placeholder="Autor" value="<?= $_SESSION['username'] ?>" readonly>
                    <select name="category_id" required>
                        <option value="" disabled selected>Vyberte kategorii</option>
                        <?php foreach ($allCategories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Vložit</button>           
                </form>

                <a href="./pages/logout.php">Odhlásit se</a>
            <?php else: ?>
                <p>Pro přidání článku se musíte <a href="./pages/login.php">přihlásit</a>.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>