<?php include('../../app/config/config.php');

session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];

    // Obtener los datos del usuario (si es necesario)
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
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Creación de Lineamientos | PLADECO</title>
    </head>

    <body class="g-sidenav-show bg-gray-100">
        <div class="wrapper">

            <?php include('../../layout/menu.php'); ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-lightbulb"></span> Creación de un nuevo
                                        lineamiento</h3>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <form action="controller_create_lineamiento.php" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombre_lineamiento">Nombre del Lineamiento</label>
                                                    <input type="text" class="form-control" name="nombre_lineamiento"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="descripcion_lineamiento">Descripción del Lineamiento</label>
                                                    <input type="text" class="form-control" name="descripcion_lineamiento"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="umr">UMR Responsable</label>
                                                    <input type="text" class="form-control" name="umr" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <a href="<?php echo $URL; ?>/web/alineamientos"
                                                class="btn btn-default btn-lg">Cancelar</a>
                                            <input type="submit" class="btn btn-primary btn-lg"
                                                value="Registrar Lineamiento">
                                        </div>
                                    </form>
                                </div>
                                <br>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </section>
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