<?php
include('../../app/config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_verificacion = $_POST['id_verificacion'];
    $comentarios_admin = $_POST['comentarios_admin'];
    $verificado = $_POST['verificado'];

    // Verificar si el estado es "SI" (Verificado)
    if ($verificado == 'SI') {
        // Actualizar los datos en la base de datos incluyendo la fecha de verificación
        $query = $pdo->prepare("UPDATE verificacion_tareas 
                                SET verificado = :verificado, comentarios_admin = :comentarios_admin, 
                                    fecha_verificacion = NOW(), estado_respuesta = 'SIN_RESPUESTA'
                                WHERE id_verificacion = :id_verificacion");
    } else {
        // Si no está verificado, solo se actualizan los comentarios y el estado de respuesta
        $query = $pdo->prepare("UPDATE verificacion_tareas 
                                SET verificado = :verificado, comentarios_admin = :comentarios_admin, 
                                    estado_respuesta = 'SIN_RESPUESTA'
                                WHERE id_verificacion = :id_verificacion");
    }

    $query->bindParam(':verificado', $verificado);
    $query->bindParam(':comentarios_admin', $comentarios_admin);
    $query->bindParam(':id_verificacion', $id_verificacion);

    if ($query->execute()) {
        echo "Verificación actualizada con éxito.";
        header("Location: verificacion.php");
    } else {
        echo "Error al actualizar la verificación.";
    }
}
?>