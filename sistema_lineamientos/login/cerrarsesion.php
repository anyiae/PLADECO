<?php
/**

 */

include ('../../app/config/config.php');


session_start();
if(isset($_SESSION['u_usuario'])) {
    $user = $_SESSION['u_usuario'];
    session_destroy();
    header("Location: ".$URL."/sistema_movil/login");
    //echo "session de ".$user; ///////////para comprobar sesion
   // $sentencia = $pdo->prepare("UPDATE `tb_usuarios` SET `online_chat`= 'offline' WHERE `email` = '$user' AND `estado`='1'");
   // if($sentencia->execute()){


    //}
}
?>