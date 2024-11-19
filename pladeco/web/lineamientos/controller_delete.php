<?php
include('../../app/config/config.php');

$id_iniciativa = $_GET['id'];  // Obtener el ID de la iniciativa desde la URL

// Eliminar la iniciativa completamente de la base de datos
$sentencia = $pdo->prepare("DELETE FROM iniciativas WHERE id_iniciativa = :id_iniciativa");
$sentencia->bindParam(':id_iniciativa', $id_iniciativa);

if ($sentencia->execute()) {
    header("Location: " . $URL . "/web/lineamientos/");
} else {
    echo "No se puede eliminar la iniciativa, comuníquese con el encargado del sistema. Gracias.";
}
?>