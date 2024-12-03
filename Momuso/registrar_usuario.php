<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "momuso"; // Nombre de tu base de datos

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$correo_electronico = $_POST['email'];
$contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña
$rol = $_POST['user-type']; // 'Cliente' o 'Administrador'

// Insertar datos en la tabla Usuario
$sql = "INSERT INTO Usuario (Nombre, Correo_Electronico, Contrasena, Rol) VALUES ('$nombre', '$correo_electronico', '$contrasena', '$rol')";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
