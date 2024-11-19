<?php
include('../../app/config/config.php');
$user_id = $_GET['user_id'] ?? '';
$query = "SELECT verificado FROM verificacion_tareas";
if ($user_id) {
    $query .= " WHERE id_usuario = ?";
}
$stmt = $pdo->prepare($query);
$stmt->execute($user_id ? [$user_id] : []);
$data = ['verificadas' => 0, 'no_verificadas' => 0, 'sin_revisar' => 0];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['verificado'] === 'SI')
        $data['verificadas']++;
    elseif ($row['verificado'] === 'NO')
        $data['no_verificadas']++;
    else
        $data['sin_revisar']++;
}
echo json_encode($data);
