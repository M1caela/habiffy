<?php
require_once("conexion.php");

if (!isset($_GET['id'])) {
    echo "No se especificó el hábito a eliminar.";
    exit;
}

$id = $_GET['id'];

// Consulta preparada para seguridad
$stmt = $mysqli->prepare("DELETE FROM habitos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Se eliminó el hábito. Si te arrepentis, podés crearlo nuevamente.'); window.location.href='index.php';</script>";
} else {
    echo "Error al eliminar el hábito: " . $stmt->error;
}

$stmt->close();
?>
