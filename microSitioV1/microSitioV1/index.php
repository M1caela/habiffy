<?php

/*
instrucciones de php que cargan contenido externo:
(otros php por ejemplo)

include()
include_once() --> no lo carga si ya lo cargó antes
require() --> similar a include, pero si no encuentra el archivo, da error fatal.
require_once() --> lo mismo, pero no carga el archivo si ya intento cargarlo antes.
*/


// Este script carga distintas páginas (vistas) según lo que el usuario elija desde un menú o desde un link. Se usa la variable $_GET['p'] para decidir qué contenido mostrar

if (!isset($_GET['p']) || $_GET['p']=='inicio'  ) {
    $vista = "inicio.php";  // Si no se recibió nada en la URL ($_GET['p'] no está definido) o si el valor de p es 'inicio', se asigna el archivo inicio.php a la variable $vista.
}
else if ( $_GET['p'] == 'ingresar'){
    $vista = "ingresar.php"; //  Si el valor de p es "ingresar" o "acerca", se asigna el archivo correspondiente a $vista.
}
else if ( $_GET['p'] == 'acerca'){
    $vista = "acerca.php"; 
}
else {
    $vista = "404.php";  //  Si se escribió algo que no está previsto, se muestra una página de error 
}


//incluimos las partes del documento:
include("views/_encabezado.php"); // Se carga la parte superior del sitio (como el logo, menú, etc.)

include("views/". $vista ); // Se incluye el contenido principal, según el valor de la variable $vista que se definió antes

include("views/_pie_de_pagina.php"); //  Se agrega el pie de página

// Todos los archivos están en una carpeta llamada views.

?>

