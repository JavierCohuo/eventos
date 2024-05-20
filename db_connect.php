<?php
$servername = "localhost";
$username = ""; // Reemplaza "tu_usuario" con tu nombre de usuario de MySQL
$password = ""; // Reemplaza "tu_contraseña" con tu contraseña de MySQL
$database = "usuariosdb"; // Reemplaza "usuariosdb" con el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
