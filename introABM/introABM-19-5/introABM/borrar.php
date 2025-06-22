<?php
require_once("conexion.php");

//tomo de la url la variabl GET['id']
$id = $_GET['id'];

//armo un delete para borrar id=$id
$query = " DELETE FROM estudiantes WHERE id='$id' LIMIT 1 ";

//ejecuto la consulta al objeto conexion:
$result = $mysqli->query($query);

?>
<a href="./">[VOLVER]</a>
<h1>Se borró el registro</h1>

