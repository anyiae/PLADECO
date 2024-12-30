<?php
/**

 */

include('../../app/config/config.php');

$email = $_POST['email'];
$pass = $_POST['password'];


$email_tabla = "";
$password_tabla = "";

$query = $pdo->prepare("SELECT * FROM usuarios WHERE email ='$email' AND password ='$pass'");
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios as $usuario) {
    $email_tabla = $usuario['email'];
    $password_tabla = $usuario['password'];
}
if ((($email) == ($email_tabla)) && (($pass) == ($password_tabla))) {
    echo "success";
    session_start();
    $_SESSION['u_usuario'] = $email;
    header("Location: " . $URL . "/sistema_lineamientos/app/pedidos.php");
} else {
    echo "error";
}