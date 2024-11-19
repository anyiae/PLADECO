<?php
include('../../app/config/config.php');

session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    // Obtener datos del usuario
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :user AND estado = '1'");
    $query->bindParam(':user', $user);
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

                // Consulta para obtener usuarios, lineamientos e iniciativas relacionadas con id_lineamiento
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
        <title>Editar Tarea | PLADECO</title>
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
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title mb-0"><span class="fa fa-tasks"></span> Editar Tarea</h3>
                                    <a href="http://localhost/pladeco/pladeco/web/iniciativas/index.php"
                                        class="btn btn-secondary">
                                        <span class="fa fa-arrow-left"></span> Volver
                                    </a>
                                </div>
                                <div class="card-body">
                                    <form action="controller_update_tarea.php" method="post">
                                        <input type="hidden" name="id_tarea" value="<?php echo $tarea['id_tarea']; ?>">

                                        <!-- Campos para editar la tarea -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombre_tarea">Nombre de la Tarea</label>
                                                    <input type="text" class="form-control" name="nombre_tarea"
                                                        value="<?php echo $tarea['nombre_tarea']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="descripcion_tarea">Descripción</label>
                                                    <textarea class="form-control"
                                                        name="descripcion_tarea"><?php echo $tarea['descripcion_tarea']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fecha_inicio">Fecha de Inicio</label>
                                                    <input type="date" class="form-control" name="fecha_inicio"
                                                        value="<?php echo $tarea['fecha_inicio']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="fecha_fin">Fecha de Fin</label>
                                                    <input type="date" class="form-control" name="fecha_fin"
                                                        value="<?php echo $tarea['fecha_fin']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="costo">Costo</label>
                                                    <input type="number" class="form-control" name="costo"
                                                        value="<?php echo $tarea['costo']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Select para cambiar usuario, lineamiento e iniciativa -->
                                                <div class="form-group">
                                                    <label for="usuario">Usuario Asignado</label>
                                                    <select class="form-control" name="id_usuario">
                                                        <?php foreach ($usuarios as $usuario): ?>
                                                            <option value="<?php echo $usuario['id']; ?>" <?php echo ($usuario['id'] == $id_usuario) ? 'selected' : ''; ?>>
                                                                <?php echo $usuario['nombre']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="lineamiento">Lineamiento</label>
                                                    <select class="form-control" name="id_lineamiento" id="id_lineamiento">
                                                        <?php foreach ($lineamientos as $lineamiento): ?>
                                                            <option value="<?php echo $lineamiento['id_lineamiento']; ?>" <?php echo ($lineamiento['id_lineamiento'] == $id_lineamiento) ? 'selected' : ''; ?>>
                                                                <?php echo $lineamiento['nombre_lineamiento']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="iniciativa">Iniciativa</label>
                                                    <select class="form-control" name="id_iniciativa" id="id_iniciativa">
                                                        <?php foreach ($iniciativas as $iniciativa): ?>
                                                            <option value="<?php echo $iniciativa['id_iniciativa']; ?>" <?php echo ($iniciativa['id_iniciativa'] == $tarea['id_iniciativa']) ? 'selected' : ''; ?>>
                                                                <?php echo $iniciativa['nombre_iniciativa']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <a href="<?php echo $URL; ?>/web/iniciativas"
                                                class="btn btn-default btn-lg">Cancelar</a>
                                            <input type="submit" class="btn btn-primary btn-lg" value="Guardar Cambios">
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