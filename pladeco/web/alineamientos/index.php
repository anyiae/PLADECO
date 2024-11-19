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
        <title>Lineamientos | PLADECO</title>
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
                                    <h3 class="card-title"><span class="fa fa-lightbulb"></span> Listado de Lineamientos
                                    </h3>
                                    <div style="float:right;">
                                        <a href="crear_lineamiento.php" class="btn btn-primary btn-sm"><span
                                                class="fa fa-plus"></span> Agregar Lineamiento</a>
                                    </div>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th style="background: #c0c0c0"><b>Nro</b></th>
                                                        <th style="background: #c0c0c0"><b>Nombre del Lineamiento</b></th>
                                                        <th style="background: #c0c0c0"><b>Descripción del Lineamiento</b>
                                                        </th>
                                                        <th style="background: #c0c0c0"><b>UMR Responsable</b></th>
                                                        <th style="background: #c0c0c0"><b>Acciones</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $contador = 0;
                                                    // Consultar la tabla de lineamientos
                                                    $query2 = $pdo->prepare("SELECT * FROM lineamiento");
                                                    $query2->execute();
                                                    $lineamientos = $query2->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($lineamientos as $lineamiento) {
                                                        $contador++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $contador; ?></td>
                                                            <td><?php echo htmlspecialchars($lineamiento['nombre_lineamiento']); ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($lineamiento['descripcion_lineamiento']); ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($lineamiento['umr']); ?></td>

                                                            <td>
                                                                <a href="editar_lineamiento.php?id=<?php echo $lineamiento['id_lineamiento']; ?>"
                                                                    class="btn btn-success btn-xs">
                                                                    <span class="fa fa-pen"></span> Editar
                                                                </a>
                                                                <a href="eliminar_lineamiento.php?id=<?php echo $lineamiento['id_lineamiento']; ?>"
                                                                    class="btn btn-danger btn-xs">
                                                                    <span class="fa fa-trash"></span> Borrar
                                                                </a>
                                                            </td>
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