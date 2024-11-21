<?php
include('../../app/config/config.php');

session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = '$user' AND estado ='2'");
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
        <title>Mis Verificaciones | PLADECO</title>
        <style>
            /* Evita el desbordamiento en las celdas de la tabla */
            .table td,
            .table th {
                white-space: normal;
                /* Permite que el texto se divida en varias líneas */
                word-wrap: break-word;
                /* Permite que el texto largo se ajuste dentro de la celda */
            }

            /* Opcional: Ajusta la altura de las filas si el contenido se expande mucho */
            .table td {
                word-break: break-word;
                max-width: 200px;
                /* Puedes ajustar el tamaño de las celdas */
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <?php include('../../layout/menu.php'); ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-comments"></span> Comentarios Administrador
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Nro</th>
                                                        <th>Nombre de la Tarea</th>
                                                        <th>Descripción</th>
                                                        <th>Fecha de Inicio</th>
                                                        <th>Fecha de Fin</th>
                                                        <th>Comentarios Administrador</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $contador = 0;
                                                    // Consultar las tareas asignadas al usuario actual, que no están verificadas y tienen comentarios del administrador
                                                    $query2 = $pdo->prepare("SELECT t.*, vt.comentarios_admin FROM tareas t 
                                                    JOIN asignaciones a ON t.id_asignacion = a.id_asignacion 
                                                    LEFT JOIN verificacion_tareas vt ON t.id_tarea = vt.id_tarea
                                                    WHERE a.id_usuario = :id_usuario  
                                                    AND (vt.verificado IS NULL OR vt.verificado = 'NO') 
                                                    AND vt.comentarios_admin IS NOT NULL 
                                                    AND vt.comentarios_admin != ''"); // Filtra tareas con comentarios del administrador
                                                
                                                    $query2->bindParam(':id_usuario', $id_usuario_s);
                                                    $query2->execute();
                                                    $tareas = $query2->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($tareas as $tarea) {
                                                        $contador++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $contador; ?></td>
                                                            <td><?php echo htmlspecialchars($tarea['nombre_tarea']); ?></td>
                                                            <td><?php echo htmlspecialchars($tarea['descripcion_tarea']); ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($tarea['fecha_inicio']); ?></td>
                                                            <td><?php echo htmlspecialchars($tarea['fecha_fin']); ?></td>
                                                            <td>
                                                                <?php
                                                                // Mostrar los comentarios del administrador
                                                                if ($tarea['comentarios_admin']) {
                                                                    echo htmlspecialchars($tarea['comentarios_admin']);
                                                                } else {
                                                                    echo 'Sin comentarios';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <!-- Botón para modificar los comentarios -->
                                                                <form action="cambiar.php" method="POST"
                                                                    style="display: inline;">
                                                                    <input type="hidden" name="id_tarea"
                                                                        value="<?php echo $tarea['id_tarea']; ?>">
                                                                    <button type="submit" class="btn btn-warning btn-xs">
                                                                        <span class="fa fa-edit"></span> Modificar
                                                                    </button>
                                                                </form>
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