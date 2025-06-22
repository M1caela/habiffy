<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>

<body>
    <form action="recibe_form.php" method="POST">
        <label for="nombre">Tu nombre:</label><br>
        <input type="text" name="nombre" id="nombre" placeholder="Ingresá Tu Nombre">
        <hr>
        <label for="sentimiento">Qué tan feliz sos?</label><br>
        <select name="sentimiento" id="sentimiento">
            <option value="0">No lo suficiente</option>
            <option value="1">No me puedo quejar</option>
            <option value="2">Podría estar mejor</option>
            <option value="3">No lo sé... lo charlamos luego</option>
            <option value="4">Estoy en mi mejor momento</option>
        </select>
        <hr>
        <label for="cantidad">Seleccioná cantidad de dados:</label><br>
        <select name="cantidad" id="cantidad">
            <option value="1">1</option>
            <option value="5">5</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <hr>

        <hr>
        <label for="usu">usuario</label><br>
        <input type="text" name="usu" id="usu">
        <br>
        <label for="pass">clave</label><br>
        <input type="password" name="pass" id="pass">
       
        <hr>

        <label for="anio_nac">Año de nacimiento</label><br>
        <select name="anio_nac" id="anio_nac">
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
            <option value="..">..</option>
            <option value="1925">1925</option>
        </select>
        <hr>

        <input type="color" name="miColor" id="miColor">
        <input type="submit" name="boton_enviar" value="ENVIAR">
    </form>
</body>

</html>