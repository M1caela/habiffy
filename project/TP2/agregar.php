<?php
require_once("conexion.php");

$ok = true;
$msj = "";

if (isset($_POST['habito'])) {

    //valido todos los datos que necesito:
    if (isset($_POST['habito']) && $_POST['habito'] != "") {
        $habito = $_POST['habito'];
    } else {
        $ok = false;
        $msj .= "Falta ingresar el hábito.<br>";
    }

    if (isset($_POST['frecuencia_num']) && $_POST['frecuencia_num'] != "" && isset($_POST['frecuencia_tipo']) && $_POST['frecuencia_tipo'] != "") {
    $frecuencia = $_POST['frecuencia_num'] . ' ' . $_POST['frecuencia_tipo'];
    } else {
    $ok = false;
    $msj .= "Falta ingresar la frecuencia.<br>";
    }

    //  dia y relevacia no son required //
   
    if (isset($_POST['dia']) && $_POST['dia'] != "") {
        $dia = implode(",", $_POST['dia']); // Convierte array a string
    } else {
        $dia = ''; // Valor predeterminado si no se selecciona ningún día
    }

    if (isset($_POST['relevancia']) && $_POST['relevancia'] != "") {
        $relevancia = $_POST['relevancia'];
    } else {
        $relevancia = ''; // Valor predeterminado si no se selecciona relevancia
    }

    if (isset($_POST['icono']) && $_POST['icono'] != "") {
        $icono = $_POST['icono']; 
    } else {
        $ok = false;
        $msj .= "Falta elegir el ícono.<br>";
    }

   /*
    if ( $ok!= false ) {
        $query = "INSERT INTO habitos (habito, frecuencia, dia, relevancia, icono)
        VALUES ('$habito', '$frecuencia', '$dia', '$relevancia', '$icono')";

        $result = $mysqli->query($query);

        if ( $result ) {
            $msj = "<script>alert('¡Muy bien! Agregaste un nuevo hábito.⚡');</script>";
            echo $msj;
        } else {
            $msj = "<script>alert('No pudimos crear el hábito. Por favor, volvé a intenar luego.');</script>";
            echo $msj;
        }
    }
   */
 
    // Si todos los datos son válidos, insertar en la base de datos
    if ($ok) {
        $stmt = $mysqli->prepare("INSERT INTO habitos (habito, frecuencia, dia, relevancia, icono) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $habito, $frecuencia, $dia, $relevancia, $icono);

        if ($stmt->execute()) {
            echo "<script>alert('¡Muy bien! Agregaste un nuevo hábito.⚡'); window.location.href='index.php';</script>";
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            echo "Código de error: " . $mysqli->errno;
        }
        $stmt->close();
    } else {
        echo $msj; // Mostrar mensajes de error si los datos no son válidos
    }
}

// Depuración: mostrar los datos enviados
echo "<pre>";
print_r($_POST);
echo "</pre>";

?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habiffy | Nuevo hábito </title> 

    <link rel="stylesheet" href="../src/output.css">   
    <link rel="stylesheet" href="css/styles.css"> 
</head>

<body id="agregar">
    <div class="banner bg-verde-oscuro"> 
        <h1>Habiffy</h1>
        <h2>Agregar nuevo hábito</h2>
    </div>

    <div id="contenedor" class="bg-verde-claro flex flex-col border-3 rounded-md p-8 m-10"> 
        <form action="agregar.php" method="POST" class="flex flex-col gap-6 p-6 bg-base-100 rounded-xl shadow-md">
            <!-- Título del hábito (requerido) -->
            <fieldset class="form-control">
                <legend class="label font-semibold">Título del hábito</legend>
                <input type="text" name="habito" id="habito" class="input input-bordered" placeholder="Ej: Leer 10 páginas" required />
                <p class="text-xs mt-1 italic text-gray-500">Podrás editarlo luego desde el tablero.</p>
            </fieldset>

            <!-- Frecuencia (requerido) -->
            <fieldset class="form-control">
                <legend class="label font-semibold">Frecuencia</legend>

                <select name="frecuencia_num" class="num-frec max-w-[4em]" required></select>
                <span id="vez">veces por</span>
                <select name="frecuencia_tipo" class="max-w-[9em]" required>
                    <option value="día">día</option>
                    <option value="semana">semana</option>
                    <option value="mes">mes</option>
                </select>
            </fieldset>

            <!-- Día (opcional) -->
            <fieldset class="form-control">
                <legend class="label font-semibold">Días de la semana (opcional)</legend>
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
                <legend class="label font-semibold">Relevancia (opcional)</legend>
                <div class="flex gap-3">
                <input class="btn" type="radio" name="relevancia" value="baja" aria-label="Baja" />
                <input class="btn" type="radio" name="relevancia" value="media" aria-label="Media" />
                <input class="btn" type="radio" name="relevancia" value="alta" aria-label="Alta" />
                </div>
            </fieldset>

            <!-- Ícono (requerido, usando emoji-button.js) -->
            <fieldset class="form-control">
            <legend class="label font-semibold">Ícono</legend>
            <label class="label text-sm text-gray-500">Haz clic y presiona <kbd class="kbd">Win</kbd> + <kbd class="kbd">.</kbd> para abrir el selector de emojis</label>
            <input type="text" name="icono" id="icono" class="input input-bordered w-40" placeholder="🧮" maxlength="2" required />
            </fieldset>


            <!-- Botón de envío -->
            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">Guardar hábito</button>
            </div>
        </form>
    </div>
  

    <!-- Este es el controlador de / frecuencia / -->
    <script> // llenar los números del primer select 
        var selectNumero = document.querySelector(".num-frec");
        for (var i = 0; i <= 60; i++) {
            var opcion = document.createElement("option");
            opcion.value = i;
            opcion.text = i;
            selectNumero.appendChild(opcion);
        }
        
        // cambiar vez/veces según num
        selectNumero.addEventListener("change", function() {
            var spanTexto = document.getElementById("vez");
            if (this.value == "1") {
                spanTexto.innerText = "vez por";
            } else {
                spanTexto.innerText = "veces por";
            }
        });
    </script>

    <script>
    //emojis
         const button = document.querySelector('#emoji-btn');
        const input = document.querySelector('#icono');

        const picker = new EmojiButton({
            theme: 'auto',
            autoHide: true,
            emojiSize: '1.5em'
        });

        picker.on('emoji', selection => {
            input.value = selection.emoji;
        });

        button.addEventListener('click', () => {
            picker.togglePicker(button);
        });
    </script>
 
</body>
</html>