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
                                    <h3 class="card-title"><span class="fa fa-users"></span> Borrar usuario</h3>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <?php
                                    $query2 = $pdo->prepare("SELECT * FROM usuarios WHERE id = '$id_usuario' AND estado ='2'");
                                    $query2->execute();
                                    $datos = $query2->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($datos as $dato) {
                                        $id_usuario_d = $dato['id'];
                                        $nombre = $dato['nombre'];
                                        $apellido = $dato['apellido'];
                                        $cargo_pladeco = $dato['cargo_pladeco'];
                                        $departamento = $dato['departamento'];
                                        $email = $dato['email'];
                                        $password = $dato['password'];
                                        $cargo = $dato['cargo'];
                                    }
                                    ?>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Nombre</label>
                                                <input type="text" class="form-control" name="nombre"
                                                    value="<?php echo $nombre; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Apellido</label>
                                                <input type="text" class="form-control" name="apellido"
                                                    value="<?php echo $apellido; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Cargo Funcionario</label>
                                                <input type="text" class="form-control" name="cargo_pladeco"
                                                    value="<?php echo $cargo_pladeco; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Correo Electrónico</label>
                                                <input type="email" class="form-control" value="<?php echo $email; ?>"
                                                    disabled>
                                                <input type="email" name="email" value="<?php echo $email; ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Departamento</label>
                                                <input type="text" class="form-control" name="departamento"
                                                    value="<?php echo $departamento; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Cargo Sistema</label>
                                                <select name="cargo" id="cargo" class="form-control" disabled>
                                                    <option value="Usuario" <?php echo ($cargo == 'Usuario') ? 'selected' : ''; ?>>Usuario</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <input type="text" class="form-control" name="password"
                                                    value="<?php echo $password; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a href="<?php echo $URL; ?>/web/administradores"
                                        class="btn btn-default btn-lg">Cancelar</a>
                                    <a href="controller_delete.php?email=<?php echo $email; ?>"
                                        class="btn btn-danger btn-lg">Borrar Usuario</a>

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