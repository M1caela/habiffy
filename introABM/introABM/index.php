<?php
//este archivo que incluyo tiene la conexion a la base:
require_once("conexion.php");
//el resultado de la conexion se guarda en una variable $mysqli


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Mis registros</h1>

    <?php

    

    //ahora, con la conexion, consulto los registros:
    $query = "SELECT * FROM estudiantes"; //trae todos sin orden
    //$query = "SELECT * FROM estudiantes ORDER BY apellido ASC , nombre ASC  ";
    //$query = "SELECT * FROM estudiantes WHERE apellido LIKE 's%' "; //apellidos que empiecen con s
    //$query = "SELECT * FROM estudiantes WHERE apellido LIKE '%ian' "; //apellidos que terminan con ian
    //$query = "SELECT * FROM estudiantes LIMIT 2";
    //$query = "SELECT * FROM estudiantes ORDER BY fec_nac DESC LIMIT 1";
    //$query = "SELECT * FROM estudiantes WHERE id=3 ";

    
    
    //ejecutar esa instruccion y obtener los resultados:
    $result = $mysqli->query($query);

    //si no hay registros: muestro que no hay:
    if ( $result->num_rows<=0 ) {
      echo "<p>No hay registros para mostrar...</p>";
    } else {
    ?>
    <table border="1">
        <thead>

            <tr>
                <th>ID</th>
                <th>Fec-Nac</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
        </thead>
        <tbody>

        <?php
         while( $estafila = $result->fetch_array() ) {
            //print_r($estafila); 
        ?>
           <tr>
                <td><?php echo $estafila[0];?></td>
                <td><?php echo date('d/m/Y', strtotime($estafila['fec_nac']));?></td>
                <td><?php echo $estafila['nombre'];?></td>
                <td><?=$estafila['apellido']?></td>
            </tr>
        <?php  } ?>

        </tbody>



    </table>
    <?php  } //end ELSE ?>

</body>

</html>