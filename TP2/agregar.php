<?php
require_once("conexion.php");

$ok = true;
$msj = "";
$mostrarModalExito = false;

if (isset($_POST['habito'])) {

    // validación de datos
    
    if (isset($_POST['habito']) && $_POST['habito'] != "") {
        $habito = $_POST['habito'];
    } else {
        $ok = false;
        $msj .= "Falta ingresar el hábito.<br>";
    }

    if (isset($_POST['frecuencia_num']) && $_POST['frecuencia_num'] != "" && isset($_POST['frecuencia_tipo']) && $_POST['frecuencia_tipo'] != "") {
    $frecuencia_num = $_POST['frecuencia_num'];
    $frecuencia_tipo = $_POST['frecuencia_tipo'];

    if ($frecuencia_num == 1) {
        $frecuencia = "1 vez por " . $frecuencia_tipo;
    } else {
        $frecuencia = $frecuencia_num . " veces por " . $frecuencia_tipo;
    }
    } else {
        $ok = false;
        $msj .= "Falta ingresar la frecuencia.<br>";
    }

    /* dia y relevacia no son required */
    if (isset($_POST['dia']) && $_POST['dia'] != "") {
        $dia = implode(",", $_POST['dia']); // convierte array a string
    } else {
        $dia = ''; 
    }

    if (isset($_POST['relevancia']) && $_POST['relevancia'] != "") {
        $relevancia = $_POST['relevancia'];
    } else {
        $relevancia = ''; 
    }

    if (isset($_POST['icono']) && $_POST['icono'] != "") {
        $icono = $_POST['icono']; 
    } else {
        $ok = false;
        $msj .= "Falta elegir el ícono.<br>";
    }
 
    // validar datos y preparar consulta
    if ($ok) {
        $stmt = $mysqli->prepare("INSERT INTO habitos (habito, frecuencia, dia, relevancia, icono) VALUES (?, ?, ?, ?, ?)");     
        $stmt->bind_param("sssss", $habito, $frecuencia, $dia, $relevancia, $icono); 
            // 'bind_param' vincula los valores reales a los marcadores (?) en la consulta (+ seguro, previene inyecciones SQL)
            
        // se ejecuta consulta
        if ($stmt->execute()) {
             $mostrarModalExito = true;
            echo "<script>alert('¡Muy bien! Agregaste un nuevo hábito.⚡'); window.location.href='index.php';</script>";
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo $msj; // mostrar mensajes de error si los datos no son válidos
    }
}

// Depuración de error: mostrar los datos enviados
// echo "<pre>"; print_r($_POST); echo "</pre>";

?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habiffy | Nuevo hábito </title> 

    <link rel="stylesheet" href="../src/output.css">   
    <link rel="stylesheet" href="css/styles.css"> 
</head>

<body id="agregar" class="bg-verde-claro">
    <div class="banner bg-verde-oscuro"> 
        <h1>Habiffy</h1>
        <h2>Agregar nuevo hábito</h2>
    </div>

    <div id="contenedor" class="bg-[#1c6065] flex flex-col border-3 rounded-md p-8 m-10"> 
        <form action="agregar.php" method="POST" class="flex flex-col gap-6 p-6 bg-base-100 rounded-xl shadow-md">
            <!-- Título del hábito (requerido) -->
            <fieldset class="form-control">
                <legend class=" font-semibold">Título del hábito</legend>
                <input type="text" name="habito" id="habito" class="input input-bordered" placeholder="Ej: Leer 20 minutos" required />
                <p class="text-xs mt-1 italic text-gray-500">Podrás editarlo luego desde el tablero.</p>
            </fieldset>

            <!-- Frecuencia (requerido) -->
            <fieldset class="form-control font-semibold">
                <legend class=" font-semibold">Frecuencia</legend>
                <select name="frecuencia_num" class="num-frec max-w-[4em]" required></select>
                <span name="frecuencia_num" id="vez">veces por</span>
                <select name="frecuencia_tipo" class="max-w-[9em]" required>
                    <option value="día">día</option>
                    <option value="semana">semana</option>
                    <option value="mes">mes</option>
                </select>
            </fieldset>

            <!-- Día (opcional) -->
            <fieldset class="form-control">
                <legend class=" font-semibold">Días de la semana (opcional)</legend>
                <div class="flex flex-wrap gap-3">
                    <label><input type="checkbox" id="dia" name="dia[]" value="Lunes" class="checkbox mr-1" />Lunes</label>
                    <label><input type="checkbox" id="dia" name="dia[]" value="Martes" class="checkbox mr-1" />Martes</label>
                    <label><input type="checkbox" id="dia" name="dia[]" value="Miércoles" class="checkbox mr-1" />Miércoles</label>
                    <label><input type="checkbox" id="dia" name="dia[]" value="Jueves" class="checkbox mr-1" />Jueves</label>
                    <label><input type="checkbox" id="dia" name="dia[]" value="Viernes" class="checkbox mr-1" />Viernes</label>
                    <label><input type="checkbox" id="dia" name="dia[]" value="Sábado" class="checkbox mr-1" />Sábado</label>
                    <label><input type="checkbox" id="dia" name="dia[]" value="Domingo" class="checkbox mr-1" />Domingo</label>
                </div>
            </fieldset>

            <!-- Relevancia (opcional) -->
            <fieldset class="form-control">
                <legend class="font-semibold">Relevancia (opcional)</legend>
                <div class="flex gap-3">
                <input class="btn" type="radio" name="relevancia" value="baja" aria-label="Baja" />
                <input class="btn" type="radio" name="relevancia" value="media" aria-label="Media" />
                <input class="btn" type="radio" name="relevancia" value="alta" aria-label="Alta" />
                </div>
            </fieldset>

            <!-- Ícono (requerido) -->
            <fieldset class="form-control">
            <legend class=" font-semibold">Ícono</legend>
            
            <input type="text" name="icono" id="icono" class="input input-bordered w-40" placeholder="🌈" maxlength="3" required />
            <label class="label text-sm text-gray-500">Presiona <kbd class="kbd">Win</kbd> + <kbd class="kbd">.</kbd> para abrir el selector de emojis</label>
            </fieldset>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">Guardar hábito</button>
                <a href="index.php" class="font-semibold ml-4">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- controlador de 'frecuencia' -->
    <script> // 'cantidad' del primer select 
        var selectNumero = document.querySelector(".num-frec");
        for (var i = 0; i <= 60; i++) {
            var opcion = document.createElement("option");
            opcion.value = i;
            opcion.text = i;
            selectNumero.appendChild(opcion);
        }
        
        // cambiar vez/veces según cantidad
        selectNumero.addEventListener("change", function() {
            var spanTexto = document.getElementById("vez");
            if (this.value == "1") {
                spanTexto.innerText = "vez por";
            } else {
                spanTexto.innerText = "veces por";
            }
        });
    </script>

</body>
</html>