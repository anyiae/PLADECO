<?php
require '../../app/templeates/plugins/vendor/autoload.php';
include('../../app/config/config.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$sheet->setCellValue('A1', 'Estado de Verificación');
$sheet->setCellValue('B1', 'Cantidad');
$sheet->setCellValue('C1', 'Porcentaje');

// Consulta para obtener datos de tareas verificadas
$query = $pdo->query("SELECT verificado, COUNT(*) as cantidad FROM verificacion_tareas GROUP BY verificado");
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Llenado de datos en Excel
$row = 2;
$total = array_sum(array_column($data, 'cantidad'));
foreach ($data as $d) {
    // Convertir "SI", "NO" y NULL a valores descriptivos
    $estado = '';
    if ($d['verificado'] === 'SI') {
        $estado = 'Verificada';
    } elseif ($d['verificado'] === 'NO') {
        $estado = 'No Verificada';
    } else {
        $estado = 'Sin Revisar';
    }

    $sheet->setCellValue("A$row", $estado);
    $sheet->setCellValue("B$row", $d['cantidad']);
    $sheet->setCellValue("C$row", round(($d['cantidad'] / $total) * 100, 2) . '%');
    $row++;
}

// Generar y descargar archivo Excel
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte_Tareas_Verificadas.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>