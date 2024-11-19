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

    // Obtener el nombre de la tarea seleccionada usando su id
    if (isset($_GET['id_tarea'])) {
        $id_tarea = $_GET['id_tarea'];
        $queryTarea = $pdo->prepare("SELECT nombre_tarea FROM tareas WHERE id_tarea = :id_tarea");
        $queryTarea->bindParam(':id_tarea', $id_tarea);
        $queryTarea->execute();
        $tarea = $queryTarea->fetch(PDO::FETCH_ASSOC);
        $nombre_tarea = $tarea['nombre_tarea'];
    } else {
        echo "ID de tarea no especificado.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $comentarios_usuario = $_POST['comentarios_usuario'] ?? '';

        // Verificar si se suben archivos
        if (isset($_FILES['medio_verificacion']) && count($_FILES['medio_verificacion']['name']) > 0) {
            // Comprobar si se han subido más de 5 archivos
            if (count($_FILES['medio_verificacion']['name']) > 5) {
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
            for ($i = 0; $i < count($_FILES['medio_verificacion']['name']); $i++) {
                // Obtener el nombre del archivo
                $nombreArchivo = basename($_FILES['medio_verificacion']['name'][$i]);
                $rutaArchivo = $directorio . $nombreArchivo;

                // Mover el archivo al directorio de destino
                if (move_uploaded_file($_FILES['medio_verificacion']['tmp_name'][$i], $rutaArchivo)) {
                    $archivos_guardados[] = $rutaArchivo;
                } else {
                    echo "Error al subir el archivo: " . $_FILES['medio_verificacion']['name'][$i];
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
                    $rutas_archivos = $nombreZip;
                } else {
                    echo "Error al crear el archivo ZIP.";
                    exit;
                }
            } else {
                // Si hay solo un archivo, guardar las rutas directamente
                $rutas_archivos = implode(',', $archivos_guardados);
            }

            // Insertar en la base de datos
            $query = $pdo->prepare("INSERT INTO verificacion_tareas 
                                    (id_tarea, medio_verificacion, fecha_verificacion, verificado, id_usuario, comentarios_usuario) 
                                    VALUES (:id_tarea, :medio_verificacion, NOW(), NULL, :id_usuario, :comentarios_usuario)");
            $query->bindParam(':id_tarea', $id_tarea);
            $query->bindParam(':medio_verificacion', $rutas_archivos);
            $query->bindParam(':id_usuario', $id_usuario_s);
            $query->bindParam(':comentarios_usuario', $comentarios_usuario);
            $query->execute();


        } else {

        }
    }
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Verificar Tarea | PLADECO</title>
    </head>

    <body class="g-sidenav-show bg-gray-100">
        <div class="wrapper">
            <?php include('../../layout/menu.php'); ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-tasks"></span> Verificar Tarea</h3>
                                </div>
                                <div class="card-body">
                                    <form action="verificar_tarea.php?id_tarea=<?php echo $id_tarea; ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <!-- Mostrar el nombre de la tarea y pasar el id_tarea como campo oculto -->
                                        <div class="form-group">
                                            <label for="nombre_tarea">Nombre de la Tarea:</label>
                                            <input type="text" name="nombre_tarea" class="form-control"
                                                value="<?php echo htmlspecialchars($nombre_tarea); ?>" disabled>
                                            <input type="hidden" name="id_tarea" value="<?php echo $id_tarea; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="medio_verificacion">Subir Medio de Verificación (máximo 5
                                                archivos):</label>
                                            <input type="file" name="medio_verificacion[]" class="form-control" required
                                                multiple>
                                        </div>

                                        <div class="form-group">
                                            <label for="comentarios_usuario">Comentarios:</label>
                                            <textarea name="comentarios_usuario" class="form-control" rows="3"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Enviar Verificación</button>
                                    </form>
                                </div>
                            </div>
                        </div><!-- /.container -->
                    </div><!-- /.container-fluid -->
                </section>
            </div><!-- /.content-wrapper -->
        </div><!-- /.wrapper -->
        <?php include('../../layout/footer_link.php'); ?>
    </body>

    </html>

    <?php
} else {
    header("Location: $URL/login");
}
?>