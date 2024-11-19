<?php
/**
 */

include('../../app/config/config.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$password = $_POST['password'];
$cargo = $_POST['cargo'];
$cargo_pladeco = $_POST['cargo_pladeco'];
$departamento = $_POST['departamento'];

date_default_timezone_set("America/Caracas");
$fechaHora = date("Y-m-d h:i:s");
$estado = "1";


$estado_tarea = 'SIN TAREAS';
$nombre_completo = $nombre . " " . $apellido . " ";

$email_tabla = '';
$query = $pdo->prepare("SELECT * FROM usuarios WHERE email ='$email' AND estado ='1' ");
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios as $usuario) {
    $email_tabla = $usuario['email'];
}
if ((($email) == ($email_tabla))) {
    echo "<h1>Este usuario ya existe. Revise la lista de usuarios</h1>";
} else {
    $sentencia = $pdo->prepare("INSERT INTO usuarios 
      ( nombre, apellido, email, password, cargo, cargo_pladeco, departamento, fyh_creacion, estado) 
VALUES(:nombre,:apellido,:email,:password,:cargo,:cargo_pladeco,:departamento,:fyh_creacion,:estado)");

    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':apellido', $apellido);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':password', $password);
    $sentencia->bindParam(':cargo', $cargo);
    $sentencia->bindParam(':cargo_pladeco', $cargo_pladeco);
    $sentencia->bindParam(':departamento', $departamento);

    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado);

    if ($sentencia->execute()) {

        $sentencia2 = $pdo->prepare("INSERT INTO usuariostareas
      ( email, estado_tarea, cargo, nombre, fyh_creacion, estado) 
VALUES(:email,:estado_tarea,:cargo,:nombre,:fyh_creacion,:estado)");

        $sentencia2->bindParam(':email', $email);
        $sentencia2->bindParam(':estado_tarea', $estado_tarea);
        $sentencia2->bindParam(':cargo', $cargo);
        $sentencia2->bindParam(':nombre', $nombre_completo);

        $sentencia2->bindParam(':fyh_creacion', $fechaHora);
        $sentencia2->bindParam(':estado', $estado);
        if ($sentencia2->execute()) {
            header("Location:" . $URL . "/web/administradores");
            // echo "se registro correctamente a la base de datos";
        } else {
            echo "No se pudo registrar en tareas";
        }
        // header("Location:".$URL."/web/usuarios");
        // echo "se registro correctamente a la base de datos";
    } else {
        echo "No se pudo registrar";
    }
}



