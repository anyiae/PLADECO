<?php
include('../../app/config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tarea = $_POST['id_tarea'];

    // Iniciar la transacción
    $pdo->beginTransaction();

    try {
        // Eliminar registros en la tabla verificacion_tareas que están relacionados con la tarea
        $queryVerificacion = $pdo->prepare("DELETE FROM verificacion_tareas WHERE id_tarea = :id_tarea");
        $queryVerificacion->execute(['id_tarea' => $id_tarea]);

        // Eliminar las asignaciones relacionadas con la tarea
        $queryAsignacion = $pdo->prepare("DELETE FROM asignaciones WHERE id_asignacion = (SELECT id_asignacion FROM tareas WHERE id_tarea = :id_tarea)");
        $queryAsignacion->execute(['id_tarea' => $id_tarea]);

        // Eliminar la tarea de la tabla tareas
        $queryTarea = $pdo->prepare("DELETE FROM tareas WHERE id_tarea = :id_tarea");
        $queryTarea->execute(['id_tarea' => $id_tarea]);

        // Si todo va bien, se confirma la transacción
        $pdo->commit();

        // Redirigir a la página de listado de tareas con mensaje de éxito
        header("Location: index.php?msg=La tarea ha sido eliminada correctamente.");
        exit;
    } catch (Exception $e) {
        // Si ocurre algún error, deshacer la transacción
        $pdo->rollBack();
        echo "Error al eliminar la tarea: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
}
?>