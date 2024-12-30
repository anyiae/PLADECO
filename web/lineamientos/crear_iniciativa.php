<?php include('../../app/config/config.php');

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
    // Consulta para obtener los lineamientos
    $query_lineamientos = $pdo->prepare("SELECT * FROM lineamiento");
    $query_lineamientos->execute();
    $lineamientos = $query_lineamientos->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Crear Iniciativa | PLADECO </title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                    <h3 class="card-title"><span class="fa fa-lightbulb"></span> Crear Nueva Iniciativa</h3>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <form action="guardar_iniciativa.php" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lineamiento">Seleccionar Lineamiento</label>
                                                    <select id="lineamiento" name="lineamiento_id" class="form-control"
                                                        required>
                                                        <option value="">Seleccione un lineamiento</option>
                                                        <?php foreach ($lineamientos as $lineamiento) {
                                                            echo '<option value="' . $lineamiento['id_lineamiento'] . '">' . $lineamiento['nombre_lineamiento'] . '</option>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombre_iniciativa">Nombre de la Iniciativa</label>
                                                    <input type="text" id="nombre_iniciativa" name="nombre_iniciativa"
                                                        class="form-control"
                                                        placeholder="Ingrese el nombre de la iniciativa" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="descripcion_iniciativa">Descripción de la Iniciativa</label>
                                                    <textarea id="descripcion_iniciativa" name="descripcion_iniciativa"
                                                        class="form-control"
                                                        placeholder="Ingrese la descripción de la iniciativa"
                                                        required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <a href="<?php echo $URL; ?>/web/iniciativas"
                                                class="btn btn-default btn-lg">Cancelar</a>
                                            <input type="submit" class="btn btn-primary btn-lg" value="Guardar Iniciativa">
                                        </div>
                                    </form>
                                </div>
                                <br>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </body>

    </html>
    <?php
} else {
    header('Location: ../../index.php');
}
?>