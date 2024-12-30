<?php
include('../app/config/config.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Gestión Praxis</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="../app/templeates/argon-dashboard-master/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href=".../app/templeates/argon-dashboard-master/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Argon Dashboard CSS -->
    <link id="pagestyle" href="../app/templeates/argon-dashboard-master/assets/css/argon-dashboard.css?v=2.1.0"
        rel="stylesheet" />
    <!-- Custom Header CSS -->
    <link href="../app/templeates/iLanding/assets/css/main.css" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">

    <!-- Header -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">Praxis Consultores LTDA.</h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="../home/index.php#hero" class="active">Inicio</a></li>
                    <li><a href="../home/index.php#about">Nosotros</a></li>
                    <li><a href="../home/index.php#proyectos">Proyectos</a></li>
                    <li><a href="../home/index.php#contacto">Contacto</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <a class="btn-getstarted" href="index.php">Inicia sesión</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content mt-0">
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder roboto-text">Inicia Sesión</h4>
                                <p class="mb-0">Ingresa tu email y contraseña</p>
                            </div>
                            <div class="card-body">
                                <form action="controller_login.php" method="post">
                                    <div class="mb-3">
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" name="password" class="form-control form-control-lg"
                                            placeholder="Password" required>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Recordarme</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Ingresar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div id="carouselExample"
                            class="carousel slide position-relative h-100 m-3 border-radius-lg overflow-hidden"
                            data-bs-ride="carousel">
                            <div class="carousel-inner h-100">
                                <div class="carousel-item active h-100">
                                    <img src="../app/templeates/img/foto1.jpg" class="d-block w-100 h-100" alt="Foto 1">
                                </div>
                                <div class="carousel-item h-100">
                                    <img src="../app/templeates/img/foto2.jpg" class="d-block w-100 h-100" alt="Foto 2">
                                </div>
                                <div class="carousel-item h-100">
                                    <img src="../app/templeates/img/foto3.jpg" class="d-block w-100 h-100" alt="Foto 3">
                                </div>
                                <div class="carousel-item h-100">
                                    <img src="../app/templeates/img/foto4.jpg" class="d-block w-100 h-100" alt="Foto 4">
                                </div>
                                <div class="carousel-item h-100">
                                    <img src="../app/templeates/img/foto5.jpg" class="d-block w-100 h-100" alt="Foto 5">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Core JS -->
    <!-- Bootstrap CSS -->

    <!-- Bootstrap JS -->

    <script src="../app/templeates/argon-dashboard-master/assets/js/core/popper.min.js"></script>
    <script src="../app/templeates/argon-dashboard-master/assets/js/core/bootstrap.min.js"></script>
    <script src="../app/templeates/argon-dashboard-master/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../app/templeates/argon-dashboard-master/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../app/templeates/argon-dashboard-master/assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>
<style>
    .carousel-item img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
</style>

</html>