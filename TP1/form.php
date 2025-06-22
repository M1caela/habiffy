<!--  Informática Aplicada I - TP 1 - Micaela Calvo  -->

<!DOCTYPE html>
<html lang="es" data-theme="autumn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="bg-indigo-200 p-[80px]">
    
        <div class="flex justify-center align-center">

            <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                    <h2 class="mt-10 mb-6 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Crea tu cuenta</h2>
                </div>

                <form action="procesar-form.php" method="POST">
                    <fieldset class="fieldset w-xs bg-base-200 dark:bg-neutral-700 border border-base-300 p-4 rounded-box">                        
                        <label class="fieldset-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="input" placeholder="Email" required />
                        
                        <label class="fieldset-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="input" placeholder="Password" required />
                        
                        <label class="fieldset-label" for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="input"  placeholder="Nombre" required>

                        <label class="fieldset-label" for="apellido">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="input" placeholder="Nombre" required>

                        <label class="fieldset-label" for="nacimiento">Fecha de nacimiento</label>
                        <input class="input" type="date" id="nacimiento" name="nacimiento" required /><br>

                        <label>Seleccioná tus intereses:</label><br>
                        <div class="flex flex-col space-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="intereses[]" value="Tecnología" class="form-checkbox">
                                <span class="ml-2">Tecnología</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="intereses[]" value="Cine" class="form-checkbox">
                                <span class="ml-2">Cine</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="intereses[]" value="Deportes" class="form-checkbox">
                                <span class="ml-2">Deportes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="intereses[]" value="Música" class="form-checkbox">
                                <span class="ml-2">Música</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="intereses[]" value="Arte" class="form-checkbox">
                                <span class="ml-2">Arte</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="intereses[]" value="Cocina" class="form-checkbox">
                                <span class="ml-2">Cocina</span>
                            </label>
                        </div>

                        <input type="submit" value="Registrarse" class="btn btn-neutral mt-4" id="botonEnviar">
                    </fieldset>
                </form> 
            </div>
        </div>
    </div>

</body>
</html>


