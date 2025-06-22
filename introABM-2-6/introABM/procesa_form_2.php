<?php
require_once("conexion.php");


//procesamos el archivo recibido:
echo "<pre>";
print_r( $_FILES);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $nombreArchivo = $_FILES["imagen"]["name"];
        $tipoArchivo = $_FILES["imagen"]["type"];
        $tamañoArchivo = $_FILES["imagen"]["size"];
        $ubicacionTemporal = $_FILES["imagen"]["tmp_name"];

        // Validar el tipo de archivo
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        $extensionesPermitidas = array("jpg", "jpeg", "png", "pdf");
        if (!in_array($extension, $extensionesPermitidas)) {
            echo "Solo se permiten archivos de tipo: " . implode(", ", $extensionesPermitidas);
            exit;
        }

        // Validar el tamaño del archivo
        if ($tamañoArchivo > 1000000) { // 1 MB
            echo "El archivo es demasiado grande.";
            exit;
        }

        // Mover el archivo a la ubicación deseada
        $directorioDestino = "imagenes_enviadas/"; // Crea esta carpeta si no existe
        $nombreArchivoDestino = uniqid() . "." . $extension; // Nombre único
        $rutaDestino = $directorioDestino . $nombreArchivoDestino;

        if (move_uploaded_file($ubicacionTemporal, $rutaDestino)) {
            echo "El archivo se ha subido correctamente a: " . $rutaDestino;


            //si todo fue bien, hago el INSERT en la base de datos:
            //ver esto en los ejemplos anteriores:
            $query = " INSERT INTO miTabla
            SET
                imagen = '$nombreArchivoDestino',
                titulo = '$titulo'
            ";
            //etc para completar el insert...


        } else {
            echo "Hubo un error al subir el archivo.";
        }

        

    } else {
        echo "Error al subir el archivo.";
    }
}
?>