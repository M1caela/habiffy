<!-- 
 NOTAS:
 *nombreUsuario
 -->

<?php
// conexion a la base; el resultado se guarda en una variable $mysqli
require_once("conexion.php");
?>

<!-- <link href="https://cdn.jsdelivr.net/combine/npm/daisyui@5/base/rootcolor.css,npm/daisyui@5/base/reset.css,npm/daisyui@5/base/properties.css,npm/daisyui@5/base/svg.css,npm/daisyui@5/base/rootscrollgutter.css,npm/daisyui@5/base/scrollbar.css,npm/daisyui@5/base/rootscrolllock.css,npm/daisyui@5/components/checkbox.css,npm/daisyui@5/components/status.css,npm/daisyui@5/components/button.css,npm/daisyui@5/components/footer.css,npm/daisyui@5/components/validator.css,npm/daisyui@5/components/indicator.css,npm/daisyui@5/components/input.css,npm/daisyui@5/components/calendar.css,npm/daisyui@5/components/radialprogress.css,npm/daisyui@5/components/fieldset.css,npm/daisyui@5/components/hero.css,npm/daisyui@5/components/progress.css,npm/daisyui@5/components/drawer.css,npm/daisyui@5/components/range.css,npm/daisyui@5/components/breadcrumbs.css,npm/daisyui@5/components/chat.css,npm/daisyui@5/components/tab.css,npm/daisyui@5/components/mask.css,npm/daisyui@5/components/stat.css,npm/daisyui@5/components/textarea.css,npm/daisyui@5/components/card.css,npm/daisyui@5/components/list.css,npm/daisyui@5/components/tooltip.css,npm/daisyui@5/components/radio.css,npm/daisyui@5/components/diff.css,npm/daisyui@5/components/stack.css,npm/daisyui@5/components/toggle.css,npm/daisyui@5/components/label.css,npm/daisyui@5/components/filter.css,npm/daisyui@5/components/carousel.css,npm/daisyui@5/components/avatar.css,npm/daisyui@5/components/link.css,npm/daisyui@5/components/alert.css,npm/daisyui@5/components/table.css,npm/daisyui@5/components/steps.css,npm/daisyui@5/components/skeleton.css,npm/daisyui@5/components/mockup.css,npm/daisyui@5/components/swap.css,npm/daisyui@5/components/dock.css,npm/daisyui@5/components/loading.css,npm/daisyui@5/components/divider.css,npm/daisyui@5/components/dropdown.css,npm/daisyui@5/components/fileinput.css,npm/daisyui@5/components/collapse.css,npm/daisyui@5/components/rating.css,npm/daisyui@5/components/menu.css,npm/daisyui@5/components/badge.css,npm/daisyui@5/components/navbar.css,npm/daisyui@5/components/toast.css,npm/daisyui@5/components/timeline.css,npm/daisyui@5/components/select.css,npm/daisyui@5/components/modal.css,npm/daisyui@5/components/countdown.css,npm/daisyui@5/theme/garden.css,npm/daisyui@5/theme/dark.css,npm/daisyui@5/theme/light.css,npm/daisyui@5/theme/cupcake.css,npm/daisyui@5/theme/winter.css" rel="stylesheet" type="text/css" /> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>  --> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habiffy </title> 
    
    <link rel="stylesheet" href="../src/output.css">   
    <link rel="stylesheet" href="css/styles.css">  
</head>

<body class="bg-verde-claro m-0" id="home">

    <!-- BANNER -->
    <div class="banner bg-verde-oscuro"> 
        <div class="m-[12px]">
            <h1>Habiffy</h1>
            <h2>la constancia se convierte en éxito</h2>
        </div>

        <!-- MENÚ --> 
         <!-- 
         <button id="miPerfil"></button>
         <button id="mode"></button>
         <button id="info"></button>
         -->
    </div>

    <div class="flex justify-center text-center">
        <h3 class="font-semibold">¡Hola de nuevo<?php $NombreUsuario ?>!🫡</h3>  
    </div>

    <div id="contenedor" class= "columns-2 flex flex-wrap justify-center align-center p-10">    
        <div id="izquierda" class="mt-[15px] p-[15px] max-w-[70%]">
            <?php  
                // se crea una consulta SQL que pide todos los registros de la tabla habitos
                $query = "SELECT * FROM habitos"; 
                $result = $mysqli->query($query);

                if ( $result->num_rows<=0 ) {
                echo "<p>No hay registros para mostrar...</p>";
                } else { 
            ?>
                
            <!-- TABLA DE HÁBITOS -->
            <section class="tabla">
                <a href="agregar.php"><button class="btn-primary">+ Nuevo hábito</button></a>  <!--  btn importante -->

                <table class="border-separate border-spacing-2 border bg-beige text-center align-center p-[6px] mb-[6px]">
                    <thead>
                        <tr>
                        <th></th>
                        <th class="border p-5">ID</th>
                        <th class="border p-5">Hábito</th>
                        <th class="border p-5">Frecuencia</th>
                        <th class="border p-5">Día</th>
                        <th class="border p-5">Relevancia</th>
                        <th class="border p-5">Ícono</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while( $estafila = $result->fetch_array() ) { ?>
                        <tr>
                        <th> <span id="borrar">X</span> / <span id="editar">E</span> </th>
                        <td class="border p-5"><?php echo $estafila[0];?></td>
                        <td class="border p-5"><?php echo $estafila['habito'];?></td>
                        <td class="border p-5"><?php echo $estafila['frecuencia'];?></td>
                        <td class="border p-5"><?php echo $estafila['dia']?></td>
                        <td class="border p-5"><?php echo $estafila['relevancia']?></td>
                        <td class="border p-5"><?php echo $estafila['icono']?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table> <?php } //end ELSE ?> 
            </section>

            <!-- SECCIÓN DE PROGESO-->
           <section id="progreso" class="bg-beige mt-[15px] p-[15px] max-w-[70%]">
                <div class="todos">
                    <progress class="progress w-56" value="0" max="100"></progress>
                    <progress class="progress w-56" value="10" max="100"></progress>
                    <progress class="progress w-56" value="40" max="100"></progress>
                    <progress class="progress w-56" value="70" max="100"></progress>
                    <progress class="progress w-56" value="100" max="100"></progress>
                </div>
                <div class="individual">
                   <progress class="progress progress-primary w-56" value="40" max="100"></progress>
                </div>
            </section>

        </div>

        <div id="derecha" class= "flex flex-col max-w-[25%]">   
            <!-- CALENDARIO -->
            <section class="calendario">        
                <calendar-date class="cally bg-base-100 border border-base-300 shadow-lg rounded-box">
                    <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M15.75 19.5 8.25 12l7.5-7.5"></path></svg>
                    <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path></svg>
                    <calendar-month></calendar-month>
                </calendar-date>
            </section> 

              <!--  
                NOTAS *proximamente 
                <section class="notas" > </section> 
            -->
        </div> 
    </div>

<script type="module" src="https://unpkg.com/cally"></script>
</body>

</html>
