<?php
    require_once '../config.php';

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        die(json_encode(["error" => "Nepřihlášený uživatel."]));
    }

    $user = Db::queryOne("SELECT latitude, longitude FROM users WHERE id = ?", $_SESSION['user_id']);

    if (!$user || !$user['latitude'] || !$user['longitude']) {
        http_response_code(400);
        die(json_encode(["error" => "Lokace není nastavena."]));
    }

    $lat = $user['latitude'];
    $lon = $user['longitude'];
    $apiKey = 'a2ee36b2b1984d8ea47175921251304';

    $url = "https://api.openweathermap.org/data/3.0/onecall?lat={$lat}&lon={$lon}&exclude=minutely,hourly,daily,alerts&appid={$apiKey}&units=metric";
    $response = file_get_contents($url);

    if ($response === false) {
        http_response_code(500);
        die(json_encode(["error" => "Chyba při získávání dat o počasí."]));
    }

    $data = json_decode($response, true);
    echo json_encode($data);
?>
