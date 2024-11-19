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

    // Obtener los valores de filtro
    $filtro_usuario = isset($_GET['filtro_usuario']) ? $_GET['filtro_usuario'] : '';
    $filtro_lineamiento = isset($_GET['filtro_lineamiento']) ? $_GET['filtro_lineamiento'] : '';
    $filtro_iniciativa = isset($_GET['filtro_iniciativa']) ? $_GET['filtro_iniciativa'] : '';

    $usuarios_query = $pdo->prepare("SELECT DISTINCT nombre FROM usuarios WHERE cargo = 'Usuario' AND estado = '2'");
    $usuarios_query->execute();
    $usuarios_filtro = $usuarios_query->fetchAll(PDO::FETCH_ASSOC);


    $lineamientos_query = $pdo->prepare("SELECT DISTINCT nombre_lineamiento FROM lineamiento");
    $lineamientos_query->execute();
    $lineamientos_filtro = $lineamientos_query->fetchAll(PDO::FETCH_ASSOC);

    $iniciativas_query = $pdo->prepare("SELECT DISTINCT nombre_iniciativa FROM iniciativas");
    $iniciativas_query->execute();
    $iniciativas_filtro = $iniciativas_query->fetchAll(PDO::FETCH_ASSOC);

    // Obtener la página actual
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Calcular el número total de tareas
    $countQuery = $pdo->prepare("
        SELECT COUNT(*) as total
        FROM tareas t
        JOIN asignaciones a ON t.id_asignacion = a.id_asignacion
        JOIN usuarios u ON a.id_usuario = u.id
        JOIN lineamiento l ON a.id_lineamiento = l.id_lineamiento
        JOIN iniciativas i ON t.id_iniciativa = i.id_iniciativa
        WHERE (:usuario = '' OR u.nombre = :usuario)
        AND (:lineamiento = '' OR l.nombre_lineamiento = :lineamiento)
        AND (:iniciativa = '' OR i.nombre_iniciativa = :iniciativa)
    ");
    $countQuery->execute([
        ':usuario' => $filtro_usuario,
        ':lineamiento' => $filtro_lineamiento,
        ':iniciativa' => $filtro_iniciativa
    ]);
    $totalTareas = $countQuery->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalTareas / $limit);

    // Consulta de tareas con filtros
    $queryTareas = $pdo->prepare("
        SELECT t.id_tarea, t.nombre_tarea, u.nombre AS usuario, l.nombre_lineamiento, i.nombre_iniciativa
        FROM tareas t
        JOIN asignaciones a ON t.id_asignacion = a.id_asignacion
        JOIN usuarios u ON a.id_usuario = u.id
        JOIN lineamiento l ON a.id_lineamiento = l.id_lineamiento
        JOIN iniciativas i ON t.id_iniciativa = i.id_iniciativa
        WHERE (:usuario = '' OR u.nombre = :usuario)
        AND (:lineamiento = '' OR l.nombre_lineamiento = :lineamiento)
        AND (:iniciativa = '' OR i.nombre_iniciativa = :iniciativa)
        LIMIT :limit OFFSET :offset

    ");
    $queryTareas->bindValue(':usuario', $filtro_usuario, PDO::PARAM_STR);
    $queryTareas->bindValue(':lineamiento', $filtro_lineamiento, PDO::PARAM_STR);
    $queryTareas->bindValue(':iniciativa', $filtro_iniciativa, PDO::PARAM_STR);
    $queryTareas->bindValue(':limit', $limit, PDO::PARAM_INT);
    $queryTareas->bindValue(':offset', $offset, PDO::PARAM_INT);
    $queryTareas->execute();
    $tareas = $queryTareas->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Listado de Tareas | PLADECO</title>
    </head>

    <body class="g-sidenav-show bg-gray-100">
        <div class="wrapper" style="margin-left: 20px;">
            <?php include('../../layout/menu.php'); ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-tasks"></span> Listado de Tareas</h3>
                                </div>
                                <div class="card-body">

                                    <form method="GET" action="index.php">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="filtro_usuario" class="form-label">Usuario</label>
                                                    <select class="form-select" id="filtro_usuario" name="filtro_usuario">
                                                        <option value="">Seleccione un usuario</option>
                                                        <?php foreach ($usuarios_filtro as $usuario): ?>
                                                            <option value="<?php echo $usuario['nombre']; ?>" <?php echo $filtro_usuario == $usuario['nombre'] ? 'selected' : ''; ?>>
                                                                <?php echo $usuario['nombre']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="filtro_lineamiento" class="form-label">Lineamiento</label>
                                                    <select class="form-select" id="filtro_lineamiento"
                                                        name="filtro_lineamiento">
                                                        <option value="">Seleccione un lineamiento</option>
                                                        <?php foreach ($lineamientos_filtro as $lineamiento): ?>
                                                            <option value="<?php echo $lineamiento['nombre_lineamiento']; ?>"
                                                                <?php echo $filtro_lineamiento == $lineamiento['nombre_lineamiento'] ? 'selected' : ''; ?>>
                                                                <?php echo $lineamiento['nombre_lineamiento']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="filtro_iniciativa" class="form-label">Iniciativa</label>
                                                    <select class="form-select" id="filtro_iniciativa"
                                                        name="filtro_iniciativa">
                                                        <option value="">Seleccione una iniciativa</option>
                                                        <?php foreach ($iniciativas_filtro as $iniciativa): ?>
                                                            <option value="<?php echo $iniciativa['nombre_iniciativa']; ?>"
                                                                <?php echo $filtro_iniciativa == $iniciativa['nombre_iniciativa'] ? 'selected' : ''; ?>>
                                                                <?php echo $iniciativa['nombre_iniciativa']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end mt-2">
                                            <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                                            <a href="index.php" class="btn btn-secondary mb-2">Limpiar Filtros</a>
                                        </div>
                                    </form>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Tarea</th>
                                                <th>Nombre de Tarea</th>
                                                <th>Usuario</th>
                                                <th>Lineamiento</th>
                                                <th>Iniciativa</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tareas as $tarea): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($tarea['id_tarea']); ?></td>
                                                    <td><?php echo htmlspecialchars($tarea['nombre_tarea']); ?></td>
                                                    <td><?php echo htmlspecialchars($tarea['usuario']); ?></td>
                                                    <td><?php echo htmlspecialchars($tarea['nombre_lineamiento']); ?></td>
                                                    <td><?php echo htmlspecialchars($tarea['nombre_iniciativa']); ?></td>
                                                    <td>
                                                        <a href="ver_tarea.php?id_tarea=<?php echo $tarea['id_tarea']; ?>"
                                                            class="btn btn-primary btn-sm">Ver
                                                            Tarea</a>
                                                        <a href="editar_tarea.php?id_tarea=<?php echo $tarea['id_tarea']; ?>"
                                                            class="btn btn-warning btn-sm">Editar</a>
                                                        <a href="borrar_tarea.php?id_tarea=<?php echo $tarea['id_tarea']; ?>"
                                                            class="btn btn-danger btn-sm">Borrar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <!-- Paginación -->
                                    <nav class="mt-4">
                                        <ul class="pagination d-flex justify-content-center">
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                    <a class="page-link"
                                                        href="?page=<?php echo $i; ?>&filtro_usuario=<?php echo $filtro_usuario; ?>&filtro_lineamiento=<?php echo $filtro_lineamiento; ?>&filtro_iniciativa=<?php echo $filtro_iniciativa; ?>">
                                                        <?php echo $i; ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>
                                        </ul>
                                    </nav>

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
    exit();
}
?>