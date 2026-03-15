<?php
$servername = "localhost";
$username = "root"; // Tu usuario de MySQL (por defecto root en XAMPP/WAMP)
$password = "";     // Tu contraseña (por defecto vacía)
$dbname = "portafolio_jhonny";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>