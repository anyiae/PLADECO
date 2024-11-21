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

    // Obtener página actual y tareas por página
    $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    $tareas_por_pagina = 10;
    $offset = ($pagina_actual - 1) * $tareas_por_pagina;

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Tareas Asignadas | PLADECO</title>
        <style>
            .table td,
            .table th {
                white-space: normal;
                /* Cambiar de 'nowrap' a 'normal' para que el texto se ajuste */
            }

            .table td.descripcion {
                white-space: normal;
                /* Asegura que el texto de descripción se ajuste */
                word-wrap: break-word;
                /* Permite el ajuste de palabras largas */
                overflow-wrap: break-word;
                /* Compatibilidad adicional */
            }

            .verification-icon {
                position: relative;
                cursor: pointer;
                display: inline-block;
                /* Asegura que el icono esté en línea con el número */
                margin-left: 5px;
                /* Espacio entre el número y el icono */
            }

            .verification-tooltip {
                display: none;
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                background-color: #333;
                color: #fff;
                text-align: center;
                padding: 5px;
                border-radius: 5px;
                white-space: nowrap;
                z-index: 200000;
            }

            tr {
                height: auto;
                /* Ajusta automáticamente la altura de las filas */
            }

            .verification-icon:hover .verification-tooltip {
                display: block;
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper" style="margin-left: 20px;">
            <?php include('../../layout/menu.php'); ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-tasks"></span> Tareas Asignadas</h3>
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
                                                        <th>Semáforo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $contador = $offset;

                                                    // Consulta para obtener tareas con paginación y verificar si hay archivos enviados
                                                    $query2 = $pdo->prepare("SELECT t.*, v.medio_verificacion FROM tareas t 
                                                                            JOIN asignaciones a ON t.id_asignacion = a.id_asignacion 
                                                                            LEFT JOIN verificacion_tareas v ON t.id_tarea = v.id_tarea 
                                                                            WHERE a.id_usuario = :id_usuario 
                                                                            AND (v.verificado IS NULL OR v.verificado = 'NO')
                                                                            LIMIT :offset, :tareas_por_pagina");
                                                    $query2->bindParam(':id_usuario', $id_usuario_s);
                                                    $query2->bindParam(':offset', $offset, PDO::PARAM_INT);
                                                    $query2->bindParam(':tareas_por_pagina', $tareas_por_pagina, PDO::PARAM_INT);
                                                    $query2->execute();
                                                    $tareas = $query2->fetchAll(PDO::FETCH_ASSOC);

                                                    // Función para calcular el semáforo
                                                    function calcularSemaforo($fecha_inicio, $fecha_fin)
                                                    {
                                                        $fecha_inicio_dt = strtotime($fecha_inicio);
                                                        $fecha_fin_dt = strtotime($fecha_fin);
                                                        $hoy = time();
                                                        $diferencia_total = $fecha_fin_dt - $fecha_inicio_dt;
                                                        $diferencia_hoy = $hoy - $fecha_inicio_dt;

                                                        if ($diferencia_hoy <= $diferencia_total * 0.33) {
                                                            return 'verde';
                                                        } elseif ($diferencia_hoy <= $diferencia_total * 0.66) {
                                                            return 'amarillo';
                                                        } else {
                                                            return 'rojo';
                                                        }
                                                    }

                                                    foreach ($tareas as $tarea) {
                                                        $contador++;
                                                        $color_semaforo = calcularSemaforo($tarea['fecha_inicio'], $tarea['fecha_fin']);
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $contador; ?>
                                                                <?php if (!is_null($tarea['medio_verificacion']) && $tarea['medio_verificacion'] != ''): ?>
                                                                    <div class="verification-icon">
                                                                        <span class="fa fa-check-circle text-success"></span>
                                                                        <span class="verification-tooltip">¡Ya has enviado la
                                                                            verificación!</span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($tarea['nombre_tarea']); ?></td>
                                                            <td class="descripcion">
                                                                <?php echo htmlspecialchars($tarea['descripcion_tarea']); ?>
                                                            </td>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($tarea['fecha_inicio']); ?></td>
                                                            <td><?php echo htmlspecialchars($tarea['fecha_fin']); ?></td>
                                                            <td>
                                                                <?php
                                                                $semaforo_src = "/pladeco/pladeco/public/semaforo_" . $color_semaforo . ".svg";
                                                                echo "<img src='$semaforo_src' alt='Semáforo $color_semaforo' max-width='100%' height='70'>";
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <form
                                                                    action="verificar_tarea.php?id_tarea=<?php echo $tarea['id_tarea']; ?>"
                                                                    method="POST" style="display: inline;">
                                                                    <button type="submit" class="btn btn-info btn-xs">
                                                                        <span class="fa fa-check"></span> Verificar
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                            <?php
                                            // Paginación
                                            $query3 = $pdo->prepare("SELECT COUNT(*) as total FROM tareas t 
                                                                     JOIN asignaciones a ON t.id_asignacion = a.id_asignacion 
                                                                     LEFT JOIN verificacion_tareas v ON t.id_tarea = v.id_tarea 
                                                                     WHERE a.id_usuario = :id_usuario
                                                                     AND (v.verificado IS NULL OR v.verificado = 'NO')");
                                            $query3->bindParam(':id_usuario', $id_usuario_s);
                                            $query3->execute();
                                            $total_tareas = $query3->fetch(PDO::FETCH_ASSOC)['total'];
                                            $total_paginas = ceil($total_tareas / $tareas_por_pagina);

                                            if ($total_paginas > 1): ?>
                                                <nav>
                                                    <ul class="pagination">
                                                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                                            <li class="page-item <?php if ($i == $pagina_actual)
                                                                echo 'active'; ?>">
                                                                <a class="page-link"
                                                                    href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                            </li>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </nav>
                                            <?php endif; ?>
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