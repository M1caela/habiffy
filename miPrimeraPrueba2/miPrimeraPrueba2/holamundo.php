<?php
 date_default_timezone_set('America/Buenos_Aires'); 
// esto sirve para establecer el huso horario y que el objeto date funcione bine
?> 

<?php
//variables en php:
//comienzan $:
$estado = "En proceso...";
$cantidad = 5;
$activo = true;
$nombre = "David";
$apellido = "Bedoian";


//estructura condicional:
if ($activo) {
    $color = "#00ff00";
} else {
    $color = "#ff0000";
}

?>

<?php
//ejemplo de concatenacion:
echo "<p>Hola, " . $nombre . " " . $apellido . ".</p>" 
?>

<?php
echo "estoy imprimiendo esto con php en el código fuente...";
?>
<p>Esto ya es html</p>
<p>La fecha: <?php echo date('d-m-Y'); ?></p>
<p>La hora: <?php echo date('h:i:s'); ?></p>
<p>Estado: <?php echo $estado; ?></p>


<?php
//sintaxis del for:
for ($i = 0; $i < $cantidad; $i++) {
 //cuerpo del for para las repeticiones:
   echo "<p style='background-color:$color'>$i</p>\n";

}
    //otra muy recurrente es while()
?>

<?php
//ejemplo de estructura condicional con cuerpo de html:
if ( rand(0, 100)>50 ) { ?>
    <h3>Tuviste suerte!</h3>
    <p>Cuando quieras pasá a buscar tu premio...</p>
<?php } else { ?>
    <h3>Será la próxima...</h3>
    <p>Seguí participando... no está muerto quien pelea!</p>
<?php } ?>


<?php
echo "esta variable la recibí en la url: ". $_GET['apodo'];
//el otro metodo es $_POST

?>
