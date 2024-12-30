<?php
require '../../app/templeates/plugins/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Estado Verificación')->setCellValue('B1', 'Cantidad')->setCellValue('C1', 'Porcentaje');

$row = 2;
foreach ($estado_counts as $estado => $count) {
    // Convertir los valores a algo más descriptivo
    if ($estado === 'SI') {
        $estado = 'Verificada';
    } elseif ($estado === 'NO') {
        $estado = 'No Verificada';
    } else {
        $estado = 'Sin Revisar';
    }

    $sheet->setCellValue("A$row", ucfirst($estado))
        ->setCellValue("B$row", $count)
        ->setCellValue("C$row", $percentages[$estado] . '%');
    $row++;
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="reporte_tareas_verificadas.xlsx"');
$writer->save('php://output');
exit;
?>