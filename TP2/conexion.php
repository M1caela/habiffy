<?php
$SERV = "localhost";
$USER = "root";
$PASS = "";
$BASE = "habit_tracker"; 

$mysqli = new mysqli($SERV, $USER, $PASS, $BASE);

// depuración de errores // desarrollo
if ($mysqli->connect_errno) {
    error_log("Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
} else {
    echo "Conexión exitosa a la base de datos.";
}
?>
