<?php
require_once("conexion.php");

//tomo de la url la variabl GET['id']
$id = $_GET['id'];

//armo un select para obtener el registro id=$id
$query = " SELECT * FROM estudiantes WHERE id='$id' LIMIT 1 ";

//ejecuto la consulta al objeto conexion:
$result = $mysqli->query($query);

//"recorremos" el primer y unico resultado:
$este = $result->fetch_array();

//calculamos la edad por diferencias de fechas:
 $edad = floor((time()-strtotime($este['fec_nac']))/60/60/24/365);
?>
<a href="./">[VOLVER]</a>
<h1><?=$este['apellido']?>, <?=$este['nombre']?></h1>
<h3>Fecha de Nacimiento: <?=$este['fec_nac']?></h3>
<p>Edad: <?=$edad?> años.</p>
