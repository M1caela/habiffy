<?php
date_default_timezone_set (timezoneId: 'America/Buenos_Aires'); 




echo "<pre>";
print_r( $_POST );
echo "</pre>";

//ejemplo de un array:
$nombres = ["Martín", "Julián", "Sofi", "Maru", "Sol", "Guille"];
$dias = [ "Domingo", "Lunes", "Martes", "Miércoles" , "Jueves" , "Viernes", "Sábado" ];

//evaluamos usuario y clave:
if ( isset( $_POST['usu']) ) {
    $usu = $_POST['usu'];
} else {
    $usu = "";
}
if ( isset( $_POST['pass']) ) {
    $pass = $_POST['pass'];
} else {
    $pass = "";
}
//compruebo usario y clave:
if ( $usu=="admin" && $pass=="1234"){
    $acceso = true;
} else {
    $acceso = false;
}

//tomo la variable miColor:
$miColor = $_POST['miColor'];


echo "<body style='background-color:$miColor'> ";




//aca podemos mostrar el resultado
//(en caso de login podriamos redireccionar con header)
if ( $acceso ) {
    echo "<div>Acceso permitido</div>\n";
} else {
    echo "<div>Acceso restringido</div>\n";
}


//ahora con la variable cantidad:
$cantidad = $_POST['cantidad'];

echo "<div class='numeros'>\n";
for ( $i=0 ; $i<$cantidad ; $i++ ) {
 echo "<div>";
 echo $i+1;
 echo " --> ";
 echo $nombres[rand(0,5)];
 echo "</div>\n";
 
}
echo "</div>\n";
echo "<br>";

echo "Hoy es ". $dias[ date('w') ];

echo "<br>";
echo "<a href='formulario.php'>volver</a>";
echo "</body>";
?>
<br>
//Esto está afuera de php....

