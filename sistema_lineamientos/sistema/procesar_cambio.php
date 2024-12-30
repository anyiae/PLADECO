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

    if (isset($_POST['id_tarea']) && isset($_POST['comentarios_usuario'])) {
        $id_tarea = $_POST['id_tarea'];
        $comentarios_usuario = htmlspecialchars($_POST['comentarios_usuario']);
        $archivos_subidos = [];

        // Validación de archivos (hasta 5 archivos)
        if (isset($_FILES['archivos']) && count($_FILES['archivos']['name']) > 0) {
            // Comprobamos si no exceden los 5 archivos
            if (count($_FILES['archivos']['name']) <= 5) {
                for ($i = 0; $i < count($_FILES['archivos']['name']); $i++) {
                    // Obtener el nombre del archivo
                    $archivo_nombre = $_FILES['archivos']['name'][$i];
                    $archivo_tmp = $_FILES['archivos']['tmp_name'][$i];
                    $archivo_ext = pathinfo($archivo_nombre, PATHINFO_EXTENSION);
                    $archivo_destino = "../../uploads/verificaciones/" . basename($archivo_nombre);

                    // Mover el archivo a la carpeta de subidas
                    if (move_uploaded_file($archivo_tmp, $archivo_destino)) {
                        $archivos_subidos[] = $archivo_nombre;
                    }
                }
            } else {
                echo "No puedes subir más de 5 archivos.";
                exit;
            }
        }

        // Si se ha subido un archivo .zip
        if (isset($_FILES['zip']) && $_FILES['zip']['error'] == 0) {
            $zip_nombre = $_FILES['zip']['name'];
            $zip_tmp = $_FILES['zip']['tmp_name'];
            $zip_ext = pathinfo($zip_nombre, PATHINFO_EXTENSION);

            if ($zip_ext == 'zip') {
                // Crear un directorio para los archivos extraídos
                $dir_extraer = "../../uploads/verificaciones/zip_" . time();
                mkdir($dir_extraer, 0777, true);

                // Extraer el archivo .zip
                $zip = new ZipArchive();
                if ($zip->open($zip_tmp) === TRUE) {
                    $zip->extractTo($dir_extraer);
                    $zip->close();

                    // Recoger todos los archivos extraídos
                    $archivos_extraidos = scandir($dir_extraer);
                    foreach ($archivos_extraidos as $archivo) {
                        if ($archivo != "." && $archivo != "..") {
                            rename($dir_extraer . '/' . $archivo, "../../uploads/verificaciones/" . $archivo);
                            $archivos_subidos[] = $archivo;
                        }
                    }
                    // Eliminar el directorio temporal
                    rmdir($dir_extraer);
                } else {
                    echo "Error al extraer el archivo ZIP.";
                    exit;
                }
            } else {
                echo "El archivo no es un ZIP válido.";
                exit;
            }
        }

        // Guardar los archivos subidos en la base de datos (si existen)
        if (count($archivos_subidos) > 0) {
            $archivos_guardados = implode(',', $archivos_subidos);  // Guardar los nombres de los archivos separados por coma
        } else {
            $archivos_guardados = '';  // Si no se subieron archivos
        }

        // Actualizar los comentarios del usuario y los archivos en la base de datos
        $query_update = $pdo->prepare("UPDATE verificacion_tareas SET 
                                      comentarios_usuario = :comentarios_usuario, 
                                      medio_verificacion = :medio_verificacion 
                                      WHERE id_tarea = :id_tarea");
        $query_update->bindParam(':comentarios_usuario', $comentarios_usuario);
        $query_update->bindParam(':medio_verificacion', $archivos_guardados);
        $query_update->bindParam(':id_tarea', $id_tarea);

        if ($query_update->execute()) {
            echo "Verificación actualizada exitosamente.";
            header("Location: mis_verificaciones.php");  // Redirigir a la página de mis verificaciones
            exit;
        } else {
            echo "Hubo un error al actualizar la verificación.";
        }
    } else {
        echo "Datos incompletos.";
    }
} else {
    header("Location: $URL/login");
}
?>