<?php
include('../../app/config/config.php');

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

    // Obtener el ID del lineamiento desde la URL
    $id_lineamiento = $_GET['id'];

    // Obtener los datos del lineamiento desde la base de datos
    $query = $pdo->prepare("SELECT * FROM lineamiento WHERE id_lineamiento = :id_lineamiento");
    $query->bindParam(':id_lineamiento', $id_lineamiento);
    $query->execute();
    $lineamiento = $query->fetch(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Editar Lineamiento | PLADECO </title>
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
                                    <h3 class="card-title"><span class="fa fa-lightbulb"></span> Actualización de
                                        Lineamiento
                                    </h3>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <form action="controller_update_lineamiento.php" method="post">
                                        <input type="hidden" name="id_lineamiento" value="<?php echo $id_lineamiento; ?>">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="nombre_lineamiento">Nombre del Lineamiento</label>
                                                    <input type="text" class="form-control" name="nombre_lineamiento"
                                                        value="<?php echo htmlspecialchars($lineamiento['nombre_lineamiento']); ?>"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="descripcion_lineamiento">Descripción del Lineamiento</label>
                                                    <textarea class="form-control" name="descripcion_lineamiento"
                                                        required><?php echo htmlspecialchars($lineamiento['descripcion_lineamiento']); ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="umr">UMR Responsable</label>
                                                    <input type="text" class="form-control" name="umr"
                                                        value="<?php echo htmlspecialchars($lineamiento['umr']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <a href="<?php echo $URL; ?>/web/alineamientos"
                                            class="btn btn-default btn-lg">Cancelar</a>
                                        <input type="submit" class="btn btn-success btn-lg" value="Actualizar Lineamiento">
                                    </form>
                                </div><!-- /.card-body -->
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
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