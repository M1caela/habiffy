<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil | Habiffy </title>

       
       
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">    
    <link rel="stylesheet" href="../src/output.css"> 
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="bg-verde-claro m-0" id="home">
    <div id="contenedor" class="p-8 m-4 max-w-[98%]">   

        <!-- component -->
        <main class="profile-page">
            <section class="relative block h-500-px">
                <!-- fondo -->
                <div class="absolute top-0 w-full h-full bg-center bg-cover" style="
                        background-image: url('https://images.unsplash.com/photo-1499336315816-097655dcfbda?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2710&amp;q=80');">
                    <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
                </div>
            </section>

            <section class="relative py-16 bg-blueGray-200">
                <div class="container mx-auto px-4">
                    <!-- cuerpo -->
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                        <div class="px-6">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                                    <!-- foto de perfil -->
                                    <div class="relative">
                                    <img alt="..." src="https://demos.creative-tim.com/notus-js/assets/img/team-2-800x800.jpg" class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-12">
                                <h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2 p-8">
                                <?php $NombreUsuario ?> Nombre
                                </h3>
                            </div>

                            <!-- contenido -->
                            <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                                <div class="flex flex-wrap justify-center">
                                    <div class="w-full lg:w-9/12 px-4">
                                        <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
                                            TEXTO .... 
                                        </p>

                                        <!-- formulario con datos -->
                                        <!-- 
                                        *info personal*
                                        Nombre y apellido / apodo / mail / clave

                                        * configuración *
                                        habilitar / deshabilitar sonidos
                                        habilitar / deshabilitar saludo del incicio (¡hola de nuevo!)
                                        establecer modo default (dark - light - darklight)
                                        -->
                                        <form action="">
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
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

    <script src="js/modal.js"></script>
</body>
</html>