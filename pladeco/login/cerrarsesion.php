<?php
/**

 */

include('../app/config/config.php');


session_start();
if (isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    session_destroy();
    header("Location: " . $URL . "/home/index.php");

}
?>