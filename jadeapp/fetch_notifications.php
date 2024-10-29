<?php
include 'connect_app2.php';

// código da notificação SININHO
$sql = "SELECT COUNT(*) AS new_notifications FROM arcondicionadoapp WHERE tipostatus IN ('Pendente', 'Corretiva', 'Preventiva')";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();

$new_notifications = $result['new_notifications'];

echo json_encode(['new_notifications' => $new_notifications]);
?>
