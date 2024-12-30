<?php
/**
 * Actualización de iniciativa
 */
include('../../app/config/config.php');

// Obtener los datos del formulario
$nombre_iniciativa = $_POST['nombre_iniciativa'];
$descripcion_iniciativa = $_POST['descripcion_iniciativa'];
$id_lineamiento = $_POST['id_lineamiento'];
$id_iniciativa = $_GET['id'];  // Obtener el ID de la iniciativa desde la URL

date_default_timezone_set("America/Caracas");
$fechaHora = date("Y-m-d h:i:s");

// Actualizar la iniciativa
$sentencia = $pdo->prepare("UPDATE iniciativas SET nombre_iniciativa = :nombre_iniciativa, descripcion_iniciativa = :descripcion_iniciativa, id_lineamiento = :id_lineamiento, fyh_actualizacion = :fechaHora WHERE id_iniciativa = :id_iniciativa");
$sentencia->bindParam(':nombre_iniciativa', $nombre_iniciativa);
$sentencia->bindParam(':descripcion_iniciativa', $descripcion_iniciativa);
$sentencia->bindParam(':id_lineamiento', $id_lineamiento);
$sentencia->bindParam(':fechaHora', $fechaHora);
$sentencia->bindParam(':id_iniciativa', $id_iniciativa);

if ($sentencia->execute()) {
    header("Location: " . $URL . "/web/lineamientos/");
} else {
    echo "No se pudo actualizar la iniciativa. Por favor, inténtelo nuevamente.";
}
?>