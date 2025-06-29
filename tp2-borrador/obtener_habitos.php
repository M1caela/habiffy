<!--  esto seria para el calendario, pero no esta funcionando -->

<?php
// require_once("conexion.php");

// // Obtener la fecha desde la solicitud
// $fecha = $_GET['fecha'] ?? null;

// if ($fecha) {
//     // Consultar los hábitos completados en la fecha especificada
//     $stmt = $mysqli->prepare("SELECT h.habito FROM habitos h JOIN habito_check hc ON h.id = hc.habito_id WHERE hc.fecha = ? AND hc.completado = 1");
//     $stmt->bind_param("s", $fecha);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     $habitos = [];
//     while ($row = $result->fetch_assoc()) {
//         $habitos[] = $row['habito'];
//     }

//     // Devolver los datos en formato JSON
//     header('Content-Type: application/json');
//     echo json_encode($habitos);
// } else {
//     // Si no se proporciona una fecha, devolver un error
//     http_response_code(400);
//     echo json_encode(['error' => 'Fecha no proporcionada.']);
// }
?>