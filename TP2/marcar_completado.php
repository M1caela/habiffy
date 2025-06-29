<!-- controlador de checkbox para 'completar' habit, se guarda el hábito marcado en una nueva tabla. 
 esto se reinicia diariamente de forma automática -->

<?php
require_once("conexion.php");

date_default_timezone_set('America/Argentina/Buenos_Aires');


$id = $_POST['id'];
$completado = $_POST['completado'];
$fecha = date('Y-m-d');

// Verificar si ya existe registro
$query = $mysqli->prepare("SELECT id FROM habito_check WHERE habito_id = ? AND fecha = ?");
$query->bind_param("is", $id, $fecha);
$query->execute();
$query->store_result();

if ($query->num_rows > 0) {
    $update = $mysqli->prepare("UPDATE habito_check SET completado = ? WHERE habito_id = ? AND fecha = ?");
    $update->bind_param("iis", $completado, $id, $fecha);
    $update->execute();
} else {
    $insert = $mysqli->prepare("INSERT INTO habito_check (habito_id, fecha, completado) VALUES (?, ?, ?)");
    $insert->bind_param("isi", $id, $fecha, $completado);
    $insert->execute();
}
?>
