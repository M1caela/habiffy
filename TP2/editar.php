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
    <title>Editar hábito | Habiffy</title>

    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body id="editar" class="bg-base-200">
    <!-- NAV -->    
    <div class="navbar bg-base-100  shadow-sm"> 
        <div class="flex-1 m-8">
            <h1 class="text-xl pb-2">Habiffy</h1>
            <h2>la constancia se convierte en éxito</h2>
        </div>

        <div class="flex-none m-4">
            <!-- MENÚ -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Menú" src="img/menu.png" /> 
                    </div>
                </div>

                <!-- opciones -->
                <ul tabindex="0"class="menu menu-sm dropdown-content bg-base-300 bg-verde-oscuro rounded-box z-1 mt-3 w-52 p-2 shadow">
                  
                    <li><a>Perfil</a></li>   
                    <li><a>Preguntas</a></li> <!-- *falta desarrollar* -->
                    <li><a>Contacto</a></li>
                    <li><a>Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div id="contenedor" class="flex flex-col border-3 rounded-md p-2 m-10 shadow-md">
        <form action="" method="POST" class="flex flex-col gap-6 p-6 bg-base-300 rounded-xl">
            <!-- Título del hábito (requerido) -->
            <fieldset class="form-control">
                <legend class="font-semibold">Título del hábito</legend>
                <input type="text" name="habito" class="input input-bordered" required value="<?= htmlspecialchars($habito['habito']) ?>" />
            </fieldset>
            
            <!-- Frecuencia (requerido) -->
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

            <!-- Día (opcional) -->
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

            <!-- Relevancia (opcional) -->
            <fieldset class="form-control">
                <legend class="font-semibold">Relevancia (opcional)</legend>
                <div class="flex gap-3">
                    <input class="btn" type="radio" name="relevancia" value="baja" <?= ($habito['relevancia'] == 'baja') ? "checked" : "" ?> aria-label="Baja" />
                    <input class="btn" type="radio" name="relevancia" value="media" <?= ($habito['relevancia'] == 'media') ? "checked" : "" ?> aria-label="Media" />
                    <input class="btn" type="radio" name="relevancia" value="alta" <?= ($habito['relevancia'] == 'alta') ? "checked" : "" ?> aria-label="Alta" />
                </div>
            </fieldset>

            <!-- Ícono (requerido) -->
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

    <!-- CONTROLADOR DE TEMA -->
    <div class="join join-horizontal m-10">
        <input
            type="radio"
            name="theme-buttons"
            class="btn bg-verde-oscuro theme-controller join-item"
            aria-label="Light"
            value="lightgreen" />
        <input
            type="radio"
            name="theme-buttons"
            class="btn bg-verde-oscuro theme-controller join-item"
            aria-label="Dark"
            value="darkgreen" />
    </div>

    <footer class="footer flex sm:footer-horizontal bg-verde-oscuro text-neutral-content items-center p-4 m-0">
        <!-- logo -->
        <aside class="grid-flow-col items-center">
            <svg
            width="36"
            height="36"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            fill-rule="evenodd"
            clip-rule="evenodd"
            class="fill-current">
            <path
                d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z"></path>
            </svg>
            <p>Copyright © 2025 - Derechos Reservados</p>
        </aside>

        <!-- redes -->
        <nav class="grid-flow-col gap-4 md:place-self-center md:justify-self-end">
            <a>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    class="fill-current">
                    <path
                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                </svg>
            </a>
            <a>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    class="fill-current">
                    <path
                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                </svg>
            </a>
            <a>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    class="fill-current">
                    <path
                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                </svg>
            </a>
        </nav>
    </footer>


    <!-- controlador de 'frecuencia' (dia de select y vez/veces) -->
    <script>
        var selectNumero = document.querySelector(".num-frec");
        var spanTexto = document.getElementById("vez");

        selectNumero.addEventListener("change", function () {
            spanTexto.innerText = this.value == "1" ? "vez por" : "veces por";
        });
    </script>
  
  <!-- guardar modo en localStorage -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
           
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
                const themeButtons = document.querySelectorAll('.theme-controller');
                themeButtons.forEach((button) => {
                    if (button.value === savedTheme) {
                        button.checked = true;
                    }
                });
            }

            const themeButtons = document.querySelectorAll('.theme-controller');
            themeButtons.forEach((button) => {
                button.addEventListener('change', function () {
                    const selectedTheme = this.value;
                    document.documentElement.setAttribute('data-theme', selectedTheme);
                    localStorage.setItem('theme', selectedTheme); // Save the theme in localStorage
                });
            });
        });
    </script>

    <!-- <script src="js/modal.js"></script> -->
</body>

</html>