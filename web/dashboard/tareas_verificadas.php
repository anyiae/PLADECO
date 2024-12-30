<?php
include('../../app/config/config.php');

$estado_counts = [
    'verificadas' => 0,
    'no_verificadas' => 0,
    'sin_revisar' => 0,
];
$total_tareas = 0;

$query = $pdo->query("SELECT verificado FROM tareas");
while ($tarea = $query->fetch(PDO::FETCH_ASSOC)) {
    $estado = $tarea['verificado'] ?? 'sin_revisar';
    if (isset($estado_counts[$estado])) {
        $estado_counts[$estado]++;
    }
    $total_tareas++;
}

// Calcular porcentajes
foreach ($estado_counts as $estado => $count) {
    $percentages[$estado] = $total_tareas > 0 ? ($count / $total_tareas) * 100 : 0;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Reporte de Tareas Verificadas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h2>Distribución de Tareas por Verificación</h2>
    <canvas id="verificacionChart"></canvas>
    <script>
        const verificacionData = {
            labels: ['Verificadas', 'No Verificadas', 'Sin Revisar'],
            datasets: [{
                data: [<?= $percentages['verificadas'] ?>, <?= $percentages['no_verificadas'] ?>, <?= $percentages['sin_revisar'] ?>],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
            }],
        };
        new Chart(document.getElementById('verificacionChart'), {
            type: 'doughnut',
            data: verificacionData,
        });
    </script>
    <a href="descargar_tareas_verificadas.php" class="btn btn-primary">Descargar en Excel</a>
</body>

</html>