<!--  Informática Aplicada I - TP 1 - Micaela Calvo  -->

<?php
echo "<pre>";

// Recibir las variables POST
$email = $_POST['email'];
$password = $_POST['password'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$nacimiento = $_POST['nacimiento'];

// Mostrar el valor
echo "<h1>Datos Recibidos</h1>";
echo "<p>Email: $email</p>";
echo "<p>Nombre: $nombre</p>";
echo "<p>Apellido: $apellido</p>";
echo "<p>Nacimiento: $nacimiento</p>";

// Validación condicional: password
if (strlen($password) < 6) {
    echo "La contraseña es menor a 6 caracteres.<br>";
} else {
    echo "La contraseña es mayor a 6 caracteres.<br>";
}


// Validación condicional: mayor o menor de edad
$fechaNacimiento = new DateTime($nacimiento); // Convertir la fecha de nacimiento a un objeto DateTime
$fechaActual = new DateTime(); // Fecha actual
$edad = $fechaActual->diff($fechaNacimiento)->y; // Calcular la edad

if ($edad >= 18) {
    echo "El usuario es mayor de edad.<br><br>";
} else {
    echo "El usuario es  menor de edad.<br><br>";
} 


// Estructura repetitiva: edad
$fechaNacimiento = new DateTime($nacimiento);
$hoy = new DateTime();
$edad = $hoy->diff($fechaNacimiento)->y; // el metodo diff devuelve la diferencia de edad, con ->y se obtiene la cantidad de añod

echo "<p>Años cumplidos:</p>";
for ($i = 1; $i <= $edad; $i++) {
    echo " $i 🎂<br>"; 
}

// Estructura repetitiva: intereses
$intereses = $_POST['intereses']; // cada chechbox tiene el mismo name, asi que se agrupan en el array intereses

echo "<br><p>Intereses seleccionados:</p>";
for ($i = 0; $i < count($intereses); $i++) {
    echo "- " . $intereses[$i] . "<br>";
}

echo "</pre>";
?>