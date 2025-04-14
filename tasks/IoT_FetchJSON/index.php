<?php
require_once 'Db.php';

try {
    //Db::connect('sql6.webzdarma.cz', 'portfolioxfc4005', 'portfolioxfc4005', '0,^A7*TeXEmYsJrlfYxS');
    Db::connect('localhost', 'iot_database', 'root', '');

    Db::query("
        CREATE TABLE IF NOT EXISTS sensor_data (
            id INT PRIMARY KEY AUTO_INCREMENT,
            teplota FLOAT,
            vlhkost FLOAT,
            koncentrace_co2 INT,
            rosny_bod FLOAT,
            teplota_venkovni FLOAT,
            cas_mereni DATETIME
        )
    ");

    $papago = json_decode(file_get_contents('https://iot.spst.cz/papago.json'), true);
    $ethernet = json_decode(file_get_contents('https://iot.spst.cz/ethernet.json'), true);
    

    $casMereni = DateTime::createFromFormat('d.m.Y H:i:s', $papago['casMereni']);
    if (!$casMereni) {
        $casMereni = new DateTime($papago['casMereni']);
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
        WHERE cas_mereni >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
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
    <title>IoT Monitoring</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
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
        
        <div class="chart-section">
            <div class="chart-header">Teplota</div>
            <div class="chart-body">
                <div id="tempChart" class="chart"></div>
            </div>
        </div>

        <div class="chart-section">
            <div class="chart-header">Vlhkost</div>
            <div class="chart-body">
                <div id="humidityChart" class="chart"></div>
            </div>
        </div>

        <div class="chart-section">
            <div class="chart-header">CO₂</div>
            <div class="chart-body">
                <div id="co2Chart" class="chart"></div>
            </div>
        </div>
    </div>

    <?php include_once('charts.php'); ?>
</body>
</html>
