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
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Asignar Tareas a un Usuario</title>
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
                                    <h3 class="card-title"><span class="fa fa-tasks"></span> Asignar Usuario e Iniciativas
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Selección de Usuario -->
                                    <div class="form-group">
                                        <label for="usuario">Seleccionar Usuario</label>
                                        <select id="usuario" class="form-control">
                                            <?php
                                            $query_usuarios = $pdo->prepare("SELECT * FROM usuarios WHERE estado ='2'");
                                            $query_usuarios->execute();
                                            $usuarios = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($usuarios as $usuario) {
                                                echo '<option value="' . $usuario['id'] . '">' . $usuario['nombre'] . ' ' . $usuario['apellido'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Selección de Lineamiento -->
                                    <div class="form-group">
                                        <label for="lineamiento">Seleccionar Lineamiento</label>
                                        <select id="lineamiento" class="form-control">
                                            <?php
                                            $query_lineamientos = $pdo->prepare("SELECT * FROM lineamiento");
                                            $query_lineamientos->execute();
                                            $lineamientos = $query_lineamientos->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($lineamientos as $lineamiento) {
                                                echo '<option value="' . $lineamiento['id_lineamiento'] . '">' . $lineamiento['nombre_lineamiento'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Selección de Iniciativa -->
                                    <div class="form-group">
                                        <label for="iniciativa">Seleccionar Iniciativa</label>
                                        <select id="iniciativa" class="form-control">
                                            <!-- Las iniciativas se cargarán mediante AJAX -->
                                        </select>
                                    </div>

                                    <!-- Botón para agregar tareas -->
                                    <button type="button" class="btn btn-success" id="btn_agregar_tarea">Agregar
                                        Tarea</button>

                                    <!-- Contenedor para tareas -->
                                    <div id="tareas_container"></div>

                                    <br>

                                    <!-- Botón para guardar asignación -->
                                    <button type="button" class="btn btn-primary" id="btn_guardar">Guardar
                                        Asignación</button>


                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                // Cargar las iniciativas al seleccionar un lineamiento
                $('#lineamiento').change(function () {
                    var lineamiento_id = $(this).val();
                    console.log("ID de lineamiento seleccionado:", lineamiento_id);

                    if (lineamiento_id) {
                        $.ajax({
                            url: 'cargar_iniciativas.php',
                            type: 'POST',
                            data: { lineamiento_id: lineamiento_id },
                            success: function (response) {
                                console.log("Respuesta del servidor:", response);
                                $('#iniciativa').html(response);
                            },
                            error: function (xhr, status, error) {
                                console.error("Error en la carga de iniciativas:", status, error);
                                $('#iniciativa').html('<option value="">Error al cargar iniciativas</option>');
                            }
                        });
                    } else {
                        $('#iniciativa').html('<option value="">Seleccione una iniciativa</option>');
                    }
                });

                // Agregar tarea
                $('#btn_agregar_tarea, #btn_agregar_nueva_tarea').click(function () {
                    $('#tareas_container').append(`
                                    <div class="form-group tarea-item">
                                        <label>Nombre de la tarea</label>
                                        <input type="text" class="form-control" name="nombre_tarea[]" placeholder="Nombre de la tarea" required>

                                        <label>Descripción de la tarea</label>
                                        <input type="text" class="form-control" name="descripcion_tarea[]" placeholder="Descripción de la tarea" required>

                                        <label>Fecha de inicio</label>
                                        <input type="datetime-local" name="fecha_inicio[]" class="form-control" required>

                                        <label>Fecha de fin</label>
                                        <input type="datetime-local" name="fecha_fin[]" class="form-control" required>

                                        <label>Estado de la tarea</label>
                                        <select class="form-control" name="estado_tarea[]" required>
                                            <option value="pendiente">Pendiente</option>
                                            <option value="en_progreso">En progreso</option>
                                            <option value="completada">Completada</option>
                                        </select>

                                        <label>Costo de la tarea</label>
                                        <input type="number" class="form-control" name="costo_tarea[]" placeholder="Costo de la tarea" required>

                                        <hr> <!-- Separador para las tareas -->
                                        <button type="button" class="btn btn-danger btn_eliminar_tarea">Eliminar Tarea</button>
                                    </div>
                                `);
                });

                // Evento para eliminar tarea
                $('#tareas_container').on('click', '.btn_eliminar_tarea', function () {
                    $(this).closest('.tarea-item').remove();
                });

                // Guardar asignación
                $('#btn_guardar').click(function () {
                    var usuario_id = $('#usuario').val();
                    var lineamiento_id = $('#lineamiento').val();
                    var iniciativa_id = $('#iniciativa').val();
                    var tareas = [];
                    $('#tareas_container .form-group').each(function () {
                        var tarea = {
                            nombre_tarea: $(this).find('input[name="nombre_tarea[]"]').val(),
                            descripcion_tarea: $(this).find('input[name="descripcion_tarea[]"]').val(),
                            fecha_inicio: $(this).find('input[name="fecha_inicio[]"]').val(),
                            fecha_fin: $(this).find('input[name="fecha_fin[]"]').val(),
                            estado_tarea: $(this).find('select[name="estado_tarea[]"]').val(),
                            costo_tarea: $(this).find('input[name="costo_tarea[]"]').val()
                        };
                        tareas.push(tarea);
                    });

                    $.ajax({
                        url: 'guardar_asignacion.php',
                        type: 'POST',
                        data: { usuario_id: usuario_id, lineamiento_id: lineamiento_id, iniciativa_id: iniciativa_id, tareas: tareas },
                        success: function (response) {
                            console.log(response);
                            alert('Asignación guardada con éxito');
                            location.reload(); // Reinicia la página
                        }
                    });
                });
            });
        </script>

    </body>

    </html>

    <?php
} else {
    header('Location: ../../index.php');
}
?>