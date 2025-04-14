<?php
    require_once('Db.php');
    Db::connect('sql.endora.cz:3307', 'validationdb', 'jakubc1718613903', 'LadiesMan217');

    $messages = Db::queryAll('SELECT * FROM messages ORDER BY created_at DESC');
    
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    function validateEmail($email) 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validateAddress($address) 
    {
        return preg_match('/\d{1,}/', $address);
    }

    $errors = [];
    $success = false;


    if (!validateEmail($email)) 
    {
        $errors[] = 'E-mail má nesprávný formát.';
    }

    if (strlen($phone) < 9) 
    {
        $errors[] = 'Telefon musí mít minimálně 9 znaků.';
    }

    if (!validateAddress($address))
    {
        $errors[] = 'Adresa musí obsahovat číslo popisné.';
    }

    if (strlen($message) > 255) 
    {
        $errors[] = 'Zpráva může mít maximálně 255 znaků.';
    }


    if (empty($errors)) 
    {
        Db::insert('messages', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'message' => $message
        ]);

        $success = true;

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();  
    }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/bg2.png" type="image/x-icon">
    <title>Validation web</title>
</head>
<body>
    <main>
        <section class="form-content" id="form-content">
            <div class="container">
                <form id="contactForm" method="POST">
                    <label for="firstName">Jméno:</label>
                    <input type="text" id="firstName" name="firstName" required>
                    
                    <label for="lastName">Příjmení:</label>
                    <input type="text" id="lastName" name="lastName" required>
                    
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="phone">Telefon:</label>
                    <input type="tel" id="phone" name="phone" required>
                    
                    <label for="address">Adresa:</label>
                    <input type="text" id="address" name="address" required>
                    
                    <label for="city">Město:</label>
                    <input type="text" id="city" name="city" required>
                    
                    <label for="message">Zpráva:</label>
                    <textarea id="message" name="message" maxlength="255" required></textarea>
                    
                    <button type="submit">Odeslat</button>
                </form>
            </div>
        </section>

        <section class="message-history">
            <div class="container">
                <h2>Historie zpráv</h2>
                <?php foreach ($messages as $msg): ?>
                    <div class="message-item">
                        <p><strong>Od:</strong> <?= htmlspecialchars($msg['firstName']) ?> <?= htmlspecialchars($msg['lastName']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($msg['email']) ?></p>
                        <p><strong>Telefon:</strong> <?= htmlspecialchars($msg['phone']) ?></p>
                        <p><strong>Adresa:</strong> <?= htmlspecialchars($msg['address']) ?>, <?= htmlspecialchars($msg['city']) ?></p>
                        <p><strong>Zpráva:</strong> <?= htmlspecialchars($msg['message']) ?></p>
                        <p><strong>Odesláno:</strong> <?= date('d.m.Y', strtotime($msg['created_at'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div id="alertContainer"></div>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
