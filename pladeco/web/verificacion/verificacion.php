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
    $query = $pdo->prepare("SELECT * FROM verificacion_tareas WHERE verificado = 'NO'");
    $query->execute();
    $verificaciones = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Verificaciones de Tareas | PLADECO</title>
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
                                    <h3 class="card-title"><span class="fa fa-tasks"></span> Verificaciones de Tareas</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Nro</th>
                                                        <th>Nombre de la Tarea</th>
                                                        <th>Usuario</th>
                                                        <th>Medio de Verificación</th>
                                                        <th>Estado</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $contador = 0;
                                                    // Consultar las verificaciones pendientes o realizadas
                                                    $query = $pdo->prepare("SELECT v.*, t.nombre_tarea, u.nombre AS usuario_nombre 
                                                                            FROM verificacion_tareas v
                                                                            JOIN tareas t ON v.id_tarea = t.id_tarea
                                                                            JOIN usuarios u ON v.id_usuario = u.id WHERE v.verificado IS NULL OR v.verificado = 'NO' ");
                                                    $query->execute();
                                                    $verificaciones = $query->fetchAll(PDO::FETCH_ASSOC);

                                                   foreach ($verificaciones as $verificacion) {
    $contador++;
    $estado = $verificacion['verificado'];
    $estado_texto = 'Sin revisar';

    if ($estado === 'SI') {
        $estado_texto = 'VERIFICADO';
    } elseif ($estado === 'NO') {
        $estado_texto = 'NO VERIFICADO';
    }

    $icono = '';
    if ($estado === 'NO' && $verificacion['estado_respuesta'] == "RESPONDIDO") {
        $icono = '<span class="fa fa-exclamation-circle text-success" title="Nuevos archivos y comentarios de usuario"></span>';
    } elseif ($estado === 'NO' && $verificacion['estado_respuesta'] == "SIN_RESPUESTA") {
        $icono = '<span class="fa fa-comment-dots text-warning" title="Envío de comentarios"></span>';
    }
    ?>
    <tr>
        <td><?php echo $contador; ?> <?php echo $icono; ?></td>
        <td><?php echo htmlspecialchars($verificacion['nombre_tarea']); ?></td>
        <td><?php echo htmlspecialchars($verificacion['usuario_nombre']); ?></td>
        <td>
            <?php
            $archivos = explode(",", $verificacion['medio_verificacion']);
            if (!empty($archivos)) {
                foreach ($archivos as $archivo) {
                    if (!empty($archivo)) {
                        ?>
                        <a href="<?php echo '/pladeco/pladeco/uploads/verificaciones/' . htmlspecialchars(basename($archivo)); ?>" target="_blank">
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
        <td><?php echo $estado_texto; ?></td>
        <td>
            <form action="comentarios.php" method="GET" style="display: inline;">
                <input type="hidden" name="id_verificacion" value="<?php echo $verificacion['id_verificacion']; ?>">
                <button type="submit" class="btn btn-info btn-xs">
                    <span class="fa fa-check"></span> Verificar
                </button>
            </form>
        </td>
    </tr>
    <?php
}

                                                    
                                                    ?>
                                                </tbody>
                                            </table>
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
    header("Location: $URL/login");
}
?>