<?php
include('../../app/config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_verificacion = $_POST['id_verificacion'];
    $comentarios_admin = $_POST['comentarios_admin'];
    $accion = $_POST['accion'];

    if ($accion === 'verificar') {
        $verificado = 'SI';
    } else {
        $verificado = 'NO';
    }

    $query = $pdo->prepare("UPDATE verificacion_tareas 
                            SET verificado = :verificado, comentarios_admin = :comentarios_admin 
                            WHERE id_verificacion = :id_verificacion");
    $query->bindParam(':verificado', $verificado);
    $query->bindParam(':comentarios_admin', $comentarios_admin);
    $query->bindParam(':id_verificacion', $id_verificacion);
    $query->execute();

    header("Location: verificacion.php");
}
?>