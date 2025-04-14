<script>
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(init);

        function init() {
            drawTempChart();
            drawHumidityChart();
            drawCO2Chart();
        }

        function drawTempChart() {
            const data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Čas');
            data.addColumn('number', 'Vnitřní teplota');
            data.addColumn('number', 'Venkovní teplota');

            <?php foreach ($mereni as $zaznam): ?>
                data.addRow([
                    new Date('<?= $zaznam['cas_mereni'] ?>'),
                    <?= $zaznam['teplota'] ?>,
                    <?= $zaznam['teplota_venkovni'] ?>
                ]);
            <?php endforeach; ?>

            const options = {
                title: 'Průběh teplot',
                curveType: 'function',
                legend: 'bottom',
                hAxis: { format: 'HH:mm' }
            };

            new google.visualization.LineChart(
                document.getElementById('tempChart')
            ).draw(data, options);
        }

        function drawHumidityChart() {
            const data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Čas');
            data.addColumn('number', 'Vlhkost');

            <?php foreach ($mereni as $zaznam): ?>
                data.addRow([
                    new Date('<?= $zaznam['cas_mereni'] ?>'),
                    <?= $zaznam['vlhkost'] ?>
                ]);
            <?php endforeach; ?>

            const options = {
                title: 'Průběh vlhkosti',
                curveType: 'function',
                legend: 'none',
                hAxis: { format: 'HH:mm' }
            };

            new google.visualization.LineChart(
                document.getElementById('humidityChart')
            ).draw(data, options);
        }

        function drawCO2Chart() {
            const data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Čas');
            data.addColumn('number', 'CO₂');

            <?php foreach ($mereni as $zaznam): ?>
                data.addRow([
                    new Date('<?= $zaznam['cas_mereni'] ?>'),
                    <?= $zaznam['koncentrace_co2'] ?>
                ]);
            <?php endforeach; ?>

            const options = {
                title: 'Průběh CO₂',
                curveType: 'function',
                legend: 'none',
                hAxis: { format: 'HH:mm' }
            };

            new google.visualization.LineChart(
                document.getElementById('co2Chart')
            ).draw(data, options);
        }

        window.addEventListener('resize', init);
</script>