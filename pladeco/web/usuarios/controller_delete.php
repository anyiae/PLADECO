<?php
include('../../app/config/config.php');

$email = $_GET['email'];

// Eliminar el usuario completamente de la base de datos
$sentencia = $pdo->prepare("DELETE FROM usuarios WHERE email = :email");
$sentencia->bindParam(':email', $email);

if ($sentencia->execute()) {
    header("Location: " . $URL . "/web/administradores/");
} else {
    echo "No se puede eliminar, comuníquese con el encargado del sistema. Gracias.";
}
?>