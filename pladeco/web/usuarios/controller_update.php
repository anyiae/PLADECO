<?php
/**
 */
include('../../app/config/config.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$password = $_POST['password'];
$cargo = $_POST['cargo'];
$cargo_pladeco = $_POST['cargo_pladeco'];
$departamento = $_POST['departamento'];

date_default_timezone_set("America/Caracas");
$fechaHora = date("Y-m-d h:i:s");

$sentencia = $pdo->prepare("UPDATE usuarios SET nombre='$nombre',apellido='$apellido',cargo='$cargo',cargo_pladeco='$cargo_pladeco',departamento='$departamento',password='$password', fyh_actualizacion='$fechaHora' WHERE email='$email' ");
//print_r($sentencia);
if ($sentencia->execute()) {
    header("Location: " . $URL . "/web/usuarios/");
} else {
    //echo "No se pudo actualizar ";
    echo "no se puede eliminar, comuniquese con el encargado del sistema. Gracias";
}
