<?php
include('../../app/config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lineamiento_id = $_POST['lineamiento_id'];
    $nombre_iniciativa = $_POST['nombre_iniciativa'];
    $descripcion_iniciativa = $_POST['descripcion_iniciativa'];

    // Guardar en la base de datos
    $query = $pdo->prepare("INSERT INTO iniciativas (id_lineamiento, nombre_iniciativa, descripcion_iniciativa, fecha_creacion) VALUES (:id_lineamiento, :nombre_iniciativa, :descripcion_iniciativa, NOW())");
    $query->execute([
        'id_lineamiento' => $lineamiento_id,
        'nombre_iniciativa' => $nombre_iniciativa,
        'descripcion_iniciativa' => $descripcion_iniciativa
    ]);

    header("Location: ../lineamientos");
    exit;
}
?>