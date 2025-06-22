<?php

require_once("conexion.php");


if ($_POST['accion'] === 'get_localidades' && isset($_POST['id_provincia'])) {
    $id_provincia = intval($_POST['id_provincia']);


    $query  = "SELECT id_localidad, nombre_localidad FROM localidades WHERE id_provincia_padre_rel = $id_provincia ORDER BY nombre_localidad";
    $resultado = $mysqli->query($query);

    $localidades = [];
    while ($fila = $resultado->fetch_assoc()) {
        $localidades[] = $fila;
    }

    header('Content-Type: application/json');
    echo json_encode($localidades);
 
}


