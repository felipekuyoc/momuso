<?php
session_start();
session_unset();  // Eliminar todas las variables de sesión
session_destroy();  // Destruir la sesión

// Redirigir al formulario de inicio de sesión
header("Location: InicioMomuso.php");
exit;
?>
