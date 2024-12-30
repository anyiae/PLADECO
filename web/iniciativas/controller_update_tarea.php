<?php
include('../../app/config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tarea = $_POST['id_tarea'];
    $nombre_tarea = $_POST['nombre_tarea'];
    $descripcion_tarea = $_POST['descripcion_tarea'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Iniciar la transacción
    $pdo->beginTransaction();

    try {
        // Actualizar la tarea en la tabla tareas
        $queryTarea = $pdo->prepare("UPDATE tareas SET nombre_tarea = :nombre_tarea, descripcion_tarea = :descripcion_tarea, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin WHERE id_tarea = :id_tarea");
        $queryTarea->execute([
            'nombre_tarea' => $nombre_tarea,
            'descripcion_tarea' => $descripcion_tarea,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'id_tarea' => $id_tarea
        ]);

        // Si todo va bien, se confirma la transacción
        $pdo->commit();

        // Redirigir a la página de listado de tareas con mensaje de éxito
        header("Location: index.php?msg=La tarea ha sido actualizada correctamente.");
        exit;
    } catch (Exception $e) {
        // Si ocurre algún error, deshacer la transacción
        $pdo->rollBack();
        echo "Error al actualizar la tarea: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
}
?>