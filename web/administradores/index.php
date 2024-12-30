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
        <title>Sistema de Gestión | PLADECO </title>
        <style>
            .table td.truncate {
                max-width: 200px;
                /* Ajusta el ancho máximo según tus necesidades */
                white-space: nowrap;
                /* Evita que el texto salte a la siguiente línea */
                overflow: hidden;
                /* Oculta el texto que excede el ancho máximo */
                text-overflow: ellipsis;
                /* Agrega puntos suspensivos al final */
            }
        </style>
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
                                    <h3 class="card-title"><span class="fa fa-users"></span> Listado de Administradores</h3>
                                    <div style="float:right;">
                                        <a href="create.php" class="btn btn-info pull-right"> <span
                                                class="fa fa-plus"></span>
                                            Nuevo administrador</a>
                                    </div>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <th style="background: #c0c0c0"><b>Nro</b></th>
                                                <th style="background: #c0c0c0"><b>Nombre Completo</b></th>
                                                <th style="background: #c0c0c0"><b>Cargo Funcionario</b></th>
                                                <th style="background: #c0c0c0"><b>Cargo Sistema</b></th>
                                                <th style="background: #c0c0c0"><b>Departamento</b></th>
                                                <th style="background: #c0c0c0"><b>Email</b></th>
                                                <th style="background: #c0c0c0"><b>Acciones</b></th>
                                                <?php
                                                $contador = 0;
                                                $query2 = $pdo->prepare("SELECT * FROM usuarios WHERE cargo = 'ADMINISTRADOR' AND estado ='1'");
                                                $query2->execute();
                                                $usuarios2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($usuarios2 as $usuario2) {
                                                    $id_usuario = $usuario2['id'];
                                                    $apellido = $usuario2['apellido'];
                                                    $nombre = $usuario2['nombre'];
                                                    $email = $usuario2['email'];
                                                    $cargo = $usuario2['cargo'];
                                                    $cargo_pladeco = $usuario2['cargo_pladeco'];
                                                    $departamento = $usuario2['departamento'];
                                                    $contador = $contador + 1;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $contador; ?></td>
                                                        <td class="truncate"><?php echo $nombre . " " . $apellido; ?></td>
                                                        <td class="truncate"><?php echo $cargo_pladeco; ?></td>
                                                        <td class="truncate"><?php echo $cargo; ?></td>
                                                        <td class="truncate"><?php echo $departamento; ?></td>
                                                        <td><?php echo $email; ?></td>
                                                        <td>
                                                            <a href="update.php?id=<?php echo $id_usuario; ?>"
                                                                class="btn btn-success btn-xs">
                                                                <span class="fa fa-pen"></span> Editar</a>
                                                            <a href="delete.php?id=<?php echo $id_usuario; ?>"
                                                                class="btn btn-danger btn-xs">
                                                                <span class="fa fa-trash"></span> Borrar</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
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