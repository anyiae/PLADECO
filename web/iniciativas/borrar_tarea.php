<?php
include('../../app/config/config.php');

session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    // Verificar si el usuario es administrador
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND estado = '1'");
    $query->bindParam(':email', $user);
    $query->execute();
    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuarios as $usuario) {
        $id_usuario_s = $usuario['id'];
        $nombre_s = $usuario['nombre'];
        $apellido_s = $usuario['apellido'];
        $cargo_s = $usuario['cargo'];
        $cargo_pladeco_s = $usuario['cargo_pladeco'];
        $departamento_s = $usuario['departamento'];
    }

    if (isset($_GET['id_tarea'])) {
        $id_tarea = $_GET['id_tarea'];

        // Consultar los detalles de la tarea
        $queryTarea = $pdo->prepare("SELECT * FROM tareas WHERE id_tarea = :id_tarea");
        $queryTarea->bindParam(':id_tarea', $id_tarea);
        $queryTarea->execute();
        $datos = $queryTarea->fetch(PDO::FETCH_ASSOC);

        $nombre_tarea = $datos['nombre_tarea'];
        $descripcion_tarea = $datos['descripcion_tarea'];
        $fecha_inicio = $datos['fecha_inicio'];
        $fecha_fin = $datos['fecha_fin'];
        $costo = $datos['costo'];
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Borrar Tarea | PLADECO</title>
    </head>

    <body class="g-sidenav-show bg-gray-100">
        <div class="wrapper">
            <?php include('../../layout/menu.php'); ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="card card-danger card-outline">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title mb-0"><span class="fa fa-trash"></span> Borrar Tarea</h3>
                                    <!-- Botón de regreso -->
                                    <a href="index.php" class="btn btn-secondary">
                                        <span class="fa fa-arrow-left"></span> Volver
                                    </a>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="controller_delete_tarea.php">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="nombre_tarea">Nombre de la Tarea</label>
                                                    <input type="text" class="form-control" name="nombre_tarea"
                                                        value="<?php echo $nombre_tarea; ?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="descripcion_tarea">Descripción</label>
                                                    <textarea class="form-control" name="descripcion_tarea"
                                                        disabled><?php echo $descripcion_tarea; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fecha_inicio">Fecha de Inicio</label>
                                                    <input type="text" class="form-control" name="fecha_inicio"
                                                        value="<?php echo $fecha_inicio; ?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fecha_fin">Fecha de Fin</label>
                                                    <input type="text" class="form-control" name="fecha_fin"
                                                        value="<?php echo $fecha_fin; ?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="costo">Costo</label>
                                                    <input type="text" class="form-control" name="costo"
                                                        value="<?php echo $costo; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <a href="<?php echo $URL; ?>/web/iniciativas"
                                            class="btn btn-default btn-lg">Cancelar</a>
                                        <input type="hidden" name="id_tarea" value="<?php echo $id_tarea; ?>">
                                        <button type="submit" class="btn btn-danger btn-lg">Borrar Tarea</button>
                                    </form>
                                </div><!-- /.card-body -->
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
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