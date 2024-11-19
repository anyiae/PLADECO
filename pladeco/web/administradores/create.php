<?php include('../../app/config/config.php');

session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    //echo "session de ".$user; ///////////para comprobar sesion

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
        <title>Creación de Administradores | PLADECO</title>
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
                                    <h3 class="card-title"><span class="fa fa-users"></span> Creación de un nuevo
                                        administrador</h3>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <form action="controller_create.php" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombre">Nombre</label>
                                                    <input type="text" class="form-control" name="nombre">
                                                </div>
                                                <div class="form-group">
                                                    <label for="apellido">Apellido</label>
                                                    <input type="text" class="form-control" name="apellido">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Correo Electrónico</label>
                                                    <input type="email" class="form-control" name="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cargo_pladeco">Cargo Funcionario</label>
                                                    <input type="text" class="form-control" name="cargo_pladeco">
                                                </div>
                                                <div class="form-group">
                                                    <label for="departamento">Departamento</label>
                                                    <input type="text" class="form-control" name="departamento">
                                                </div>
                                                <div class="form-group">
                                                    <label for="cargo">Cargo</label>
                                                    <select name="cargo" id="cargo" class="form-control">
                                                        <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Contraseña</label>
                                                    <input type="password" class="form-control" name="password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <a href="<?php echo $URL; ?>/web/administradores"
                                                class="btn btn-default btn-lg">Cancelar</a>
                                            <input type="submit" class="btn btn-primary btn-lg" value="Registrar Usuario">
                                        </div>
                                    </form>
                                </div>
                                <br>

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