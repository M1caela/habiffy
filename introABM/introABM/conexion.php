<?php

//conexion de php al motor de base de datos:

$SERV = "localhost";
$USER = "root";
$PASS = "";
$BASE = "ejemplo_clase_zoom"; 

$mysqli = new mysqli($SERV, $USER, $PASS, $BASE);

if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//echo $mysqli->host_info . "\n";
