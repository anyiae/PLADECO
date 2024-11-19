<?php include('../../app/config/config.php');

$id_lineamiento = $_GET['id'];

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
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Gestión de Lineamientos | PLADECO </title>
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
                            <center>
                            </center>
                            <div class="card card-danger card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-trash"></span> Borrar Lineamiento</h3>
                                </div><!-- /.card-body -->
                                <div class="card-body">
                                    <?php
                                    // Obtener el ID del lineamiento desde la URL
                                    $id_lineamiento = $_GET['id'];

                                    // Consultar los detalles del lineamiento
                                    $query2 = $pdo->prepare("SELECT * FROM lineamiento WHERE id_lineamiento = :id_lineamiento");
                                    $query2->bindParam(':id_lineamiento', $id_lineamiento);
                                    $query2->execute();
                                    $datos = $query2->fetch(PDO::FETCH_ASSOC);

                                    $nombre_lineamiento = $datos['nombre_lineamiento'];
                                    $descripcion_lineamiento = $datos['descripcion_lineamiento'];
                                    $umr = $datos['umr'];
                                    ?>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Nombre del Lineamiento</label>
                                                <input type="text" class="form-control" name="nombre_lineamiento"
                                                    value="<?php echo $nombre_lineamiento; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Descripción del Lineamiento</label>
                                                <textarea class="form-control" name="descripcion_lineamiento"
                                                    disabled><?php echo $descripcion_lineamiento; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">UMR Responsable</label>
                                                <input type="text" class="form-control" name="umr"
                                                    value="<?php echo $umr; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a href="<?php echo $URL; ?>/web/alineamientos"
                                        class="btn btn-default btn-lg">Cancelar</a>
                                    <a href="controller_delete_lineamiento.php?id=<?php echo $id_lineamiento; ?>"
                                        class="btn btn-danger btn-lg">Borrar Lineamiento</a>
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