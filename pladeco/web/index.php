<?php include('../app/config/config.php');

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
        $cargo_pladeco_s = $usuario['cargo_pladeco'];
        $cargo_s = $usuario['cargo'];
        $departamento_s = $usuario['departamento'];
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../layout/head.php'); ?>
        <title>Administración</title>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <?php include('../layout/menu.php'); ?>
            <div class="min-height-300 position-absolute w-100"
                style="top: 0; left: 0; z-index: -1; background-image: url('../app/templeates/argon-dashboard-master/assets/img/background.png'); background-size: cover; background-position: center;">
            </div>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container" style="margin-right:80px;">
                            <br>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-user"></span> Usuario Disponible</h3>
                                </div>
                                <div class="card-body">
                                    <p>Bienvenido al sistema de gestión</p>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td style="background: #c0c0c0"><b>Nombre:</b></td>
                                                    <td><?php echo $nombre_s . "  " . $apellido_s; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="background: #c0c0c0"><b>Cargo Pladeco:</b></td>
                                                    <td><?php echo $cargo_pladeco_s; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="background: #c0c0c0"><b>Departamento:</b></td>
                                                    <td><?php echo $departamento_s; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include('../layout/footer.php'); ?>
        </div>
        <?php include('../layout/footer_link.php'); ?>
    </body>

    </html>
    <?php
} else {
    header("Location: $URL/login");
}
?>