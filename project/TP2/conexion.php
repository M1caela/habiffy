<?php
$SERV = "localhost";
$USER = "root";
$PASS = "";
$BASE = "habit_tracker"; 

$mysqli = new mysqli($SERV, $USER, $PASS, $BASE);

if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    echo "Conexión exitosa a la base de datos.";
}

?>
