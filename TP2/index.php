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

    <!-- NAV -->    
    <div class="navbar bg-base-100  shadow-sm"> <!-- bg-verde-oscuro -->
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
            <section id="tabla" >
                <a href="agregar.php"><button class="btn btn-primary">+ Nuevo hábito</button></a>
                <table class="min-w-[500px] border-separate border-spacing-2 border bg-beige text-center p-[6px] mb-[6px] ">
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
                            <!-- checkbox para completar hábito (se reinicia diarimanente) -->
                            <td class="border p-5"> 
                                <input type="checkbox" title="¡Completado!"
                                    class="checkbox"
                                    data-id="<?= $estafila['id'] ?>"
                                    onchange="marcarCompletado(this)"
                                    <?= isset($habitosCompletados[$estafila['id']]) ? 'checked' : '' ?>
                                >
                            </td> 

                            <th>   
                                <!-- botones editar / eliminar -->
                                <a  href="editar.php?id=<?php echo $estafila['id']; ?>" class="ml-2  inline-block hover:scale-110 transition cursor-pointer" title="Editar" >✏️</a>
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
                </table> <?php } ?> 
            </section>

            <!-- SECCIÓN DE PROGESO *falta vincular con cada hábito* -->
            <section id="progreso" class="bg-beige w-64 h-auto p-4 m-2 md:m-10 md:mt-12">
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
            <section class="calendario self-star">        
                <calendar-date class="cally bg-base-100 border border-base-300 shadow-lg rounded-box">
                    <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M15.75 19.5 8.25 12l7.5-7.5"></path></svg>
                    <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path></svg>
                    <calendar-month></calendar-month>
                </calendar-date>
            </section> 

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

    <!-- confirmación personalizada (para eliminar habito por ej) -->
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

    <!-- controlador de checkbox para 'completar' habito -->
    <script>
        /* 
        function marcarCompletado(checkbox) {
            const id = checkbox.getAttribute('data-id');
            const estado = checkbox.checked ? 1 : 0;

            fetch('marcar_completado.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&completado=${estado}`
            }).then(() => {
                location.reload();
            });
        }
*/

    // controlador checkbox + guardar historial (?)
    function marcarCompletado(checkbox) {
        const id = checkbox.getAttribute('data-id');
        const estado = checkbox.checked ? 1 : 0;

        // Marcar como completado en la tabla principal
        fetch('marcar_completado.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&completado=${estado}`
        }).then(() => {
            // Si se marcó como completado, guardar en historial
            if (estado === 1) {
                fetch('guardar_historial.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}`
                });
            }

            // Refrescar la página
            location.reload();
        });
    }

    </script>

    <script src="js/modal.js"></script>
    <script type="module" src="https://unpkg.com/cally"></script> <!-- calendario (daisyUI) -->

</body>
</html>
