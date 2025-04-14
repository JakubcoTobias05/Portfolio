<?php
    require_once '../config.php';

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        die(json_encode(["error" => "Nepřihlášený uživatel."]));
    }

    $userId = $_SESSION['user_id'];
    $data = Db::queryAll("
        SELECT cas_mereni, teplota, vlhkost, koncentrace_co2 
        FROM weather_data
        WHERE user_id = ?
        AND cas_mereni >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ORDER BY cas_mereni ASC
    ", $userId);

    echo json_encode($data);
?>
