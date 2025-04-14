<?php
require_once '../config.php';
if (empty($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = Db::queryOne("SELECT * FROM users WHERE email = ?", $email);
    if (!$user || !password_verify($password, $user['password'])) {
        http_response_code(401);
        die(json_encode(["error" => "Neplatné přihlašovací údaje."]));
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    echo json_encode([
      "success" => true,
      "message" => "Přihlášení úspěšné.",
      "user" => ["name" => $user['name'], "email" => $user['email']]
    ]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Neplatný požadavek."]);
}
?>
