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

    $query = $pdo->prepare("SELECT v.*, t.nombre_tarea, u.nombre AS usuario_nombre 
                            FROM verificacion_tareas v
                            JOIN tareas t ON v.id_tarea = t.id_tarea
                            JOIN usuarios u ON v.id_usuario = u.id
                            WHERE v.verificado = 'SI'");
    $query->execute();
    $verificados = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Tareas Verificadas | PLADECO</title>
        <style>
            .table td.wrap {
                max-width: 200px;
                white-space: normal;
                word-wrap: break-word;
                overflow-wrap: break-word;
                overflow-y: auto;
            }
        </style>
    </head>

    <body class="g-sidenav-show bg-gray-100">
        <div class="wrapper">
            <?php include('../../layout/menu.php'); ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-check-circle"></span> Tareas Verificadas</h3>
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
                                                        <th>Fecha Verificación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $contador = 0;
                                                    foreach ($verificados as $verificado) {
                                                        $contador++;
                                                        $archivos = explode(",", $verificado['medio_verificacion']);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $contador; ?></td>
                                                            <td class="wrap">
                                                                <?php echo htmlspecialchars($verificado['nombre_tarea']); ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($verificado['usuario_nombre']); ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (!empty($archivos)) {
                                                                    foreach ($archivos as $archivo) {
                                                                        if (!empty($archivo)) {
                                                                            ?>
                                                                            <a href="<?php echo '/pladeco/pladeco/uploads/verificaciones/' . htmlspecialchars(basename($archivo)); ?>"
                                                                                target="_blank">Ver archivo</a><br>
                                                                            <?php
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo 'Sin archivo';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($verificado['fecha_verificacion']); ?>
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