<?php
require_once 'Db.php';

try {
    Db::connect('sql111.infinityfree.com', 'if0_38713593_iot_database', 'if0_38713593', '8NezEJs9Ba');
    
    Db::query("
        CREATE TABLE IF NOT EXISTS sensor_data (
            id INT PRIMARY KEY AUTO_INCREMENT,
            teplota FLOAT,
            vlhkost FLOAT,
            koncentrace_co2 INT,
            rosny_bod FLOAT,
            teplota_venkovni FLOAT,
            cas_mereni DATETIMEd
        )
    ");
    
    $papago = json_decode(file_get_contents('https://iot.spst.cz/papago.json'), true);
    $ethernet = json_decode(file_get_contents('https://iot.spst.cz/ethernet.json'), true);
    
    $casMereni = DateTime::createFromFormat('m/d/Y  H:i:s', $papago['casMereni']);
    if (!$casMereni) {
        throw new Exception('Neplatný formát data');
    }
    
    Db::insert('sensor_data', [
        'teplota' => $papago['teplota'],
        'vlhkost' => $papago['vlhkost'],
        'koncentrace_co2' => $papago['koncentraceCO2'],
        'rosny_bod' => $papago['rosnyBod'],
        'teplota_venkovni' => $ethernet['teplotaVenkovni'],
        'cas_mereni' => $casMereni->format('Y-m-d H:i:s')
    ]);
    
    $mereni = Db::queryAll("
        SELECT 
            cas_mereni,
            teplota,
            teplota_venkovni,
            vlhkost,
            koncentrace_co2 
        FROM sensor_data 
        ORDER BY cas_mereni DESC 
        LIMIT 24
    ");

} catch (Exception $e) {
    die('Chyba: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IoT Monitor</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="container">
        <h1>Monitorování prostředí</h1>
        
        <div class="data-grid">
            <div class="data-card">
                <h2>Vnitřní podmínky</h2>
                <p>Teplota: <?= htmlspecialchars($papago['teplota']) ?> °C</p>
                <p>Vlhkost: <?= htmlspecialchars($papago['vlhkost']) ?> %</p>
                <p>CO₂: <?= htmlspecialchars($papago['koncentraceCO2']) ?> ppm</p>
                <p>Rosný bod: <?= htmlspecialchars($papago['rosnyBod']) ?> °C</p>
            </div>
            
            <div class="data-card">
                <h2>Venkovní podmínky</h2>
                <p>Teplota: <?= htmlspecialchars($ethernet['teplotaVenkovni']) ?> °C</p>
            </div>
        </div>

        <div id="tempChart" class="chart"></div>
        <div id="humidityChart" class="chart"></div>
        <div id="co2Chart" class="chart"></div>
    </div>

    <?php include_once('charts.php')?>
</body>
</html>