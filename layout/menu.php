<!-- Navbar -->
<?php $current_path = $_SERVER['PHP_SELF'];
$icon_path = '';
if (strpos($current_path, 'web/index.php') !== false || strpos($current_path, 'sistema_lineamientos/index.php') !== false) {
    $icon_path = '../public/logomuni.png';
} else {
    $icon_path = '../../public/logomuni.png';
} ?>
<!-- CSS -->
<link href="../../app/templeates/argon-dashboard-master/assets/css/argon-dashboard.css" rel="stylesheet" />
<link href="../../app/templeates/argon-dashboard-master/assets/css/nucleo-icons.css" rel="stylesheet" />
<!-- CDN de Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<!-- Favicons -->
<link href="../app/templeates/iLanding/assets/img/praxislogo.png" rel="icon">
<link href="../app/templeates/iLanding/assets/img/praxislogo.png" rel="apple-touch-icon">

<!-- Inline Styles -->
<style>
    .sidenav .navbar-nav .nav-link {
        font-size: 1.2rem;
        padding-top: .5rem !important;
        padding-bottom: .5rem !important;
        white-space: nowrap;
    }

    /* Evitar desbordamiento en el contenedor principal */
    .sidenav {
        overflow-x: hidden;
        /* Asegura que no haya desbordamiento horizontal */
    }

    /* Si quieres aumentar también los submenús */
    .sidenav .navbar-nav .nav-treeview .nav-link {
        font-size: 1.0rem;
        white-space: nowrap;
        /* Evita que el texto se desborde */

    }

    /* Opcional: Cambiar el tamaño de la fuente para los íconos */
    .sidenav .navbar-nav .nav-link i {
        font-size: 1.2rem;
        /* Ajusta el tamaño de los íconos */
    }

    /* Estilos para el link activo del menú */
    .nav-link submenu-trigger .navbar-nav>.nav-item .nav-link.active {
        background-color: #f6f9fc;
        box-shadow: none;
    }

    body {
        overflow-x: hidden;
    }

    .sidenav .navbar-nav>.nav-item .nav-link.active {
        color: #344767;
        background-color: hsla(0, 0%, 100%, .13);
    }

    .sidenav .navbar-nav .nav-link.active {
        font-weight: 600;
        box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
        border-radius: .5rem;
    }

    /* Espaciado y márgenes para los links del menú */
    .sidenav.navbar-expand-xs .navbar-nav .nav-link {
        padding-top: .5rem !important;
        padding-bottom: .5rem !important;
        margin: 0 .5rem !important;
    }

    /* Estilo para la flecha indicadora */
    .submenu-trigger .arrow {
        transition: transform 0.3s ease;
        margin-left: auto;
        font-size: 0.8rem;
    }

    .submenu-trigger[aria-expanded="true"] .arrow {
        transform: rotate(90deg);

    }

    /* Estilos para el link activo del menú */
    .nav-link {
        transition: all 0.3s ease;
        font-size: 25px;
        /* Añadimos una transición suave */
    }

    .nav-link.active {
        background-color: #f6f9fc;
        /* Fondo claro para el link activo */
        font-weight: 600;
        /* Texto en negrita */
        color: #344767;
        /* Cambiar color de texto */
        box-shadow: 0 0 5px rgba(136, 152, 170, .15);
        /* Sombra suave */
        border-radius: .5rem;
    }

    /* Efecto de hover para que el link cambie al pasar el ratón */
    .nav-link:hover {
        background-color: #e0e0e0;
        /* Fondo claro cuando el mouse pasa sobre el link */
        color: #344767;
        font-weight: 600;
    }

    /* Estilo general para los submenús */
    .nav-treeview {
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding-left: 1rem;
        /* Ajusta para la indentación */
    }

    /* Al abrir, se hace visible y se animan las transiciones */
    .nav-treeview.show {
        display: block;
        opacity: 1;

    }

    /* Agregar espacio entre los subelementos del submenú si es necesario */
    .nav-treeview .nav-item {
        padding-left: 1rem;
        /* Ajusta según el diseño */
    }

    .navbar-vertical.navbar-expand-xs {
        top: 10px;
        max-width: 16.1rem !important;

    }

    /* Cambia el color del icono al hacer hover o al estar activo */
    .nav-link:hover i,
    .nav-link.active i {
        color: #007bff;
        /* o el color que prefieras */
        transition: color 0.3s ease;
    }

    .sidenav .navbar-brand .font-weight-bold {
        font-size: 1.0rem;
        /* Ajusta el tamaño según lo que necesites */
        font-weight: 600;
        /* Puedes ajustar el peso de la fuente si es necesario */
        overflow-x: hidden;
        white-space: nowrap;
    }
</style>

<!-- JS -->
<script src="../../app/templeates/argon-dashboard-master/assets/js/core/bootstrap.bundle.min.js"></script>
<script src="../../app/templeates/argon-dashboard-master/assets/js/argon-dashboard.js"></script>

<!-- Custom JavaScript para abrir y cerrar submenús y mantener activos los enlaces -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Detecta todos los links de navegación
        let navLinks = document.querySelectorAll(".nav-link");
        let currentPath = window.location.pathname;

        navLinks.forEach(link => {
            // Verificar si el link corresponde a la página actual
            if (currentPath.includes(link.getAttribute("href"))) {
                // Marcar como activo
                link.classList.add("active");

                // Si el link tiene un submenú, abrirlo
                let submenu = link.nextElementSibling;
                if (submenu && submenu.classList.contains("nav-treeview")) {
                    submenu.classList.add("show");
                    link.setAttribute("aria-expanded", "true");
                }
            } else {
                link.classList.remove("active");
            }
        });

        // Para los submenús
        let submenuTriggers = document.querySelectorAll(".submenu-trigger");

        submenuTriggers.forEach(trigger => {
            trigger.addEventListener("click", function (e) {
                e.preventDefault();
                let submenu = this.nextElementSibling;
                submenu.classList.toggle("show");
                this.setAttribute("aria-expanded", submenu.classList.contains("show"));
            });
        });
    });

</script>


<!-- /.navbar -->
<div class="position-absolute w-100"
    style="z-index: -1; background-color: #ADD9E6; background-size: cover; background-position: center; height: 100vh;">
</div>

<!-- Sidebar -->
<aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 ps"
    id="sidenav-main">
    <div class="sidenav-header"> <i
            class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i> <a class="navbar-brand m-0" href="<?php echo $URL; ?>"
            target="_blank"> <img src="<?php echo $icon_path; ?>" width="46px" height="96px"
                class="navbar-brand-img h-100"> <span class="ms-1 font-weight-bold">Gestión | PLADECO</span> </a> </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto ps" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Admin Section -->
            <?php if ($cargo_s == "ADMINISTRADOR") { ?>

                <!-- Administradores -->
                <li class="nav-item">
                    <a href="<?php echo $URL; ?>/web/index.php" class="nav-link">
                        <i class="fas fa-home"></i>
                        </i> <!-- Icono de usuarios -->
                        <span class="nav-link-text ms-1">Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link submenu-trigger" href="#">
                        <i class="fas fa-users text-dark text-sm opacity-10"></i> <!-- Icono de usuarios -->
                        <span class="nav-link-text ms-1">Administradores</span>
                        <span class="arrow">&rsaquo;</span>
                    </a>
                    <ul class="nav nav-treeview collapse">
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/administradores/" class="nav-link">
                                <i class="fas fa-list text-dark"></i> <!-- Icono de lista -->
                                <span class="nav-link-text">Lista de administradores</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/administradores/create.php" class="nav-link">
                                <i class="fas fa-plus-circle text-dark"></i> <!-- Icono de creación -->
                                <span class="nav-link-text">Crear administradores</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Usuarios -->
                <li class="nav-item">
                    <a class="nav-link submenu-trigger" href="#">
                        <i class="fas fa-user-alt text-dark text-sm opacity-10"></i> <!-- Icono de usuario -->
                        <span class="nav-link-text ms-1">Usuarios</span>
                        <span class="arrow">&rsaquo;</span>

                    </a>
                    <ul class="nav nav-treeview collapse">
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/usuarios/" class="nav-link">
                                <i class="fas fa-list text-dark"></i> <!-- Icono de lista -->
                                <span class="nav-link-text">Lista de usuarios</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/usuarios/create.php" class="nav-link">
                                <i class="fas fa-plus-circle text-dark"></i> <!-- Icono de creación -->

                                <span class="nav-link-text">Creación de usuarios</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Tareas -->
                <li class="nav-item">
                    <a class="nav-link submenu-trigger" href="#">
                        <i class="fas fa-tasks text-dark text-sm opacity-10"></i> <!-- Icono de tareas -->
                        <span class="nav-link-text ms-1">Tareas</span>
                        <span class="arrow">&rsaquo;</span>

                    </a>
                    <ul class="nav nav-treeview collapse">
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/iniciativas/index.php" class="nav-link">
                                <i class="fas fa-list text-dark"></i> <!-- Icono de lista -->
                                <span class="nav-link-text">Lista de tareas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/iniciativas/create.php" class="nav-link">
                                <i class="fas fa-plus-circle text-dark"></i> <!-- Icono de creación -->

                                <span class="nav-link-text">Creación de tareas</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Iniciativas -->
                <li class="nav-item">
                    <a class="nav-link submenu-trigger" href="#">
                        <i class="fas fa-project-diagram text-dark text-sm opacity-10"></i> <!-- Icono de iniciativas -->
                        <span class="nav-link-text ms-1">Iniciativas</span>
                        <span class="arrow">&rsaquo;</span>

                    </a>
                    <ul class="nav nav-treeview collapse">
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/lineamientos/index.php" class="nav-link">
                                <i class="fas fa-list text-dark"></i> <!-- Icono de lista -->
                                <span class="nav-link-text">Lista de iniciativas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/lineamientos/crear_iniciativa.php" class="nav-link">
                                <i class="fas fa-plus-circle text-dark"></i> <!-- Icono de creación -->

                                <span class="nav-link-text">Creación de iniciativas</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Lineamientos -->
                <li class="nav-item">
                    <a class="nav-link submenu-trigger" href="#">
                        <i class="fas fa-clipboard-list text-dark text-sm opacity-10"></i> <!-- Icono de lineamientos -->
                        <span class="nav-link-text ms-1">Lineamientos</span>
                        <span class="arrow">&rsaquo;</span>

                    </a>
                    <ul class="nav nav-treeview collapse">
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/alineamientos/index.php" class="nav-link">
                                <i class="fas fa-list text-dark"></i> <!-- Icono de lista -->

                                <span class="nav-link-text">Lista de lineamientos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/alineamientos/crear_lineamiento.php" class="nav-link">
                                <i class="fas fa-plus-circle text-dark"></i> <!-- Icono de creación -->

                                <span class="nav-link-text">Creación de lineamientos</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Verificaciones -->
                <li class="nav-item">
                    <a class="nav-link submenu-trigger" href="#">
                        <i class="fas fa-check-circle text-dark text-sm opacity-10"></i> <!-- Icono de verificación -->
                        <span class="nav-link-text ms-1">Verificaciones</span>
                        <span class="arrow">&rsaquo;</span>

                    </a>
                    <ul class="nav nav-treeview collapse">
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/verificacion/verificacion.php" class="nav-link">
                                <i class="fas fa-check-square text-dark"></i> <!-- Icono de verificar -->

                                <span class="nav-link-text">Verificar tareas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/verificacion/verificados.php" class="nav-link">
                                <i class="fas fa-clipboard-check text-dark"></i> <!-- Icono de verificados -->

                                <span class="nav-link-text">Mis verificados</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link submenu-trigger" href="#">
                        <i class="fas fa-tachometer-alt text-dark text-sm opacity-10"></i> <!-- Icono de dashboard -->
                        <span class="nav-link-text ms-1">Dashboard</span>
                        <span class="arrow">&rsaquo;</span>

                    </a>
                    <ul class="nav nav-treeview collapse">
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/web/dashboard/index.php" class="nav-link">
                                <i class="fas fa-chart-line text-dark"></i> <!-- Icono de reporte -->

                                <span class="nav-link-text">Mis reportes</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $URL; ?>../app/templeates/docs/manualdeadmin.pdf" class="nav-link active" download>
                        <i class="fas fa-book text-dark"></i> <!-- Icono de verificados -->
                        <span class="nav-link-text ms-1">Manual de Admin</span>
                    </a>
                </li>
            <?php } ?>

            <!-- User Section -->
            <?php if ($cargo_s == "Usuario") { ?>
                <li class="nav-item">
                    <a href="<?php echo $URL; ?>/sistema_lineamientos/index.php" class="nav-link">
                        <i class="fas fa-home"></i>
                        </i> <!-- Icono de usuarios -->
                        <span class="nav-link-text ms-1">Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $URL; ?>/sistema_lineamientos/sistema/tareas.php" class="nav-link active">
                        <i class="fas fa-tasks text-dark text-sm opacity-10"></i> <!-- Icono de tareas -->
                        <span class="nav-link-text ms-1">Mis tareas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $URL; ?>/sistema_lineamientos/sistema/mis_verificaciones.php"
                        class="nav-link active">
                        <i class="fas fa-comment-dots text-dark"></i> <!-- Icono de comentarios -->
                        <span class="nav-link-text ms-1">Feedback</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $URL; ?>/sistema_lineamientos/sistema/verificados.php" class="nav-link active">
                        <i class="fas fa-clipboard-check text-dark"></i> <!-- Icono de verificados -->
                        <span class="nav-link-text ms-1">Verificados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $URL; ?>../app/templeates/docs/manualdeusuario.pdf" class="nav-link active"
                        download>
                        <i class="fas fa-book text-dark"></i> <!-- Icono de verificados -->
                        <span class="nav-link-text ms-1">Manual de Usuario</span>
                    </a>
                </li>

            <?php } ?>


            <li class="nav-item">
                <a href="<?php echo $URL; ?>/login/cerrarsesion.php" class="nav-link">
                    <i class="fas fa-sign-out-alt text-dark"></i> <!-- Icono de cerrar sesión -->
                    <span class="nav-link-text ms-1">Cerrar Sesión</span>
                </a>
            </li>

        </ul>
    </div>
</aside>