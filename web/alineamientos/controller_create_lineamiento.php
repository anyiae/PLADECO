<?php
include('../../app/config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_lineamiento = $_POST['nombre_lineamiento'];
    $descripcion_lineamiento = $_POST['descripcion_lineamiento'];
    $umr = $_POST['umr'];
    $fecha_creacion = date('Y-m-d H:i:s');

    $query = $pdo->prepare("INSERT INTO lineamiento (nombre_lineamiento, descripcion_lineamiento, umr, fecha_creacion) VALUES (?, ?, ?, ?)");
    $result = $query->execute([$nombre_lineamiento, $descripcion_lineamiento, $umr, $fecha_creacion]);

    if ($result) {
        header("Location: ../alineamientos"); // Ajusta la ruta según sea necesario
    } else {
        echo "Error al crear el lineamiento.";
    }
} else {
    echo "Método no permitido.";
}
?>