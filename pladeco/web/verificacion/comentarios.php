<?php
include('../../app/config/config.php');

session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = '$user' AND estado ='1'");
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

    if (isset($_GET['id_verificacion'])) {
        $id_verificacion = $_GET['id_verificacion'];

        // Consultar los detalles de la verificación junto con la tarea y el usuario
        $query = $pdo->prepare("SELECT v.*, t.nombre_tarea, t.descripcion_tarea, u.nombre AS usuario_nombre, v.comentarios_usuario
                                FROM verificacion_tareas v
                                JOIN tareas t ON v.id_tarea = t.id_tarea
                                JOIN usuarios u ON v.id_usuario = u.id
                                WHERE v.id_verificacion = :id_verificacion");
        $query->bindParam(':id_verificacion', $id_verificacion);
        $query->execute();
        $verificacion = $query->fetch(PDO::FETCH_ASSOC);

        if ($verificacion) {
            ?>
            <!DOCTYPE html>
            <html>

            <head>
                <?php include('../../layout/head.php'); ?>
                <title>Comentarios de Verificación | PLADECO</title>
            </head>

            <body class="g-sidenav-show bg-gray-100">
                <div class="wrapper">
                    <?php include('../../layout/menu.php'); ?>

                    <div class="content-wrapper">
                        <section class="content">
                            <div class="container-fluid">
                                <div class="container">
                                    <br>
                                    <center>
                                    </center>
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title"><span class="fa fa-comments"></span> Comentarios de Verificación
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                            if ($verificacion) {
                                                ?>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Nombre de la Tarea</th>
                                                        <td><?php echo htmlspecialchars($verificacion['nombre_tarea']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Descripción de la Tarea</th>
                                                        <td><?php echo htmlspecialchars($verificacion['descripcion_tarea']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Usuario que Realizó la Tarea</th>
                                                        <td><?php echo htmlspecialchars($verificacion['usuario_nombre']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Archivo de Verificación</th>
                                                        <td>
                                                            <?php
                                                            $archivos = explode(",", $verificacion['medio_verificacion']); // Se asume que los archivos están separados por coma
                                                            if (!empty($archivos)) {
                                                                foreach ($archivos as $archivo) {
                                                                    if (!empty($archivo)) {
                                                                        ?>
                                                                        <a href="<?php echo '/pladeco/pladeco/uploads/verificaciones/' . htmlspecialchars(basename($archivo)); ?>"
                                                                            target="_blank">
                                                                            Ver archivo
                                                                        </a><br>
                                                                        <?php
                                                                    }
                                                                }
                                                            } else {
                                                                echo 'Sin archivo';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Comentarios del Usuario</th>
                                                        <td><?php echo htmlspecialchars($verificacion['comentarios_usuario']); ?></td>
                                                    </tr>
                                                </table>

                                                <form action="guardar_verificacion.php" method="POST">
                                                    <input type="hidden" name="id_verificacion" value="<?php echo $id_verificacion; ?>">
                                                    <div class="form-group">
                                                        <label for="comentarios_admin">Comentarios del Administrador:</label>
                                                        <textarea class="form-control" id="comentarios_admin" name="comentarios_admin"
                                                            rows="3"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="verificado">Estado de Verificación:</label>
                                                        <select class="form-control" id="verificado" name="verificado">
                                                            <option value="SI">Verificado</option>
                                                            <option value="NO">No Verificado</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Guardar Verificación</button>
                                                </form>
                                            <?php } else { ?>
                                                <p>No se encontró la verificación solicitada.</p>
                                            <?php } ?>
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
            echo "No se encontró la verificación.";
        }
    } else {
        echo "ID de verificación no especificado.";
    }
} else {
    header("Location: $URL/login");
}
?>