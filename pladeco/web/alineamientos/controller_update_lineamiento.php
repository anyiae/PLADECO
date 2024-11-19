<?php
include('../../app/config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_lineamiento = $_POST['id_lineamiento'];
    $nombre_lineamiento = $_POST['nombre_lineamiento'];
    $descripcion_lineamiento = $_POST['descripcion_lineamiento'];
    $umr = $_POST['umr'];
    $fecha_creacion = date('Y-m-d H:i:s');

    $query = $pdo->prepare("UPDATE lineamiento SET nombre_lineamiento = ?, descripcion_lineamiento = ?, umr = ?, fecha_creacion = ? WHERE id_lineamiento = ?");
    $result = $query->execute([$nombre_lineamiento, $descripcion_lineamiento, $umr, $fecha_creacion, $id_lineamiento]);

    if ($result) {
        header("Location: index.php"); // Ajusta la ruta según sea necesario
    } else {
        echo "Error al actualizar el lineamiento.";
    }
} else {
    echo "Método no permitido.";
}
?>