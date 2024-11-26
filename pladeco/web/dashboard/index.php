<?php
include('../../app/config/config.php');
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

    // Obtener datos de tareas por color
    $color_counts = ['verde' => 0, 'amarillo' => 0, 'rojo' => 0];
    $total_tareas = 0;

    $query_tareas = $pdo->query("SELECT fecha_inicio, fecha_fin FROM tareas");
    while ($tarea = $query_tareas->fetch(PDO::FETCH_ASSOC)) {
        $color = calcularSemaforo($tarea['fecha_inicio'], $tarea['fecha_fin']);
        $color_counts[$color]++;
        $total_tareas++;
    }
    $colorData = [
        $color_counts['verde'],
        $color_counts['amarillo'],
        $color_counts['rojo']
    ];

    // Obtener datos de tareas verificadas
    $verification_counts = ['verificadas' => 0, 'no_verificadas' => 0, 'sin_revisar' => 0];

    $query_verificaciones = $pdo->query("SELECT verificado FROM verificacion_tareas");
    while ($verificacion = $query_verificaciones->fetch(PDO::FETCH_ASSOC)) {
        if ($verificacion['verificado'] === 'SI') {
            $verification_counts['verificadas']++;
        } elseif ($verificacion['verificado'] === 'NO') {
            $verification_counts['no_verificadas']++;
        } else {
            $verification_counts['sin_revisar']++;
        }
    }
    $verificationData = [
        $verification_counts['verificadas'],
        $verification_counts['no_verificadas'],
        $verification_counts['sin_revisar']
    ];

    // Obtener datos de Costo por Lineamiento
    $lineamientoData = [];
    $query_lineamientos = $pdo->query("
    SELECT l.nombre_lineamiento, SUM(t.costo) AS costo_total
    FROM lineamiento l
    INNER JOIN asignaciones a ON l.id_lineamiento = a.id_lineamiento
    INNER JOIN tareas t ON a.id_asignacion = t.id_asignacion
    GROUP BY l.nombre_lineamiento
");
    while ($lineamiento = $query_lineamientos->fetch(PDO::FETCH_ASSOC)) {
        $lineamientoData['labels'][] = $lineamiento['nombre_lineamiento'];
        $lineamientoData['data'][] = $lineamiento['costo_total'];
    }

    // Obtener datos de Verificación de Tareas por Usuario
    $usuarioVerificationData = [];
    $query_usuarios = $pdo->query("
        SELECT u.nombre, 
            SUM(CASE WHEN vt.verificado = 'SI' THEN 1 ELSE 0 END) AS verificadas,
            SUM(CASE WHEN vt.verificado = 'NO' THEN 1 ELSE 0 END) AS no_verificadas,
            SUM(CASE WHEN vt.verificado IS NULL THEN 1 ELSE 0 END) AS sin_revisar
        FROM usuarios u
        LEFT JOIN verificacion_tareas vt ON u.id = vt.id_usuario
        WHERE u.cargo = 'Usuario'
        GROUP BY u.nombre
    ");
    while ($usuario = $query_usuarios->fetch(PDO::FETCH_ASSOC)) {
        $usuarioVerificationData['labels'][] = $usuario['nombre'];
        $usuarioVerificationData['verificadas'][] = $usuario['verificadas'];
        $usuarioVerificationData['no_verificadas'][] = $usuario['no_verificadas'];
        $usuarioVerificationData['sin_revisar'][] = $usuario['sin_revisar'];
    }
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <?php include('../../layout/head.php'); ?>
        <title>Dashboard | PLADECO</title>
    </head>

    <body class="g-sidenav-show bg-gray-100">
        <div class="wrapper" style="margin-left: 0px;">
            <?php include('../../layout/menu.php'); ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <div class="container">
                            <br>
                            <div class="row">
                                <!-- Gráficos existentes -->
                                <div class="col-md-6" style="margin-bottom: 20px;">

                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Reporte de Estado de Tarea</h3>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="colorChart"></canvas>
                                            <a href="export_tareas_color.php" class="btn btn-primary mt-2">Descargar en
                                                Excel</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Reporte de Tareas Verificadas</h3>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="verificationChart"></canvas>
                                            <a href="export_tareas_verificadas.php" class="btn btn-primary mt-2">Descargar
                                                en Excel</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nuevo: Costo por Lineamiento -->
                                <div class="col-md-6">
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Costo por Lineamiento</h3>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="costChart"></canvas>
                                            <a href="export_costo_lineamiento.php" class="btn btn-primary mt-2">Descargar en
                                                Excel</a>

                                        </div>
                                    </div>
                                </div>

                                <!-- Nuevo: Verificación por Usuario -->
                                <div class="col-md-6" style="margin-top: -80px;">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Porcentaje de Verificación por Usuario</h3>
                                        </div>
                                        <div class="card-body">
                                            <select id="userSelect" class="form-control mb-3">
                                                <option value="">Seleccionar Usuario</option>
                                                <?php foreach ($usuarioVerificationData['labels'] as $usuario) { ?>
                                                    <option value="<?= $usuario ?>"><?= $usuario ?></option>
                                                <?php } ?>
                                            </select>
                                            <canvas id="userVerificationChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include('../../layout/footer.php'); ?>
        <?php include('../../layout/footer_link.php'); ?>

        <!-- Script para los gráficos -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Datos para los gráficos
            const colorData = <?= json_encode($colorData); ?>;
            const verificationData = <?= json_encode($verificationData); ?>;
            const lineamientoData = <?= json_encode($lineamientoData); ?>;
            const usuarioVerificationData = <?= json_encode($usuarioVerificationData); ?>;

            // Colores personalizados para el gráfico de costos
            const costColors = ['#0098D4', '#BA192A', '#A1C21E', '#F6B421'];

            // Gráfico de Estado de Tarea
            new Chart(document.getElementById('colorChart'), {
                type: 'pie',
                data: {
                    labels: ['Tiempo óptimo', 'A medio realizar', 'Atrasados'],
                    datasets: [{
                        data: colorData,
                        backgroundColor: ['#28a745', '#ffcc00', '#dc3545']
                    }]
                }
            });
            // Gráfico de Verificación de Tareas
            new Chart(document.getElementById('verificationChart'), {
                type: 'bar',
                data: {
                    labels: ['Verificadas', 'No Verificadas', 'Sin Revisar'],
                    datasets: [{
                        data: verificationData,
                        backgroundColor: ['#28a745', '#dc3545', '#0098D4']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Asegúrate de que el gráfico ocupe el 100% del espacio disponible
                    plugins: {
                        legend: {
                            display: true, // Muestra la leyenda
                            position: 'top', // Posición de la leyenda
                            labels: {
                                generateLabels: function (chart) {
                                    const data = chart.data.datasets[0].data;
                                    return chart.data.labels.map((label, index) => {
                                        return {
                                            text: `${label}: ${data[index]}`,
                                            fillStyle: chart.data.datasets[0].backgroundColor[index],
                                            hidden: false,
                                            index: index
                                        };
                                    });
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true // Empieza desde cero en el eje X
                        }
                    },
                    // Asegurarse de que la resolución sea correcta solo para este gráfico
                    onResize: function (chart) {
                        if (chart.canvas.id === "verificationChart") { // Verifica que sea el gráfico correcto
                            var canvas = chart.canvas;
                            var ctx = canvas.getContext("2d");
                            var ratio = window.devicePixelRatio || 1;
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            ctx.scale(ratio, ratio);
                        }
                    }
                }
            });




            // Gráfico de Costo por Lineamiento
            new Chart(document.getElementById('costChart'), {
                type: 'bar',
                data: {
                    labels: lineamientoData.labels,
                    datasets: [{
                        label: 'Costo Total',
                        data: lineamientoData.data,
                        backgroundColor: lineamientoData.labels.map((_, index) => costColors[index % costColors.length])
                    }]
                }
            });

            // Función para actualizar el gráfico de Verificación por Usuario
            let userVerificationChart = new Chart(document.getElementById('userVerificationChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Verificadas', 'No Verificadas', 'Sin Revisar'],
                    datasets: [{
                        data: [
                            usuarioVerificationData.verificadas[0] || 0,
                            usuarioVerificationData.no_verificadas[0] || 0,
                            usuarioVerificationData.sin_revisar[0] || 0
                        ],
                        backgroundColor: ['#28a745', '#dc3545', '#0098D4']
                    }]
                }
            });

            // Filtrar gráfico de Verificación por Usuario al seleccionar usuario
            document.getElementById('userSelect').addEventListener('change', (e) => {
                const selectedUser = e.target.value;

                // Si se selecciona un usuario, filtramos los datos para ese usuario
                const filteredData = selectedUser ? {
                    labels: [selectedUser],
                    verificadas: [usuarioVerificationData.verificadas[usuarioVerificationData.labels.indexOf(selectedUser)]],
                    no_verificadas: [usuarioVerificationData.no_verificadas[usuarioVerificationData.labels.indexOf(selectedUser)]],
                    sin_revisar: [usuarioVerificationData.sin_revisar[usuarioVerificationData.labels.indexOf(selectedUser)]]
                } : usuarioVerificationData;

                // Destruimos el gráfico anterior y creamos uno nuevo
                userVerificationChart.destroy();
                userVerificationChart = new Chart(document.getElementById('userVerificationChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Verificadas', 'No Verificadas', 'Sin Revisar'],
                        datasets: [{
                            data: [
                                filteredData.verificadas[0] || 0,
                                filteredData.no_verificadas[0] || 0,
                                filteredData.sin_revisar[0] || 0
                            ],
                            backgroundColor: ['#28a745', '#dc3545', '#0098D4']
                        }]
                    }
                });
            });

            // Inicializar el gráfico con todos los usuarios
            document.getElementById('userSelect').dispatchEvent(new Event('change'));
        </script>
        <style>
            #verificationChart {
                width: 100% !important;
                /* Asegura que el gráfico ocupe todo el ancho del contenedor */
                height: 490px !important;
                /* Ajusta la altura según lo que necesites */
            }
        </style>
    </body>

    </html>



<?php } else {
    header('Location: ' . $URL . '/login');
} ?>