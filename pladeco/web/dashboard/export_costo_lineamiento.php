<?php
include('../../app/config/config.php');
session_start();

if (isset($_SESSION['u_usuario'])) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Costo_por_Lineamiento.xls"');

    $query = $pdo->query("
        SELECT l.nombre_lineamiento, SUM(t.costo) AS costo_total
        FROM lineamiento l
        INNER JOIN asignaciones a ON l.id_lineamiento = a.id_lineamiento
        INNER JOIN tareas t ON a.id_asignacion = t.id_asignacion
        GROUP BY l.nombre_lineamiento
    ");

    echo "Lineamiento\tCosto Total\n"; // Encabezado de la tabla

    while ($lineamiento = $query->fetch(PDO::FETCH_ASSOC)) {
        echo "{$lineamiento['nombre_lineamiento']}\t{$lineamiento['costo_total']}\n"; // Datos de cada fila
    }

} else {
    header('Location: ' . $URL . '/login');
}
?>