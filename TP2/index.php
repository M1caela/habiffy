<!--  ** Informática Aplicada I / TP 2 - Micaela Calvo **  ABM / Habit tracker -> "Habiffy: seguimiento de hábitos"  -->

<?php
require_once("conexion.php");
date_default_timezone_set('America/Argentina/Buenos_Aires');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habiffy</title>  
    <link rel="stylesheet" href="../src/output.css">   
    <link rel="stylesheet" href="css/styles.css">  
</head>

<body class="bg-verde-claro m-0" id="home">

    <!-- BANNER -->
    <div class="navbar flex bg-verde-oscuro w-full h-auto"> 
        <div class="m-[12px]">
            <h1 class="pb-2">Habiffy</h1>
            <h2>la constancia se convierte en éxito</h2>
        </div>
    
        <!--  MENÚ: pefil / salir --> 
        <div class="flex align-top justify-end self-end"><a href="login.php" title="Cerrar sesión">
            <a href="perfil.php" title="Perfil"><img src="img/mi-perfil.png" alt="Ícono de Mi Perfil" class="ml-2 hover:scale-110 transition cursor-pointer"></a>
            <a href="login-php" title="Cerrar sesión"><img src="img/cerrar-sesion.png" alt="Ícono de Salir" class="ml-2 hover:scale-110 transition cursor-pointer"></a> </div>
        </div>
    </div>

    <div class="flex justify-center text-center">
        <h3 class="font-semibold text-xl">¡Hola de nuevo<?php $NombreUsuario ?>!🫡</h3>  
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
            <!-- CALENDARIO *por ahora es solo visual, más adelante se conecta con el seguimiento del hábito* -->
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

        <!-- PREGUNTAS FRECUENTES 
        <div class="preguntas p-8 m-6 w-full md:w-[30%]">
        <h2 class="text-bold text-lg md:text-xl">Preguntas frecuentes</h2>
            <div class="collapse bg-beige border-300 m-8 max-w-[80%] md:max-w-[40%]">
                <input type="checkbox" />
                <div class="collapse-title font-semibold">¿Cómo funciona Habiffy?</div>
                <div class="collapse-content text-sm">
                texto texto 
                </div>
            </div>
    -->        
            <div class="collapse bg-beige border-base-300 border m-8 max-w-[80%] md:max-w-[40%]">
                <input type="checkbox" />
                <div class="collapse-title font-semibold">¿Pregunta?</div>
                <div class="collapse-content text-sm">
                texto texto 
                </div>
            </div>

            <div class="collapse bg-beige border-base-300 border m-8 max-w-[80%] md:max-w-[40%]">
                <input type="checkbox" />
                <div class="collapse-title font-semibold">¿Pregunta?</div>
                <div class="collapse-content text-sm">
                texto texto 
                </div>
            </div>
        </div>
    </div>

    <!-- CONTROLADOR DE TEMA -->
    <div class="join join-vertical">
        <input
            type="radio"
            name="theme-buttons"
            class="btn bg-verde-oscuro theme-controller join-item"
            aria-label="Default"
            value="default" />
        <input
            type="radio"
            name="theme-buttons"
            class="btn bg-verde-oscuro theme-controller join-item"
            aria-label="Light"
            value="light" />
        <input
            type="radio"
            name="theme-buttons"
            class="btn bg-verde-oscuro theme-controller join-item"
            aria-label="Dark"
            value="dark" />
    </div>

    <footer class="bg-verde-oscuro h-[50px] md:h-[80px] w-full">
    </footer>

    <!-- confirm personalizado -->
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

    <!-- <script> 
        function confirmarEliminacion(boton) {
            var id = boton.getAttribute('data-id');
            var habito = boton.getAttribute('data-habito');

            if (confirm(`¿Eliminar el hábito "${habito}"? Esta acción no se puede deshacer.`)) {
                window.location.href = "eliminar.php?id=" + id;
            }
        }
    </script> -->

    <!-- controlador checkbox -->
    <script>
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
    </script>

    <script src="js/modal.js"></script>
    <script type="module" src="https://unpkg.com/cally"></script> <!-- calendario (daisyUI) -->

</body>
</html>
