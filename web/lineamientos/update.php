<?php
include('../../app/config/config.php');

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

    // Obtener el ID de la iniciativa desde la URL
    $id_iniciativa = $_GET['id'];

    // Obtener los datos de la iniciativa desde la base de datos
    $query = $pdo->prepare("SELECT * FROM iniciativas WHERE id_iniciativa = :id_iniciativa");
    $query->bindParam(':id_iniciativa', $id_iniciativa);
    $query->execute();
    $iniciativa = $query->fetch(PDO::FETCH_ASSOC);

    // Obtener los lineamientos disponibles
    $query_lineamientos = $pdo->prepare("SELECT * FROM lineamiento");
    $query_lineamientos->execute();
    $lineamientos = $query_lineamientos->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Editar Iniciativas | PLADECO </title>
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
                                    <h3 class="card-title"><span class="fa fa-users"></span> Actualización de Iniciativas
                                    </h3>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <?php
                                    // Obtener el ID de la iniciativa a actualizar desde el parámetro en la URL
                                    $id_iniciativa = $_GET['id'];

                                    // Consultar la iniciativa por ID
                                    $query2 = $pdo->prepare("SELECT * FROM iniciativas WHERE id_iniciativa = :id_iniciativa");
                                    $query2->bindParam(':id_iniciativa', $id_iniciativa);
                                    $query2->execute();
                                    $datos = $query2->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($datos as $dato) {
                                        $id_iniciativa_d = $dato['id_iniciativa'];
                                        $nombre_iniciativa = $dato['nombre_iniciativa'];
                                        $descripcion_iniciativa = $dato['descripcion_iniciativa'];
                                        $id_lineamiento = $dato['id_lineamiento'];
                                    }

                                    // Consultar el nombre del lineamiento actual
                                    $query3 = $pdo->prepare("SELECT nombre_lineamiento FROM lineamiento WHERE id_lineamiento = :id_lineamiento");
                                    $query3->bindParam(':id_lineamiento', $id_lineamiento);
                                    $query3->execute();
                                    $lineamiento = $query3->fetch(PDO::FETCH_ASSOC);
                                    $nombre_lineamiento = $lineamiento['nombre_lineamiento'];
                                    ?>

                                    <form action="controller_update.php?id=<?php echo $id_iniciativa; ?>" method="post">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Nombre de la Iniciativa</label>
                                                    <input type="text" class="form-control" name="nombre_iniciativa"
                                                        value="<?php echo htmlspecialchars($nombre_iniciativa); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Descripción de la Iniciativa</label>
                                                    <textarea class="form-control"
                                                        name="descripcion_iniciativa"><?php echo htmlspecialchars($descripcion_iniciativa); ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Lineamiento Correspondiente</label>
                                                    <select name="id_lineamiento" class="form-control" required>
                                                        <?php foreach ($lineamientos as $lineamiento) { ?>
                                                            <option value="<?php echo $lineamiento['id_lineamiento']; ?>"
                                                                <?php echo $lineamiento['id_lineamiento'] == $id_lineamiento ? 'selected' : ''; ?>>
                                                                <?php echo $lineamiento['nombre_lineamiento']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <a href="<?php echo $URL; ?>/web/iniciativas"
                                            class="btn btn-default btn-lg">Cancelar</a>
                                        <input type="submit" class="btn btn-success btn-lg" value="Actualizar Iniciativa">
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
