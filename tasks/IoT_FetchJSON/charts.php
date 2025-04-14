<?php
if (!isset($mereni)) {
    die("Data nebyla načtena.");
}

$mereniAsc = array_reverse($mereni);

$tempChartData = [['Čas', 'Teplota']];
$humidityChartData = [['Čas', 'Vlhkost']];
$co2ChartData = [['Čas', 'CO₂']];

foreach ($mereniAsc as $row) {
    $timestamp = strtotime($row['cas_mereni']);

    if ($timestamp === false) {
        continue;
    }
    $time = date("H:i", $timestamp);
    $tempChartData[] = [$time, floatval($row['teplota'])];
    $humidityChartData[] = [$time, floatval($row['vlhkost'])];
    $co2ChartData[] = [$time, floatval($row['koncentrace_co2'])];
}
?>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawCharts);
    
    function drawCharts() {
        var tempData = google.visualization.arrayToDataTable(<?php echo json_encode($tempChartData); ?>);
        var tempOptions = {
            title: 'Teplota (vnitřní)',
            curveType: 'function',
            legend: { position: 'bottom' },
            tooltip: { trigger: 'focus' },
            crosshair: { color: '#ccc', trigger: 'both' },
            pointSize: 5
        };
        var tempChart = new google.visualization.LineChart(document.getElementById('tempChart'));
        tempChart.draw(tempData, tempOptions);
        
        var humidityData = google.visualization.arrayToDataTable(<?php echo json_encode($humidityChartData); ?>);
        var humidityOptions = {
            title: 'Vlhkost',
            curveType: 'function',
            legend: { position: 'bottom' },
            tooltip: { trigger: 'focus' },
            crosshair: { color: '#ccc', trigger: 'both' },
            pointSize: 5
        };
        var humidityChart = new google.visualization.LineChart(document.getElementById('humidityChart'));
        humidityChart.draw(humidityData, humidityOptions);
        
        var co2Data = google.visualization.arrayToDataTable(<?php echo json_encode($co2ChartData); ?>);
        var co2Options = {
            title: 'Koncentrace CO₂',
            curveType: 'function',
            legend: { position: 'bottom' },
            tooltip: { trigger: 'focus' },
            crosshair: { color: '#ccc', trigger: 'both' },
            pointSize: 5
        };
        var co2Chart = new google.visualization.LineChart(document.getElementById('co2Chart'));
        co2Chart.draw(co2Data, co2Options);
    }
    
    window.addEventListener('resize', drawCharts);
</script>
