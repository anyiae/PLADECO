<?php
include('../../app/config/config.php');
include('../../api/enviar_correos.php');  // Incluir el archivo para enviar correos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $lineamiento_id = $_POST['lineamiento_id'];
    $iniciativa_id = $_POST['iniciativa_id'];
    $tareas = $_POST['tareas'];

    try {
        // Obtener el email y el nombre del usuario usando su ID
        $query_usuario = $pdo->prepare("SELECT email, nombre FROM usuarios WHERE id = :usuario_id");
        $query_usuario->execute(['usuario_id' => $usuario_id]);
        $usuario = $query_usuario->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontraron datos del usuario
        if ($usuario) {
            $emailDestino = $usuario['email'];
            $nombreUsuario = $usuario['nombre'];

            // Guardar la asignación
            $query = $pdo->prepare("INSERT INTO asignaciones (id_usuario, id_iniciativa, id_lineamiento, fecha_asignacion) VALUES (:usuario_id, :iniciativa_id, :lineamiento_id, NOW())");
            $query->execute(['usuario_id' => $usuario_id, 'iniciativa_id' => $iniciativa_id, 'lineamiento_id' => $lineamiento_id]);
            $asignacion_id = $pdo->lastInsertId();

            // Guardar las tareas
            foreach ($tareas as $tarea) {
                if (!empty($tarea['nombre_tarea']) && !empty($tarea['descripcion_tarea'])) {
                    $fecha_inicio = date('Y-m-d H:i:s', strtotime($tarea['fecha_inicio']));
                    $fecha_fin = date('Y-m-d H:i:s', strtotime($tarea['fecha_fin']));

                    $query_tarea = $pdo->prepare("
                        INSERT INTO tareas 
                        (id_asignacion, id_iniciativa, nombre_tarea, descripcion_tarea, fecha_inicio, fecha_fin, estado_tarea, costo) 
                        VALUES 
                        (:asignacion_id, :iniciativa_id, :nombre_tarea, :descripcion_tarea, :fecha_inicio, :fecha_fin, :estado_tarea, :costo_tarea)
                    ");

                    $query_tarea->execute([
                        'asignacion_id' => $asignacion_id,
                        'iniciativa_id' => $iniciativa_id,
                        'nombre_tarea' => $tarea['nombre_tarea'],
                        'descripcion_tarea' => $tarea['descripcion_tarea'],
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin,
                        'estado_tarea' => $tarea['estado_tarea'],
                        'costo_tarea' => $tarea['costo_tarea'],
                    ]);
                }
            }

            // Enviar el correo al usuario
            enviarCorreo($emailDestino, $nombreUsuario);

            echo 'Asignación y tareas guardadas correctamente.';
        } else {
            echo 'Error: Usuario no encontrado.';
        }

    } catch (PDOException $e) {
        echo 'Error al guardar asignación: ' . $e->getMessage();
    }
}
?>