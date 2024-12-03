<?php
session_start();  // Inicia la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID_Usuario'])) {
    header("Location: InicioMomuso.php");  // Redirigir al formulario de inicio de sesión si no está autenticado
    exit();
}

// Obtener los datos del usuario de la sesión
$nombre = $_SESSION['Nombre'];
$correo = $_SESSION['Correo_Electronico'];
$rol = $_SESSION['Rol'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Momuso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .profile-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            color: #ff4081;
        }

        .profile-info {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        .logout-btn {
            background-color: #ff4081;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #e0356f;
        }
    </style>
</head>
<body>

    <div class="profile-container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h1>
        
        <div class="profile-info">
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
            <p><strong>Rol:</strong> <?php echo htmlspecialchars($rol); ?></p>
        </div>

        <a href="logout.php">
            <button class="logout-btn">Cerrar sesión</button>
        </a>
    </div>

</body>
</html>
