<?php
include('../app/config/config.php');

$email = $_POST['email'];
$password = $_POST['password'];

session_start();

$query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND password = :password");
$query->bindParam(':email', $email);
$query->bindParam(':password', $password);
$query->execute();
$usuario = $query->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    $_SESSION['u_usuario'] = $email;

    // Verificar el cargo del usuario y redirigir en consecuencia
    if ($usuario['cargo'] === 'ADMINISTRADOR') {
        header("Location: " . $URL . "/web/");
    } elseif ($usuario['cargo'] === 'Usuario') {
        header("Location: " . $URL . "/sistema_lineamientos/");
    } else {
        // Si el cargo no coincide con ninguno de los esperados
        header("Location: " . $URL . "/login/");
    }
} else {
    echo "error";
    header("Location: " . $URL . "/login/");
}
?>