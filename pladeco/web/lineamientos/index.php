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
        <title>Iniciativas | PLADECO </title>
    </head>

    <body class="g-sidenav-show bg-gray-100">
        <div class="wrapper">
            <?php include('../../layout/menu.php'); ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-users"></span> Listado de Iniciativas</h3>
                                    <div style="float:right;">
                                        <a href="crear_iniciativa.php" class="btn btn-primary btn-sm"><span
                                                class="fa fa-plus"></span> Agregar Iniciativa</a>

                                    </div>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <th style="background: #c0c0c0"><b>Nro</b></th>
                                                <th style="background: #c0c0c0"><b>Nombre de la Iniciativa</b></th>
                                                <th style="background: #c0c0c0"><b>Descripción de la Iniciativa</b></th>
                                                <th style="background: #c0c0c0"><b>Lineamiento Correspondiente</b></th>
                                                <th style="background: #c0c0c0"><b>Acciones</b></th>
                                                <?php
                                                $contador = 0;
                                                // Consultar la tabla de iniciativas y obtener el nombre del lineamiento relacionado
                                                $query2 = $pdo->prepare("SELECT i.id_iniciativa, i.nombre_iniciativa, i.descripcion_iniciativa, l.nombre_lineamiento 
                                                                         FROM iniciativas i 
                                                                         JOIN lineamiento l ON i.id_lineamiento = l.id_lineamiento");
                                                $query2->execute();
                                                $iniciativas = $query2->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($iniciativas as $iniciativa) {
                                                    $contador++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $contador; ?></td>
                                                        <td><?php echo htmlspecialchars($iniciativa['nombre_iniciativa']); ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($iniciativa['descripcion_iniciativa']); ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($iniciativa['nombre_lineamiento']); ?>
                                                        </td>

                                                        <td>
                                                            <a href="update.php?id=<?php echo $iniciativa['id_iniciativa']; ?>"
                                                                class="btn btn-success btn-xs">
                                                                <span class="fa fa-pen"></span> Editar
                                                            </a>
                                                            <a href="delete.php?id=<?php echo $iniciativa['id_iniciativa']; ?>"
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