<?php

//me conecto a la base
require_once("config.php"); //tiene algunas configuraciones globales
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

    if ($ok != false) {

        //verificamos si tenemos id_provincia y id_localidad
        if (isset($_POST['provincia'])) {
            $id_provincia = $_POST['provincia'];
        } else {
            $id_provincia = null;
        }

        //lo mismo que la provincia, pero de forma abreviada:
            $id_localidad = isset($_POST['localidad'])  ? $_POST['localidad'] : null;
            
            
            
        //el estado::
        $estado = isset($_POST['estado'])  ? $_POST['estado'] : null;
        
        
        //esta todo bien, armemos un insert:
        $query = " INSERT INTO estudiantes 
          SET
            apellido = '$apellido',
            nombre = '$nombre',
            fec_nac = '$fec_nac',
            provincia_rel = $id_provincia,
            localidad_rel = $id_localidad,
            estado = $estado
            ";

        echo "<pre>$query</pre>";


        $result = $mysqli->query($query);

        if ($result) {
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
    <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>
    <br>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre">
    <br>
    <input type="date" name="fec_nac" id="fec_nac">

    <br>
    PROVINCIA:<br>
    <select name="provincia" id="provincia">
        <option value="">--Seleccioná una provincia--</option>
        <?php
        // Consulta a la tabla
        $resultado = $mysqli->query("SELECT id_provincia, nombre_provincia FROM provincias ORDER BY nombre_provincia");

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id_provincia'] . '">' . $fila['nombre_provincia'] . '</option>' . "\n";
        }

        ?>
    </select>
    <br>
    <select name="localidad" id="localidad">
        <option value="">Seleccioná una localidad</option>
    </select>

    <br>
    <br>
    ESTADO:<br>
    <select name="estado" id="estado">
        <option value="">--Seleccioná una estado--</option>
        <?php
        // Consulta a la tabla
         foreach ($estado_estudiante as $key => $estado): ?>
            <option value="<?= $key ?>"><?= htmlspecialchars($estado) ?></option>
        <?php endforeach; ?>

        
    </select>
    <br>
    
    
    <br>
    <input type="submit" value="INGRESAR">
</form>




<script>
    document.getElementById('provincia').addEventListener('change', function() {

        console.log("voy a buscar las localidades");

        const provinciaId = this.value;
        const localidadSelect = document.getElementById('localidad');

        // Limpiar localidades actuales
        localidadSelect.innerHTML = '<option value="">Cargando...</option>';

        if (provinciaId === '') {
            localidadSelect.innerHTML = '<option value="">Seleccioná una localidad</option>';
            return;
        }

        // Petición AJAX
        fetch('control.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'accion=get_localidades&id_provincia=' + encodeURIComponent(provinciaId)
            })
            .then(response => response.json())
            .then(data => {
                localidadSelect.innerHTML = '<option value="">Seleccioná una localidad</option>';
                data.forEach(localidad => {
                    const option = document.createElement('option');
                    option.value = localidad.id_localidad;
                    option.textContent = localidad.nombre_localidad;
                    localidadSelect.appendChild(option);
                });
            })
            .catch(error => {
                localidadSelect.innerHTML = '<option value="">Error al cargar</option>';
                console.error('Error:', error);
            });
    });
</script>