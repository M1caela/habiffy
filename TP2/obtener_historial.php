<?php
require 'conexion.php'; // o el archivo donde tengas tu conexión

if (!isset($_GET['fecha'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Fecha no proporcionada']);
    exit;
}

$fecha = $_GET['fecha'];
$stmt = $mysqli->prepare("
    SELECT habitos.habito
    FROM historial_habitos
    JOIN habitos ON historial_habitos.id_habito = habitos.id
    WHERE historial_habitos.fecha = ?
");
$stmt->bind_param("s", $fecha);
$stmt->execute();

$resultado = $stmt->get_result();
$habitos = [];

while ($row = $resultado->fetch_assoc()) {
    $habitos[] = $row['habito'];
}

echo json_encode($habitos);
