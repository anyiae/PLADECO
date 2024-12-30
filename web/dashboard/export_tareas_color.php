<?php
require '../../app/templeates/plugins/vendor/autoload.php';
include('../../app/config/config.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

// Crear el archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Usuario')
    ->setCellValue('B1', 'Apellido')
    ->setCellValue('C1', 'Nombre Tarea')
    ->setCellValue('D1', 'Estado Semáforo');

// Consulta de usuarios, tareas y colores de semáforo
$query = $pdo->query("
    SELECT u.nombre AS usuario_nombre, u.apellido, t.nombre_tarea, t.fecha_inicio, t.fecha_fin 
    FROM tareas t
    INNER JOIN asignaciones a ON t.id_asignacion = a.id_asignacion
    INNER JOIN usuarios u ON a.id_usuario = u.id
");
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Llenado de datos en Excel
$row = 2;
foreach ($data as $record) {
    $color = calcularSemaforo($record['fecha_inicio'], $record['fecha_fin']);

    // Mapear los colores a categorías de usuarios
    switch ($color) {
        case 'verde':
            $estado_tarea = 'Usuarios en tiempo óptimo';
            break;
        case 'amarillo':
            $estado_tarea = 'Usuarios a tiempo';
            break;
        case 'rojo':
            $estado_tarea = 'Usuarios atrasados';
            break;
    }

    $sheet->setCellValue("A$row", $record['usuario_nombre']);
    $sheet->setCellValue("B$row", $record['apellido']);
    $sheet->setCellValue("C$row", $record['nombre_tarea']);
    $sheet->setCellValue("D$row", $estado_tarea);
    $row++;
}

// Generar y descargar archivo Excel
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_Tareas_Semaforo.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>