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

    // Consultar las tareas verificadas
    $query2 = $pdo->prepare("SELECT t.* FROM tareas t 
                             JOIN asignaciones a ON t.id_asignacion = a.id_asignacion 
                             JOIN verificacion_tareas v ON t.id_tarea = v.id_tarea 
                             WHERE a.id_usuario = :id_usuario AND v.verificado = 'SI'");
    $query2->bindParam(':id_usuario', $id_usuario_s);
    $query2->execute();
    $tareas_verificadas = $query2->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Tareas Verificadas | PLADECO</title>
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
                                    <h3 class="card-title"><span class="fa fa-check"></span> Tareas Verificadas</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Nro</th>
                                                        <th>Nombre de la Tarea</th>
                                                        <th>Descripción</th>
                                                        <th>Fecha de Inicio</th>
                                                        <th>Fecha de Fin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $contador = 0;
                                                    foreach ($tareas_verificadas as $tarea) {
                                                        $contador++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $contador; ?></td>
                                                            <td><?php echo htmlspecialchars($tarea['nombre_tarea']); ?></td>
                                                            <td><?php echo htmlspecialchars($tarea['descripcion_tarea']); ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($tarea['fecha_inicio']); ?></td>
                                                            <td><?php echo htmlspecialchars($tarea['fecha_fin']); ?></td>
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