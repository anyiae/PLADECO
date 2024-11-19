<?php
// Inclusión del archivo de configuración
include('../../app/config/config.php');

// Obtención de los parámetros de la URL
$id_lineamiento = $_GET['id_l'];  // ID del lineamiento
$id_iniciativa = $_GET['id_i'];   // ID de la iniciativa
$id_usuario = $_GET['id_u'];      // ID del usuario

// Estado de la tarea o asignación
$estado_asignacion = 'ASIGNADO';

// Buscamos el correo del usuario asignado
$email_usuario = '';
$query_usuario = $pdo->prepare("SELECT * FROM usuarios WHERE cargo = 'USUARIO' AND id='$id_usuario' AND estado='1' ");
$query_usuario->execute();
$usuarios = $query_usuario->fetchAll(PDO::FETCH_ASSOC);
foreach ($usuarios as $usuario) {
    $id_usr = $usuario['id'];
    $email_usuario = $usuario['email'];
}

// Actualización de la iniciativa con el usuario asignado
$sentencia = $pdo->prepare("UPDATE iniciativas SET id_usuario_asignado='$id_usuario', estado_asignacion='$estado_asignacion' WHERE id_iniciativa='$id_iniciativa' ");
if ($sentencia->execute()) {
    // Redirección a la página correspondiente tras la asignación exitosa
    header("Location: " . $URL . "/web/iniciativas/");
} else {
    // Mensaje de error si la actualización falla
    echo "No se puede asignar el usuario, comuníquese con el encargado del sistema. Gracias";
}
?>