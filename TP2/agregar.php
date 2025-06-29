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

?>

<!DOCTYPE html>
<html lang="es" data-theme="lightgreen">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear hábito | Habiffy </title> 

    <link rel="stylesheet" href="../src/output.css">   
    <link rel="stylesheet" href="css/styles.css"> 
</head>

<body id="agregar" class="bg-base-200">
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
                       <img alt="Menú" src="img/menu-icon.svg" />
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
        <form action="agregar.php" method="POST" class="flex flex-col gap-6 p-6 bg-base-300 rounded-xl">
            <!-- Título del hábito (requerido) -->
            <fieldset class="form-control">
                <legend class="font-semibold">Título del hábito</legend>
                <input type="text" name="habito" id="habito" class="input input-bordered bg-base-300" placeholder="Ej: Leer 20 minutos" required />
                <p class="text-xs mt-1 italic text-gray-500">Podrás editarlo luego desde el tablero.</p>
            </fieldset>

            <!-- Frecuencia (requerido) -->
            <fieldset class="form-control font-semibold">
                <legend class=" font-semibold">Frecuencia</legend>
                <select name="frecuencia_num" class="num-frec max-w-[4em] bg-base-300" required></select>
                <span name="frecuencia_num" id="vez">veces por</span>
                <select name="frecuencia_tipo" class="max-w-[9em] bg-base-300" required>
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
            
            <input type="text" name="icono" id="icono" class="input input-bordered w-40 bg-base-300 " placeholder="🌈" maxlength="3" required />
            <label class="label text-sm text-gray-500">Presiona <kbd class="kbd">Win</kbd> + <kbd class="kbd">.</kbd> para abrir el selector de emojis</label>
            </fieldset>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">Guardar hábito</button>
                <a href="index.php" class="font-semibold ml-4">Cancelar</a>
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

    <footer class="footer sm:footer-horizontal bg-verde-oscuro text-neutral-content p-6">
        <aside>
            <h1 class="mb-4">Habiffy</h1>
            <p>Copyright © 2025 - Derechos Reservados</p>
        </aside>

        <!-- redes -->
        <nav class="grid-flow-col gap-4 md:place-self-end md:justify-self-end">
            <a href="https://www.behance.net/micaelacalvo" title="Behance" target="_blank" class="hover:scale-110 transition cursor-pointer">
                <svg 
                    role="img" 
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    class="fill-current">
                    <path d="M16.969 16.927a2.561 2.561 0 0 0 1.901.677 2.501 2.501 0 0 0 1.531-.475c.362-.235.636-.584.779-.99h2.585a5.091 5.091 0 0 1-1.9 2.896 5.292 5.292 0 0 1-3.091.88 5.839 5.839 0 0 1-2.284-.433 4.871 4.871 0 0 1-1.723-1.211 5.657 5.657 0 0 1-1.08-1.874 7.057 7.057 0 0 1-.383-2.393c-.005-.8.129-1.595.396-2.349a5.313 5.313 0 0 1 5.088-3.604 4.87 4.87 0 0 1 2.376.563c.661.362 1.231.87 1.668 1.485a6.2 6.2 0 0 1 .943 2.133c.194.821.263 1.666.205 2.508h-7.699c-.063.79.184 1.574.688 2.187ZM6.947 4.084a8.065 8.065 0 0 1 1.928.198 4.29 4.29 0 0 1 1.49.638c.418.303.748.711.958 1.182.241.579.357 1.203.341 1.83a3.506 3.506 0 0 1-.506 1.961 3.726 3.726 0 0 1-1.503 1.287 3.588 3.588 0 0 1 2.027 1.437c.464.747.697 1.615.67 2.494a4.593 4.593 0 0 1-.423 2.032 3.945 3.945 0 0 1-1.163 1.413 5.114 5.114 0 0 1-1.683.807 7.135 7.135 0 0 1-1.928.259H0V4.084h6.947Zm-.235 12.9c.308.004.616-.029.916-.099a2.18 2.18 0 0 0 .766-.332c.228-.158.411-.371.534-.619.142-.317.208-.663.191-1.009a2.08 2.08 0 0 0-.642-1.715 2.618 2.618 0 0 0-1.696-.505h-3.54v4.279h3.471Zm13.635-5.967a2.13 2.13 0 0 0-1.654-.619 2.336 2.336 0 0 0-1.163.259 2.474 2.474 0 0 0-.738.62 2.359 2.359 0 0 0-.396.792c-.074.239-.12.485-.137.734h4.769a3.239 3.239 0 0 0-.679-1.785l-.002-.001Zm-13.813-.648a2.254 2.254 0 0 0 1.423-.433c.399-.355.607-.88.56-1.413a1.916 1.916 0 0 0-.178-.891 1.298 1.298 0 0 0-.495-.533 1.851 1.851 0 0 0-.711-.274 3.966 3.966 0 0 0-.835-.073H3.241v3.631h3.293v-.014ZM21.62 5.122h-5.976v1.527h5.976V5.122Z"/>
                </svg>
            </a>

            <a href="https://github.com/M1caela" title="Github" target="_blank" class="hover:scale-110 transition cursor-pointer">
                <svg 
                    role="img" 
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    class="fill-current">
                    <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                </svg>
            </a>

            <a href="https://www.linkedin.com/in/micaela-calvo-/" title="LinkedIn" target="_blank" class="hover:scale-110 transition cursor-pointer">
                <svg 
                    role="img" 
                    xmlns="http://www.w3.org/2000/svg" 
                    width="24" 
                    height="24" 
                    viewBox="0 0 24 24" 
                    class="fill-current">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.352V9h3.414v1.561h.049c.476-.9 1.637-1.852 3.368-1.852 3.6 0 4.268 2.368 4.268 5.451v6.292zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM6.814 20.452H3.861V9h2.953v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.226.792 24 1.771 24h20.451C23.2 24 24 23.226 24 22.271V1.729C24 .774 23.2 0 22.222 0z"/>
                </svg>
            </a>
        </nav>
    </footer>

    <script src="js/controlador-frecuencia.js"></script>
    <script src="js/theme-handler.js"></script> <!-- guardar modo en localStorage -->

</body>
</html>