<?php
include('../../app/config/config.php');

if (isset($_GET['id'])) {
    $id_lineamiento = $_GET['id'];

    $query = $pdo->prepare("DELETE FROM lineamiento WHERE id_lineamiento = ?");
    $result = $query->execute([$id_lineamiento]);

    if ($result) {
        header("Location: index.php"); // Ajusta la ruta según sea necesario
    } else {
        echo "Error al eliminar el lineamiento.";
    }
} else {
    echo "ID no proporcionado.";
}
?>