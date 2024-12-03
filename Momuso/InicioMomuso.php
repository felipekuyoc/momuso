<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "momuso";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $selected_rol = strtolower(trim($_POST['rol']));

    // Validar formato de correo
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, ingresa un correo válido.');</script>";
        exit();
    }

    // Consulta SQL para obtener usuario
    $stmt = $conn->prepare("SELECT ID_Usuario, Nombre, Correo_Electronico, Contrasena, Rol FROM usuario WHERE Correo_Electronico = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['ID_Usuario'];
        $nombre = $row['Nombre'];
        $hashed_password = $row['Contrasena'];
        $user_rol = strtolower(trim($row['Rol']));

        // Verificar contraseña
        if (hash('sha256', $password) === $hashed_password) {
            // Verificar rol
            if ($selected_rol === $user_rol) {
                // Configurar sesión y redirigir
                $_SESSION['ID_Usuario'] = $user_id;
                $_SESSION['Nombre'] = $nombre;
                $_SESSION['Correo_Electronico'] = $row['Correo_Electronico'];
                $_SESSION['Rol'] = $user_rol;

                if ($user_rol === 'administrador') {
                    header("Location: adminmomuso.php");
                } elseif ($user_rol === 'cliente') {
                    header("Location: Momuso.php");
                }
                exit();
            } else {
                echo "<script>alert('El rol seleccionado no coincide con el registrado.');</script>";
            }
        } else {
            echo "<script>alert('Contraseña incorrecta.');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.');</script>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Momuso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo img {
            width: 150px;
            margin-bottom: 20px;
        }

        h2 {
            color: #ff4081;
            margin-bottom: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            font-size: 14px;
            color: #333;
        }

        input, select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .login-btn {
            background-color: #ff4081;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-btn:hover {
            background-color: #e0356f;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="Momuso/LO.png" alt="Momuso">
        </div>
        <h2>Iniciar sesión</h2>
        <p>¿Es tu primera vez aquí? <a href="register.php">Regístrate</a></p>

        <form action="" method="POST">
            <label for="email">E-mail*</label>
            <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>

            <label for="password">Contraseña*</label>
            <input type="password" id="password" name="password" placeholder="****" required>

            <label for="rol">Selecciona tu rol</label>
            <select name="rol" id="rol" required>
                <option value="cliente">Cliente</option>
                <option value="administrador">Administrador</option>
            </select>

            <button type="submit" class="login-btn">Ingresar</button>
        </form>
        <br>
        <button onclick="window.location.href='InicioMomuso.php?guest=true';" class="login-btn">Entrar como invitado</button>
    </div>
</body>
</html>

