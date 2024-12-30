<?php
include('../app/config/config.php');

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
        $cargo_pladeco_s = $usuario['cargo_pladeco'];
        $cargo_s = $usuario['cargo'];
        $departamento_s = $usuario['departamento'];
    }

    // Contador para tareas "rojas"
    $tareas_rojas = 0;

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

    // Consulta para obtener tareas asignadas
    $query2 = $pdo->prepare("SELECT t.* FROM tareas t 
                             JOIN asignaciones a ON t.id_asignacion = a.id_asignacion 
                             LEFT JOIN verificacion_tareas v ON t.id_tarea = v.id_tarea 
                             WHERE a.id_usuario = :id_usuario AND (v.verificado IS NULL OR v.verificado = 'NO')");
    $query2->bindParam(':id_usuario', $id_usuario_s);
    $query2->execute();
    $tareas = $query2->fetchAll(PDO::FETCH_ASSOC);

    // Contar tareas "rojas"
    foreach ($tareas as $tarea) {
        $color_semaforo = calcularSemaforo($tarea['fecha_inicio'], $tarea['fecha_fin']);
        if ($color_semaforo == 'rojo') {
            $tareas_rojas++;
        }
    }

    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../layout/head.php'); ?>
        <title>Gestión de Tareas</title>
        <style>
            /* Asegurar que el modal tenga el color de texto blanco */
            .modal-content {
                color: white;
            }

            /* Centrar el modal verticalmente */
            .modal-dialog {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                /* Altura mínima del modal para centrado */
            }

            .modal-title {
                color: white;
            }

            .modal {
                z-index: 1050 !important;
                /* Ajustar el z-index para que esté por encima del menú */
            }

            /* Ajustar el z-index del menú para que esté por debajo del modal */
            #sidenav-main {
                z-index: 10 !important;
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <?php include('../layout/menu.php'); ?>
            <!-- /.navbar -->
            <div class="position-absolute w-100"
                style="z-index: -1; background-color: #ADD9E6; background-size: cover; background-position: center; height: 100vh;">
            </div>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>

                            <!-- Modal de advertencia si hay tareas "rojas" -->
                            <?php if ($tareas_rojas > 0): ?>
                                <div class="modal fade" id="alertModal" tabindex="-1" role="dialog"
                                    aria-labelledby="alertModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content bg-danger ">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="alertModalLabel">¡Advertencia!</h5>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Tienes <?php echo $tareas_rojas; ?> tarea(s) por vencer. ¡Verifícalas ahora!
                                            </div>
                                            <div class="modal-footer"> <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button> <!-- Corrección del botón --> </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    // Mostrar el modal automáticamente
                                    $('#alertModal').modal('show');
                                </script>
                            <?php endif; ?>

                            <div class="card card-primary card-outline" style="width: 900px;">
                                <div class="card-header">
                                    <h3 class="card-title"><span class="fa fa-user"></span> Usuario </h3>
                                </div> <!-- /.card-body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td style="background: #c0c0c0"><b>Nombre:</b></td>
                                                    <td><?php echo $nombre_s . "  " . $apellido_s; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="background: #c0c0c0"><b>Cargo Pladeco:</b></td>
                                                    <td><?php echo $cargo_pladeco_s; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="background: #c0c0c0"><b>Departamento:</b></td>
                                                    <td><?php echo $departamento_s; ?></td>
                                                </tr>
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
            <?php include('../layout/footer.php'); ?>
        </div>
        <?php include('../layout/footer_link.php'); ?>
    </body>

    <script>
        // Mostrar el modal automáticamente
        $(document).ready(function () {
            console.log("Verificando tareas rojas: ", <?php echo $tareas_rojas; ?>); // Verifica que el valor de tareas rojas sea mayor que 0
            if (<?php echo $tareas_rojas; ?> > 0) {
                $('#alertModal').modal('show');
            }
        });
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    </html>
    <?php
} else {
    header("Location: $URL/login");
}
?>