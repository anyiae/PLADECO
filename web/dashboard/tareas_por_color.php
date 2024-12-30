<?php
include('../../app/config/config.php');

// Definir la función calcularSemaforo
function calcularSemaforo($fecha_inicio, $fecha_fin)
{
    $fecha_inicio_dt = strtotime($fecha_inicio);
    $fecha_fin_dt = strtotime($fecha_fin);
    $hoy = time();
    $diferencia_total = $fecha_fin_dt - $fecha_inicio_dt;
    $diferencia_hoy = $hoy - $fecha_inicio_dt;

    if ($diferencia_hoy <= $diferencia_total * 0.33) {
        return 'verde';
    } elseif ($diferencia_hoy <= $diferencia_total * 0.66) {
        return 'amarillo';
    } else {
        return 'rojo';
    }
}

$color_counts = [
    'verde' => 0,
    'amarillo' => 0,
    'rojo' => 0,
];
$total_tareas = 0;

// Consulta de tareas
$query = $pdo->query("SELECT fecha_inicio, fecha_fin FROM tareas");
while ($tarea = $query->fetch(PDO::FETCH_ASSOC)) {
    $color = calcularSemaforo($tarea['fecha_inicio'], $tarea['fecha_fin']);
    $color_counts[$color]++;
    $total_tareas++;
}

// Convertir los datos en porcentajes
$percentages = [];
foreach ($color_counts as $color => $count) {
    $percentages[$color] = $total_tareas > 0 ? ($count / $total_tareas) * 100 : 0;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Reporte de Tareas por Color</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h2>Distribución de Tareas por Color</h2>
    <canvas id="colorChart"></canvas>
    <script>
        const colorData = {
            labels: ['Verde', 'Amarillo', 'Rojo'],
            datasets: [{
                data: [<?= $percentages['verde'] ?>, <?= $percentages['amarillo'] ?>, <?= $percentages['rojo'] ?>],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
            }],
        };
        new Chart(document.getElementById('colorChart'), {
            type: 'doughnut',
            data: colorData,
        });
    </script>
    <a href="descargar_tareas_por_color.php" class="btn btn-primary">Descargar en Excel</a>
</body>

</html>