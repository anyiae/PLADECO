<?php include('../../app/config/config.php');

$id_usuario = $_GET['id'];

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
        <title>Gestión de Usuarios | PLADECO </title>
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
                                    <h3 class="card-title"><span class="fa fa-trash"></span> Borrar Iniciativa</h3>
                                </div><!-- /.card-body -->
                                <div class="card-body">
                                    <?php
                                    // Obtener el ID de la iniciativa desde la URL
                                    $id_iniciativa = $_GET['id'];

                                    // Consultar los detalles de la iniciativa
                                    $query2 = $pdo->prepare("SELECT * FROM iniciativas WHERE id_iniciativa = :id_iniciativa");
                                    $query2->bindParam(':id_iniciativa', $id_iniciativa);
                                    $query2->execute();
                                    $datos = $query2->fetch(PDO::FETCH_ASSOC);

                                    $nombre_iniciativa = $datos['nombre_iniciativa'];
                                    $descripcion_iniciativa = $datos['descripcion_iniciativa'];
                                    ?>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Nombre de la Iniciativa</label>
                                                <input type="text" class="form-control" name="nombre_iniciativa"
                                                    value="<?php echo $nombre_iniciativa; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Descripción de la Iniciativa</label>
                                                <textarea class="form-control" name="descripcion_iniciativa"
                                                    disabled><?php echo $descripcion_iniciativa; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a href="<?php echo $URL; ?>/web/iniciativas"
                                        class="btn btn-default btn-lg">Cancelar</a>
                                    <a href="controller_delete.php?id=<?php echo $id_iniciativa; ?>"
                                        class="btn btn-danger btn-lg">Borrar Iniciativa</a>
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