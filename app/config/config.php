<?php
/**
 */
define('SERVIDOR', 'localhost');
define('USUARIO', 'root');
define('PASSWOD', '');
define('BD', 'pladeco');

$URL = 'http://localhost/pladeco/pladeco';


$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;

try {
    $pdo = new PDO($servidor, USUARIO, PASSWOD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // echo "<script>alert('La conexión a la base de datos fue exitosa.')</script>";
} catch (PDOException $e) {
    echo "<script>alert('Error a la conexión con la base de datos')</script>";
}