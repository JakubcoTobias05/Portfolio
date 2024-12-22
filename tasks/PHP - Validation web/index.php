<?php
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateAddress($address) {
    return preg_match('/\d{1,}/', $address);
}

$errors = [];
$success = false;
$firstName = $lastName = $email = $phone = $address = $city = $message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!validateEmail($email)) {
        $errors[] = 'E-mail má nesprávný formát.';
    }

    if (strlen($phone) < 9) {
        $errors[] = 'Telefon musí mít minimálně 9 znaků.';
    }

    if (!validateAddress($address)) {
        $errors[] = 'Adresa musí obsahovat číslo popisné.';
    }

    if (strlen($message) > 255) {
        $errors[] = 'Zpráva může mít maximálně 255 znaků.';
    }

    if (empty($errors)) {
        $success = true;
    }
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
                    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">

                    <label for="lastName">Příjmení:</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">

                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

                    <label for="phone">Telefon:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

                    <label for="address">Adresa:</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">

                    <label for="city">Město:</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>">

                    <label for="message">Zpráva:</label>
                    <textarea id="message" name="message" maxlength="255"><?php echo htmlspecialchars($message); ?></textarea>

                    <button type="submit">Odeslat</button>
                </form>
            </div>
        </section>

        <div id="alertContainer"></div>

        <?php if ($success): ?>
            <section class="submitted-info">
                <div class="container">
                    <h3>Úspěšně odesláno:</h3>
                    <ul>
                        <li><strong>Jméno:</strong> <?php echo htmlspecialchars($firstName); ?></li>
                        <li><strong>Příjmení:</strong> <?php echo htmlspecialchars($lastName); ?></li>
                        <li><strong>E-mail:</strong> <?php echo htmlspecialchars($email); ?></li>
                        <li><strong>Telefon:</strong> <?php echo htmlspecialchars($phone); ?></li>
                        <li><strong>Adresa:</strong> <?php echo htmlspecialchars($address); ?></li>
                        <li><strong>Město:</strong> <?php echo htmlspecialchars($city); ?></li>
                        <li><strong>Zpráva:</strong> <?php echo htmlspecialchars($message); ?></li>
                    </ul>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <script src="js/script.js" defer></script>
    
    <script>
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                showAlert('<?php echo $error; ?>');
            <?php endforeach; ?>
        <?php elseif ($success): ?>
            showAlert('Formulář byl úspěšně odeslán!', 'success');
        <?php endif; ?>
    </script>
</body>
</html>
