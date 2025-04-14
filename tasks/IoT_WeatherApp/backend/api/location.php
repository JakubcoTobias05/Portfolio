<?php
    require_once '../config.php';

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        die(json_encode(["error" => "Nepřihlášený uživatel."]));
    }

    $city = $_POST['city'];
    $apiKey = 'YOUR_OPENWEATHERMAP_API_KEY';
    $geoUrl = "http://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($city) . "&limit=1&appid={$apiKey}";
    $geoResponse = file_get_contents($geoUrl);
    $geoData = json_decode($geoResponse, true);

    if (!$geoData || count($geoData) === 0) {
        http_response_code(404);
        die(json_encode(["error" => "Lokace nebyla nalezena."]));
    }

    $latitude = $geoData[0]['lat'];
    $longitude = $geoData[0]['lon'];

    $userId = $_SESSION['user_id'];
    $result = Db::update('users', [
        'latitude' => $latitude,
        'longitude' => $longitude
    ], "WHERE id = {$userId}");

    if ($result) {
        echo json_encode(["success" => true, "message" => "Lokace byla úspěšně nastavena."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Chyba při ukládání lokace."]);
    }
?>
