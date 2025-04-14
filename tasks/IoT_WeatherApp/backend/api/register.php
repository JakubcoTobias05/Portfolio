<?php
require_once '../config.php';
if (empty($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['recaptcha_token'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $recaptchaToken = $_POST['recaptcha_token'];

    if (empty($recaptchaToken)) {
        http_response_code(400);
        die(json_encode(["error" => "Prosím ověřte, že nejste robot."]));
    }

    $secret_key = '6LdZVRcrAAAAAOafVAyAMMy9SpohcWbVPjs6LpHy';
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptchaToken;
    $response = file_get_contents($url);
    $responseData = json_decode($response);
    if (!$responseData->success) {
        http_response_code(400);
        die(json_encode(["error" => "reCAPTCHA ověření selhalo."]));
    }

    $existingUser = Db::queryOne("SELECT id FROM users WHERE email = ?", $email);
    if ($existingUser) {
        http_response_code(400);
        die(json_encode(["error" => "Účet s daným emailem již existuje."]));
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $result = Db::insert('users', [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPass
    ]);
    if ($result) {
        echo json_encode(["success" => true, "message" => "Registrace proběhla úspěšně."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Chyba při registraci."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Neplatný požadavek."]);
}
?>
