<?php

//me conecto a la base
require_once("conexion.php");

$ok = true;
$msj = "";

if (isset($_POST['apellido'])) {
    //quiere decir que está abriendo esta página desde enviar el formulario
    /*
    echo "estoy recibiendo algún dato enviado desde el formulario...";
    echo "<br>";
    echo "Apellido: ".$_POST['apellido'];
    echo "<br>";
    */

    //valido todos los datos que necesito:
   
    if (isset($_POST['apellido']) && $_POST['apellido'] != "") {
        $apellido = $_POST['apellido'];
    } else {
        $ok = false;
        $msj .= "Falta ingresar el apellido.<br>";
    }

    if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
        $nombre = $_POST['nombre'];
    } else {
        $ok = false;
        $msj .= "Falta ingresar el nombre.<br>";
    }


    if (isset($_POST['fec_nac']) && $_POST['fec_nac'] != "") {
        $fec_nac = $_POST['fec_nac'];
    } else {
        $ok = false;
        $msj .= "Falta ingresar la fecha de nacimiento.<br>";
    }

    if ( $ok!= false ) {
        //esta todo bien, armemos un insert:
        $query = " INSERT INTO estudiantes 
          SET
            apellido = '$apellido',
            nombre = '$nombre',
            fec_nac = '$fec_nac'
            ";

        $result = $mysqli->query($query);

        if ( $result ) {
            $msj = "Se insertó el registro.";
        } else {
            $msj = "Hubo un error al intentar ingresar el registro.";
        }
    }



}

?>

<a href="./">VOLVER AL LISTADO</a>
<h2>Ingresar nuevo registro</h2>
<div class="alerta"><?= $msj ?></div>
<form action="" method="post">
    <input type="text" name="apellido" id="apellido" placeholder="Apellido" required="required">
    <br>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre">
    <br>
    <input type="date" name="fec_nac" id="fec_nac">

    <br>
    <br>
    <input type="submit" value="INGRESAR">
</form>