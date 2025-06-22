<?php
require_once("conexion.php");

// Obtener el ID del hábito a editar
if (!isset($_GET['id'])) {
    echo "No se especificó un hábito para editar.";
    exit;
}

$id = $_GET['id'];
$stmt = $mysqli->prepare("SELECT * FROM habitos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "Hábito no encontrado.";
    exit;
}

$habito = $resultado->fetch_assoc();
$stmt->close();

// Separar frecuencia
$partesFrecuencia = explode(" ", $habito['frecuencia']);
$frecuencia_num = $partesFrecuencia[0];
$frecuencia_tipo = end($partesFrecuencia);

// Separar días
$diasSeleccionados = explode(",", $habito['dia']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ok = true;
    $msj = "";

    if (isset($_POST['habito']) && $_POST['habito'] != "") {
        $nuevoHabito = $_POST['habito'];
    } else {
        $ok = false;
        $msj .= "Falta ingresar el hábito.<br>";
    }

    if (isset($_POST['frecuencia_num']) && $_POST['frecuencia_num'] != "" && isset($_POST['frecuencia_tipo']) && $_POST['frecuencia_tipo'] != "") {
        $frecuencia_num = $_POST['frecuencia_num'];
        $frecuencia_tipo = $_POST['frecuencia_tipo'];

        if ($frecuencia_num == 1) {
            $nuevaFrecuencia = "1 vez por " . $frecuencia_tipo;
        } else {
            $nuevaFrecuencia = $frecuencia_num . " veces por " . $frecuencia_tipo;
        }
    } else {
        $ok = false;
        $msj .= "Falta ingresar la frecuencia.<br>";
    }

    $nuevoDia = isset($_POST['dia']) ? implode(",", $_POST['dia']) : '';
    $nuevaRelevancia = isset($_POST['relevancia']) ? $_POST['relevancia'] : '';
    $nuevoIcono = isset($_POST['icono']) ? $_POST['icono'] : '';

    if ($nuevoIcono == "") {
        $ok = false;
        $msj .= "Falta elegir el ícono.<br>";
    }

    if ($ok) {
        $stmt = $mysqli->prepare("UPDATE habitos SET habito = ?, frecuencia = ?, dia = ?, relevancia = ?, icono = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nuevoHabito, $nuevaFrecuencia, $nuevoDia, $nuevaRelevancia, $nuevoIcono, $id);

        if ($stmt->execute()) {
            echo "<script>alert('¡Hábito actualizado con éxito! ✅'); window.location.href='index.php';</script>";
        } else {
            echo "Error al actualizar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo $msj;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habiffy | Editar hábito</title>

    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body id="editar" class="bg-verde-claro">
    <div class="banner bg-verde-oscuro">
        <h1>Habiffy</h1>
        <h2>Editar hábito</h2>
    </div>
    
    <div id="contenedor" class="bg-[#1c6065] flex flex-col border-3 rounded-md p-8 m-10">
        <form action="" method="POST" class="flex flex-col gap-6 p-6 bg-base-100 rounded-xl shadow-md">
            <fieldset class="form-control">
                <legend class="font-semibold">Título del hábito</legend>
                <input type="text" name="habito" class="input input-bordered" required value="<?= htmlspecialchars($habito['habito']) ?>" />
            </fieldset>

            <fieldset class="form-control font-semibold">
                <legend class="font-semibold">Frecuencia</legend>
                <select name="frecuencia_num" class="num-frec max-w-[4em]" required>
                    <?php
                    for ($i = 1; $i <= 60; $i++) {
                        $selected = ($i == $frecuencia_num) ? "selected" : "";
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
                <span id="vez"><?= ($frecuencia_num == 1) ? "vez por" : "veces por" ?></span>
                <select name="frecuencia_tipo" class="max-w-[9em]" required>
                    <option value="día" <?= ($frecuencia_tipo == 'día') ? "selected" : "" ?>>día</option>
                    <option value="semana" <?= ($frecuencia_tipo == 'semana') ? "selected" : "" ?>>semana</option>
                    <option value="mes" <?= ($frecuencia_tipo == 'mes') ? "selected" : "" ?>>mes</option>
                </select>
            </fieldset>

            <fieldset class="form-control">
                <legend class="font-semibold">Días de la semana (opcional)</legend>
                <div class="flex flex-wrap gap-3">
                    <?php
                    $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                    foreach ($dias as $dia) {
                        $checked = in_array($dia, $diasSeleccionados) ? "checked" : "";
                        echo "<label><input type='checkbox' name='dia[]' value='$dia' class='checkbox mr-1' $checked />$dia</label>";
                    }
                    ?>
                </div>
            </fieldset>

            <fieldset class="form-control">
                <legend class="font-semibold">Relevancia (opcional)</legend>
                <div class="flex gap-3">
                    <input class="btn" type="radio" name="relevancia" value="baja" <?= ($habito['relevancia'] == 'baja') ? "checked" : "" ?> aria-label="Baja" />
                    <input class="btn" type="radio" name="relevancia" value="media" <?= ($habito['relevancia'] == 'media') ? "checked" : "" ?> aria-label="Media" />
                    <input class="btn" type="radio" name="relevancia" value="alta" <?= ($habito['relevancia'] == 'alta') ? "checked" : "" ?> aria-label="Alta" />
                </div>
            </fieldset>

            <fieldset class="form-control">
                <legend class="font-semibold">Ícono</legend>
                <input type="text" name="icono" class="input input-bordered w-40" placeholder="🧮" maxlength="2" required value="<?= htmlspecialchars($habito['icono']) ?>" />
                <label class="label text-sm text-gray-500">Presiona <kbd class="kbd">Win</kbd> + <kbd class="kbd">.</kbd> para abrir el selector de emojis</label>
            </fieldset>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">Actualizar hábito</button>
                <a href="index.php" class="font-semibold ml-4" >Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Modal personalizado DaisyUI -->
    <input type="checkbox" id="modal-alerta" class="modal-toggle" />
    <div class="modal" id="modalConfirm">
        <div class="modal-box">
            <h3 class="font-bold text-lg" id="modal-titulo">¿Confirmar acción?</h3>
            <p class="py-4" id="modal-mensaje">Este mensaje se puede personalizar según lo que hagas.</p>
            <div class="modal-action">
            <label for="modal-alerta" class="btn">Cancelar</label>
            <button id="btn-confirmar" class="btn btn-error">Sí, continuar</button>
            </div>
        </div>
    </div>


    <script>
        var selectNumero = document.querySelector(".num-frec");
        var spanTexto = document.getElementById("vez");

        selectNumero.addEventListener("change", function () {
            spanTexto.innerText = this.value == "1" ? "vez por" : "veces por";
        });
    </script>

<script src="js/modal.js"></script>
</body>
</html>
