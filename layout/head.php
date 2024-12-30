<?php
/**

 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link href="/pladeco/pladeco/app/templeates/iLanding/assets/img/praxislogo.png" rel="icon">
    <link href="/pladeco/pladeco/app/templeates/iLanding/assets/img/praxislogo.png" rel="apple-touch-icon">

    <!-- CSS de Argon Dashboard -->
    <link id="pagestyle"
        href="<?php echo $URL; ?>../app/templeates/argon-dashboard-master/assets/css/argon-dashboard.css"
        rel="stylesheet">
    <link href="<?php echo $URL; ?>../app/templeates/argon-dashboard-master/assets/css/argon-dashboard.min.css"
        rel="stylesheet">
    <link href="<?php echo $URL; ?>../app/templeates/argon-dashboard-master/assets/css/nucleo-icons.css"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Iconos adicionales (opcional) -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Icons -->
    <link href="../../app/templeates/argon-dashboard-master/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../app/templeates/argon-dashboard-master/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Core JS Files de Argon Dashboard -->
    <script src="<?php echo $URL; ?>../app/templeates/argon-dashboard-master/assets/js/argon-dashboard.min.js"></script>
    <script src="<?php echo $URL; ?>../app/templeates/argon-dashboard-master/assets/js/core/popper.min.js"></script>
    <script src="<?php echo $URL; ?>../app/templeates/argon-dashboard-master/assets/js/core/bootstrap.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
</body>

</html>