<?php
include('../../app/config/config.php');

session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    // Verificar si el usuario es administrador
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND estado = '1'");
    $query->bindParam(':email', $user);
    $query->execute();
    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuarios as $usuario) {
        $id_usuario_s = $usuario['id'];
        $nombre_s = $usuario['nombre'];
        $apellido_s = $usuario['apellido'];
        $cargo_s = $usuario['cargo'];
        $cargo_pladeco_s = $usuario['cargo_pladeco'];
        $departamento_s = $usuario['departamento'];
    }
    // Verificar que se pase el id de la tarea por GET
    if (isset($_GET['id_tarea'])) {
        $id_tarea = $_GET['id_tarea'];

        // Consulta para obtener los detalles de la tarea
        $queryTarea = $pdo->prepare("SELECT * FROM tareas WHERE id_tarea = :id_tarea");
        $queryTarea->execute(['id_tarea' => $id_tarea]);
        $tarea = $queryTarea->fetch(PDO::FETCH_ASSOC);

        if ($tarea) {
            // Obtener la asignación relacionada con esta tarea para encontrar id_lineamiento
            $queryAsignacion = $pdo->prepare("SELECT id_lineamiento, id_usuario FROM asignaciones WHERE id_asignacion = :id_asignacion");
            $queryAsignacion->execute(['id_asignacion' => $tarea['id_asignacion']]);
            $asignacion = $queryAsignacion->fetch(PDO::FETCH_ASSOC);

            if ($asignacion) {
                $id_lineamiento = $asignacion['id_lineamiento'];
                $id_usuario = $asignacion['id_usuario'];

                // Consultas para obtener usuarios, lineamientos e iniciativas
                $usuarios = $pdo->query("SELECT id, nombre FROM usuarios WHERE cargo = 'Usuario'")->fetchAll(PDO::FETCH_ASSOC);
                $lineamientos = $pdo->query("SELECT id_lineamiento, nombre_lineamiento FROM lineamiento")->fetchAll(PDO::FETCH_ASSOC);
                $iniciativas = $pdo->query("SELECT id_iniciativa, nombre_iniciativa FROM iniciativas WHERE id_lineamiento = $id_lineamiento")->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "No se encontró la asignación para esta tarea.";
                exit;
            }
        } else {
            echo "No se encontró la tarea.";
            exit;
        }
    } else {
        echo "ID de tarea no especificado.";
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Ver Tarea | PLADECO</title>
        <style>
            .form-control-static {
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                background-color: #f9f9f9;
            }

            .form-group label {
                font-size: 1.2em;
                font-weight: bold;
            }
        </style>
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
                                    <!-- Botón de regreso -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title"><span class="fa fa-tasks"></span> Ver Tarea</h3>
                                        <a href="index.php" class="btn btn-secondary">
                                            <span class="fa fa-arrow-left"></span> Volver
                                        </a>
                                    </div>

                                    <div class="card-body">
                                        <form>
                                            <input type="hidden" name="id_tarea" value="<?php echo $tarea['id_tarea']; ?>">
                                            <!-- Campos para ver la tarea (solo lectura) -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nombre_tarea">Nombre de la Tarea</label>
                                                        <p class="form-control-static"><?php echo $tarea['nombre_tarea']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="descripcion_tarea">Descripción</label>
                                                        <p class="form-control-static">
                                                            <?php echo $tarea['descripcion_tarea']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fecha_inicio">Fecha de Inicio</label>
                                                        <p class="form-control-static"><?php echo $tarea['fecha_inicio']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fecha_fin">Fecha de Fin</label>
                                                        <p class="form-control-static"><?php echo $tarea['fecha_fin']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="costo">Costo</label>
                                                        <p class="form-control-static"><?php echo $tarea['costo']; ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- Mostrar el usuario asignado -->
                                                    <div class="form-group">
                                                        <label for="usuario">Usuario Asignado</label>
                                                        <p class="form-control-static">
                                                            <?php
                                                            $usuarioSeleccionado = array_filter($usuarios, function ($usuario) use ($id_usuario) {
                                                                return $usuario['id'] == $id_usuario;
                                                            });
                                                            echo reset($usuarioSeleccionado)['nombre'];
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <!-- Mostrar el lineamiento -->
                                                    <div class="form-group">
                                                        <label for="lineamiento">Lineamiento</label>
                                                        <p class="form-control-static">
                                                            <?php
                                                            $lineamientoSeleccionado = array_filter($lineamientos, function ($lineamiento) use ($id_lineamiento) {
                                                                return $lineamiento['id_lineamiento'] == $id_lineamiento;
                                                            });
                                                            echo reset($lineamientoSeleccionado)['nombre_lineamiento'];
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <!-- Mostrar la iniciativa -->
                                                    <div class="form-group">
                                                        <label for="iniciativa">Iniciativa</label>
                                                        <p class="form-control-static">
                                                            <?php
                                                            $iniciativaSeleccionada = array_filter($iniciativas, function ($iniciativa) use ($tarea) {
                                                                return $iniciativa['id_iniciativa'] == $tarea['id_iniciativa'];
                                                            });
                                                            echo reset($iniciativaSeleccionada)['nombre_iniciativa'];
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                </section>
            </div><!-- /.content-wrapper -->
        </div><!-- /.wrapper -->
        <?php include('../../layout/footer_link.php'); ?>
    </body>

    </html>
    <?php
} else {
    header("Location: $URL/login");
}
?>