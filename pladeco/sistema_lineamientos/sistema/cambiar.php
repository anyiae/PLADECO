<?php
include('../../app/config/config.php');

session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = '$user' AND estado ='2'");
    $query->execute();
    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios as $usuario) {
        $id_usuario_s = $usuario['id'];
        $apellido_s = $usuario['apellido'];
        $nombre_s = $usuario['nombre'];
        $cargo_s = $usuario['cargo'];
        $cargo_pladeco_s = $usuario['cargo_pladeco'];
        $departamento_s = $usuario['departamento'];
    }

    // Obtener la tarea y su información de verificación
    if (isset($_POST['id_tarea'])) {
        $id_tarea = $_POST['id_tarea'];

        // Obtener los detalles de la tarea y la verificación
        $query2 = $pdo->prepare("SELECT t.*, vt.comentarios_admin, vt.id_verificacion, vt.medio_verificacion, vt.fecha_verificacion, vt.verificado, vt.comentarios_usuario
                                 FROM tareas t 
                                 LEFT JOIN verificacion_tareas vt ON t.id_tarea = vt.id_tarea
                                 WHERE t.id_tarea = :id_tarea");
        $query2->bindParam(':id_tarea', $id_tarea);
        $query2->execute();
        $tarea = $query2->fetch(PDO::FETCH_ASSOC);
    }

    if ($tarea) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comentarios_usuario = $_POST['comentarios_usuario'] ?? '';

            // Verificar si se suben archivos
            if (isset($_FILES['archivos']) && count($_FILES['archivos']['name']) > 0) {
                // Comprobar si se han subido más de 5 archivos
                if (count($_FILES['archivos']['name']) > 5) {
                    echo "Error: Solo puedes subir un máximo de 5 archivos.";
                    exit;
                }

                // Ruta para guardar los archivos
                $directorio = '../../uploads/verificaciones/';
                $archivos_guardados = [];

                // Verificar si el directorio existe, si no, crearlo
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                // Procesar cada archivo
                for ($i = 0; $i < count($_FILES['archivos']['name']); $i++) {
                    $nombreArchivo = basename($_FILES['archivos']['name'][$i]);
                    $rutaArchivo = $directorio . $nombreArchivo;

                    // Mover el archivo al directorio de destino
                    if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $rutaArchivo)) {
                        $archivos_guardados[] = $rutaArchivo;
                    } else {
                        echo "Error al subir el archivo: " . $_FILES['archivos']['name'][$i];
                    }
                }

                // Si hay más de un archivo, crear un archivo .zip
                if (count($archivos_guardados) > 1) {
                    $zip = new ZipArchive();
                    $nombreZip = $directorio . 'verificacion_' . $id_tarea . '.zip';

                    // Crear el archivo .zip
                    if ($zip->open($nombreZip, ZipArchive::CREATE) === TRUE) {
                        // Añadir archivos al archivo .zip
                        foreach ($archivos_guardados as $rutaArchivo) {
                            $nombreArchivo = basename($rutaArchivo);
                            $zip->addFile($rutaArchivo, $nombreArchivo);
                        }

                        // Cerrar el archivo .zip
                        $zip->close();

                        // Eliminar los archivos temporales después de agregarlos al .zip
                        foreach ($archivos_guardados as $rutaArchivo) {
                            unlink($rutaArchivo);
                        }

                        // Guardar la ruta del archivo .zip en la base de datos
                        $rutas_archivos = 'verificacion_' . $id_tarea . '.zip';
                    } else {
                        echo "Error al crear el archivo ZIP.";
                        exit;
                    }
                } else {
                    // Si hay solo un archivo, guardar las rutas directamente
                    $rutas_archivos = implode(',', $archivos_guardados);
                }

                // Actualizar la base de datos con la ruta del archivo o archivo .zip
                $queryUpdate = $pdo->prepare("UPDATE verificacion_tareas SET medio_verificacion = :medio_verificacion WHERE id_tarea = :id_tarea");
                $queryUpdate->bindParam(':medio_verificacion', $rutas_archivos);
                $queryUpdate->bindParam(':id_tarea', $id_tarea);
                $queryUpdate->execute();
            }

            // Actualizar otros detalles si es necesario
            $comentarios_usuario = $_POST['comentarios_usuario'] ?? '';
            $queryUpdate = $pdo->prepare("UPDATE verificacion_tareas SET comentarios_usuario = :comentarios_usuario WHERE id_tarea = :id_tarea");
            $queryUpdate->bindParam(':comentarios_usuario', $comentarios_usuario);
            $queryUpdate->bindParam(':id_tarea', $id_tarea);
            $queryUpdate->execute();


        }
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <?php include('../../layout/head.php'); ?>
            <title>Modificar Verificación | PLADECO</title>
        </head>

        <body class="hold-transition sidebar-mini layout-fixed">
            <div class="wrapper">
                <?php include('../../layout/menu.php'); ?>
                <div class="content-wrapper">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="container">
                                <br>
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><span class="fa fa-edit"></span> Modificar Verificación</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form action="cambiar.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="id_tarea"
                                                        value="<?php echo $tarea['id_tarea']; ?>">

                                                    <div class="form-group">
                                                        <label for="comentarios_admin">Comentarios del Administrador</label>
                                                        <textarea class="form-control" id="comentarios_admin" rows="4"
                                                            disabled><?php echo htmlspecialchars($tarea['comentarios_admin']); ?></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="comentarios_usuario">Tus Comentarios</label>
                                                        <textarea class="form-control" id="comentarios_usuario"
                                                            name="comentarios_usuario"
                                                            rows="4"><?php echo htmlspecialchars($tarea['comentarios_usuario']); ?></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="archivos">Archivos de Verificación (hasta 5
                                                            archivos)</label>
                                                        <?php
                                                        // Mostrar los archivos existentes
                                                        $archivos = explode(',', $tarea['medio_verificacion']);
                                                        foreach ($archivos as $archivo) {
                                                            echo '<div class="file-info"><a href="../../uploads/verificaciones/' . htmlspecialchars($archivo) . '" target="_blank">' . htmlspecialchars($archivo) . '</a></div>';
                                                        }
                                                        ?>
                                                        <input type="file" name="archivos[]" class="form-control" multiple>
                                                        <small>Si deseas subir nuevos archivos, selecciona los archivos aquí.
                                                            Puedes cargar hasta 5 archivos (incluyendo .zip).</small>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <?php include('../../layout/footer.php'); ?>
            </div>
            <?php include('../../layout/footer_link.php'); ?>
        </body>

        </html>
        <?php
    } else {
        echo "Tarea no encontrada.";
    }
} else {
    header("Location: $URL/login");
}
?>