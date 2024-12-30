<?php
include('../../app/config/config.php');

if (isset($_POST['lineamiento_id'])) {
    $id_lineamiento = $_POST['lineamiento_id'];
    error_log("ID de lineamiento recibido: " . $id_lineamiento); // Para depuración

    $query = $pdo->prepare("SELECT * FROM iniciativas WHERE id_lineamiento = :lineamiento_id");
    $query->execute(['lineamiento_id' => $id_lineamiento]);
    $iniciativas = $query->fetchAll(PDO::FETCH_ASSOC);

    error_log("Número de iniciativas encontradas: " . count($iniciativas)); // Para depuración

    if ($iniciativas) {
        foreach ($iniciativas as $iniciativa) {
            echo '<option value="' . $iniciativa['id_iniciativa'] . '">' . $iniciativa['nombre_iniciativa'] . '</option>';
        }
    } else {
        echo '<option value="">No hay iniciativas disponibles</option>';
    }
} else {
    echo '<option value="">No hay iniciativas disponibles</option>';
}
?>