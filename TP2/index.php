<!--  ** Informática Aplicada I / TP 2 - Micaela Calvo **  ABM / Habit tracker -> "Habiffy: seguimiento de hábitos"  -->

<?php
require_once("conexion.php");
date_default_timezone_set('America/Argentina/Buenos_Aires');
?>

<!DOCTYPE html>
<html data-theme="lightgreen" lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habiffy</title>  
  
    <link rel="stylesheet" href="css/styles.css">    
    <link rel="stylesheet" href="../src/output.css"> 
</head>

<body class="bg-base-200" id="home">

    <!-- NAVBAR -->    
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

    <!-- bienvenida -->
    <div class="flex justify-center text-center ">
        <h3 class="font-semibold text-xl p-4 m-2">¡Hola de nuevo<?php $NombreUsuario ?>!🫡</h3>  
    </div>

    <div id="contenedor" class="p-8 m-4 max-w-[98%]">    
        <?php 
            // se crea una consulta SQL que pide todos los registros de la tabla habitos
            $query = "SELECT * FROM habitos"; 
            $result = $mysqli->query($query);

            // controlador checkbox
            $hoy = date('Y-m-d');
            $habitosCompletados = [];

            // Traer hábitos completados hoy
            $resultCheck = $mysqli->query("SELECT habito_id FROM habito_check WHERE fecha = '$hoy' AND completado = 1");
            while ($row = $resultCheck->fetch_assoc()) {
                $habitosCompletados[$row['habito_id']] = true;
            }

            if ( $result->num_rows<=0 ) {
            echo "<p>No hay registros para mostrar...</p>";
            } else { 
        ?>

        <div class="subcontenedor flex justify-center align-items flex-col md:flex-row lg:flex-row">                
            <!-- TABLA DE HÁBITOS -->
            <section id="tabla">
                <a href="agregar.php"><button class="btn btn-primary bg-accent font-bold">+ Nuevo hábito</button></a>
                <!-- Contenedor con scroll horizontal -->
                <div class="overflow-x-auto max-w-full">
                    <table class="table-auto min-w-[500px] max-w-full border-separate border-spacing-2 border bg-base-300 text-center p-4 m-6">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="border p-5 text-left">Hábito</th>
                                <th class="border p-5 text-left">Frecuencia</th>
                                <th class="border p-5">Días</th>
                                <th class="border p-5">Relevancia</th>
                                <th class="border p-5">Ícono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while( $estafila = $result->fetch_array() ) { ?>
                            <tr>
                                <td class="border p-5">
                                    <input type="checkbox" title="¡Completado!"
                                        class="checkbox border-base-200 bg-neutral checked:border-success checked:bg-success checked:text-success-content checked:text-grey checked:line-through checked:italic"
                                        name="completado" id="completado_<?= $estafila['id'] ?>"
                                        data-id="<?= $estafila['id'] ?>"
                                        onchange="marcarCompletado(this,event)"
                                        <?= isset($habitosCompletados[$estafila['id']]) ? 'checked' : '' ?>
                                    >
                                </td>
                                <th>
                                    <a href="editar.php?id=<?php echo $estafila['id']; ?>" class="ml-2 inline-block hover:scale-110 transition cursor-pointer" title="Editar">✏️</a>
                                    <button
                                        class="ml-2 hover:scale-110 transition cursor-pointer" title="Eliminar" onclick="mostrarConfirmacion({
                                            titulo: '¿Eliminar hábito?',
                                            mensaje: 'Quitaremos “<?= htmlspecialchars($estafila['habito'], ENT_QUOTES) ?>” de la tabla. Esta acción no se puede deshacer.',
                                            onConfirm: () => window.location.href = 'eliminar.php?id=<?= $estafila['id'] ?>'
                                        })">
                                        ❌
                                    </button>
                                </th>
                                <td></td>
                                <td class="border p-5 font-semibold text-left <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['habito']; ?></td>
                                <td class="border p-5 text-left <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['frecuencia']; ?></td>
                                <td class="border p-5 text-left <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['dia']; ?></td>
                                <td class="border p-5 font-medium <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['relevancia']; ?></td>
                                <td class="border p-5 text-xl <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['icono']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>  <?php } ?>
                </div>
            </section>

            <!-- SECCIÓN DE PROGESO *falta vincular con cada hábito* -->
            <section id="progreso" class="bg-base-300 w-64 h-auto p-4 m-2 md:m-10 md:mt-12">
                <div class="todos flex flex-wrap gap-2">
                    <progress class="progress w-40" value="0" max="100"></progress>
                    <progress class="progress w-40" value="10" max="100"></progress>
                    <progress class="progress w-40" value="40" max="100"></progress>
                    <progress class="progress w-40" value="70" max="100"></progress>
                    <progress class="progress w-40" value="100" max="100"></progress>
                </div>
                <div class="individual mt-4">
                <progress class="progress w-40 progress-primary" value="40" max="100"></progress>
                </div>
            </section> 

        </div>   

        <div class="subcontenedor flex justify-center align-items flex-col md:flex-row lg:flex-row p-4 max-w-[98%]"> 
            <!-- CALENDARIO -->

             <section class="calendario self-start">        
                <calendar-date
                    class="cally bg-base-100 border border-base-300 shadow-lg rounded-box"
                    id="calendar"
                >
                    <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                    </svg>
                    <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                    </svg>
                    <calendar-month></calendar-month>
                </calendar-date>
            </section>

            <!-- <section class="calendario self-star">        
                <calendar-date class="cally bg-base-100 border border-base-300 shadow-lg rounded-box">
                    <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M15.75 19.5 8.25 12l7.5-7.5"></path></svg>
                    <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path></svg>
                    <calendar-month></calendar-month>
                </calendar-date>
            </section>  -->

            <!--  NOTAS *proximamente*
                <section class="notas" > </section> 
            -->
        </div>
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

    <!-- confirmación personalizada (para eliminar habito) -->
    <input type="checkbox" id="modal-alerta" class="modal-toggle" />
    <div class="modal" id="modalConfirm">
        <div class="modal-box">
            <h3 class="font-bold text-lg" id="modal-titulo">¿Confirmar acción?</h3>
            <p class="py-4" id="modal-mensaje">Mensaje personalizable.</p>
            <div class="modal-action">
            <label for="modal-alerta" class="btn">Cancelar</label>
            <button id="btn-confirmar" class="btn btn-error">Sí, continuar</button>
            </div>
        </div>
    </div>

    <!-- Modal flotante calendario -->
    <!-- <input type="checkbox" id="modal-dia" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg" id="modal-titulo">Hábitos del día</h3>
            <p class="py-4" id="modal-contenido">Aquí se mostrarán los hábitos completados para el día seleccionado.</p>
            <div class="modal-action">
                <label for="modal-dia" class="btn">Cerrar</label>
            </div>
        </div>
    </div> -->

    <script src="js/controlador-checkbox.js"></script> <!-- estilos del hábito cuando se marcó completo -->
    <script src="js/modal.js"></script>  <!-- confirm personalizado -->
    <script src="js/theme-handler.js"></script>  <!-- guardar el tema en localStorage -->
    <script type="module" src="https://unpkg.com/cally"></script> <!-- calendario (daisyUI) -->
        
</body>
</html>
