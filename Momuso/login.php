<?php
// login.php

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $email = $_POST['email'];
    $user_type = $_POST['user-type'];
    
    // Mostrar los datos recibidos
    echo "<h2>Datos del Formulario</h2>";
    echo "<p><strong>E-mail:</strong> " . htmlspecialchars($email) . "</p>";
    echo "<p><strong>Tipo de Usuario:</strong> " . htmlspecialchars($user_type) . "</p>";

    // Aquí puedes añadir la lógica para verificar el correo en la base de datos
    // (esto se omite para enfocarnos en mostrar los datos)
    
    // Ejemplo de respuesta de autenticación
    echo "<p>Intentando iniciar sesión...</p>";

    // Redirigir a la página de bienvenida (descomentar si se desea redirigir)
    // header("Location: welcome.php");
    // exit();
} else {
    // Mostrar un mensaje de error si el acceso no es a través del formulario
    echo "<h2>Error</h2>";
    echo "<p>No se ha enviado el formulario correctamente.</p>";
    echo "<p><a href='InicioMomuso.php'>Volver al inicio</a></p>";
}
?>
