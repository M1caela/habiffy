<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $fecha = date('Y-m-d'); // fecha de hoy

    require('conexion.php'); // tu archivo de conexión

    $stmt = $mysqli->prepare("INSERT INTO historial_habitos (id_habito, fecha) VALUES (?, ?)");
    $stmt->bind_param("is", $id, $fecha);
    $stmt->execute();
    $stmt->close();
}
?>
