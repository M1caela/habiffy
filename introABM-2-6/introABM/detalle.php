<?php

require_once("config.php");
require_once("conexion.php");

//tomo de la url la variabl GET['id']
$id = $_GET['id'];

//armo un select para obtener el registro id=$id
$query = " SELECT * FROM estudiantes
 LEFT JOIN provincias ON provincia_rel=id_provincia
 LEFT JOIN localidades ON localidad_rel=id_localidad
 WHERE id='$id' LIMIT 1 ";

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
<p>Provincia: <?=$este['nombre_provincia']?> (<?=$este['provincia_rel']?>)</p>
<p>Localidad: <?=$este['nombre_localidad']?> (<?=$este['localidad_rel']?>)</p>
<p>Estado: <?=$estado_estudiante[$este['estado']]?></p>
