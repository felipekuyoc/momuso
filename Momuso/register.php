<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Papelería Kathy</title>
    <style>
        /* Estilos */
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

        .container {
            width: 100%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container, .table-container {
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

        label, input, select, .login-btn, .refresh-btn, .back-btn, .delete-btn {
            padding: 10px;
            font-size: 14px;
        }

        .login-btn, .refresh-btn, .back-btn, .delete-btn {
            background-color: #ff4081;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-btn:hover, .refresh-btn:hover, .back-btn:hover, .delete-btn:hover {
            background-color: #e0356f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #ff4081;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Registrar Usuario</h2>
            <?php
            $conn = new mysqli('localhost', 'root', '', 'momuso');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Registrar nuevo usuario
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
                $nombre = $_POST['nombre'];
                $correo_electronico = $_POST['correo_electronico'];
                $contrasena = $_POST['contrasena'];
                $rol = $_POST['rol'];

                // Usar SHA-256 para almacenar la contraseña
                $hashed_password = hash('sha256', $contrasena); // Almacenamos con SHA-256

                $stmt = $conn->prepare("INSERT INTO usuario (Nombre, Correo_Electronico, Contrasena, Rol) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nombre, $correo_electronico, $hashed_password, $rol);

                if ($stmt->execute()) {
                    echo "<p>Usuario registrado exitosamente.</p>";
                } else {
                    echo "<p>Error al registrar el usuario: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }

            // Eliminar usuario
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id']) && isset($_POST['password_admin'])) {
                $delete_id = $_POST['delete_id'];
                $password_admin = $_POST['password_admin'];

                if ($password_admin === 'felipe123') {
                    $stmt = $conn->prepare("DELETE FROM usuario WHERE ID_Usuario = ?");
                    $stmt->bind_param("i", $delete_id);

                    if ($stmt->execute()) {
                        echo "<p>Usuario eliminado exitosamente.</p>";
                    } else {
                        echo "<p>Error al eliminar el usuario: " . $stmt->error . "</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p>Contraseña incorrecta. No se pudo eliminar el usuario.</p>";
                }
            }

            // Actualizar usuario
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_password']) && $_POST['confirm_password'] === 'felipe123' && isset($_POST['edit_id'])) {
                $edit_id = $_POST['edit_id'];
                $nombre = $_POST['edit_nombre'];
                $correo_electronico = $_POST['edit_correo_electronico'];
                $rol = $_POST['edit_rol'];

                // Actualizar los datos del usuario, no actualizamos la contraseña aquí
                $stmt = $conn->prepare("UPDATE usuario SET Nombre = ?, Correo_Electronico = ?, Rol = ? WHERE ID_Usuario = ?");
                $stmt->bind_param("sssi", $nombre, $correo_electronico, $rol, $edit_id);

                if ($stmt->execute()) {
                    echo "<p>Usuario actualizado exitosamente.</p>";
                } else {
                    echo "<p>Error al actualizar el usuario: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }

            // Actualizar contraseña de usuario
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password_id']) && isset($_POST['new_password'])) {
                $update_password_id = $_POST['update_password_id'];
                $new_password = $_POST['new_password'];

                // Usar SHA-256 para actualizar la contraseña
                $hashed_new_password = hash('sha256', $new_password);

                $stmt = $conn->prepare("UPDATE usuario SET Contrasena = ? WHERE ID_Usuario = ?");
                $stmt->bind_param("si", $hashed_new_password, $update_password_id);

                if ($stmt->execute()) {
                    echo "<p>Contraseña actualizada exitosamente.</p>";
                } else {
                    echo "<p>Error al actualizar la contraseña: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }
            ?>

            <form action="register.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="correo_electronico">Correo Electrónico:</label>
                <input type="email" id="correo_electronico" name="correo_electronico" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <option value="cliente">Cliente</option>
                    <option value="administrador">Administrador</option>
                </select>

                <button type="submit" class="login-btn">Registrar</button>
            </form>

            <form action="InicioMomuso.php" method="GET">
                <button type="submit" class="back-btn">Ir a Inicio</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Lista de Usuarios</h2>
            <form action="register.php" method="POST">
                <button type="submit" class="refresh-btn">Actualizar Lista</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT ID_Usuario, Nombre, Correo_Electronico, Rol FROM usuario");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['ID_Usuario'] . "</td>";
                            echo "<td>" . $row['Nombre'] . "</td>";
                            echo "<td>" . $row['Correo_Electronico'] . "</td>";
                            echo "<td>" . $row['Rol'] . "</td>";
                            echo "<td>
                                    <form action='register.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='delete_id' value='" . $row['ID_Usuario'] . "'>
                                        <label for='password_admin'>Contraseña Administrador:</label>
                                        <input type='password' name='password_admin' required>
                                        <button type='submit' class='delete-btn'>Eliminar</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
