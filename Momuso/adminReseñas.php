<?php 
session_start();  // Inicia la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Momuso";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} 

// Obtener todas las reseñas de todos los productos
$sqlReseñas = "
    SELECT 
        r.ID_Reseña, r.Puntuacion, r.Comentario, 
        p.Nombre AS NombreProducto, p.Descripcion, p.Precio, 
        CONCAT('Momuso/', p.Nombre, '.png') AS Imagen, 
        u.Nombre AS NombreUsuario
    FROM 
        ReseñasYComentarios r
    JOIN 
        Producto p ON r.ID_Producto = p.ID_Producto
    JOIN 
        Usuario u ON r.ID_Usuario = u.ID_Usuario
";

$stmt = $conn->prepare($sqlReseñas);
$stmt->execute();
$resultadoReseñas = $stmt->get_result();

// Agregar reseña
if (isset($_POST['agregar'])) {
    $idProducto = (int)$_POST['id_producto'];
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $puntuacion = (int)$_POST['puntuacion'];
    
    // Usamos un ID de usuario ficticio, puedes modificar esto según tus necesidades
    $idUsuario = 1;  // O poner un valor como "anónimo" si no se requiere login

    $sqlInsertar = "INSERT INTO ReseñasYComentarios (ID_Producto, ID_Usuario, Puntuacion, Comentario) VALUES (?, ?, ?, ?)";
    $stmtInsertar = $conn->prepare($sqlInsertar);
    $stmtInsertar->bind_param("iiis", $idProducto, $idUsuario, $puntuacion, $comentario);

    if ($stmtInsertar->execute()) {
        echo "<script>alert('Reseña agregada exitosamente.'); window.location.href='reseñas.php';</script>";
    } else {
        echo "<script>alert('Error al agregar reseña.');</script>";
    }
}

// Eliminar reseña
if (isset($_GET['eliminar'])) {
    $idReseña = $_GET['eliminar'];
    $sqlEliminar = "DELETE FROM ReseñasYComentarios WHERE ID_Reseña = ?";
    $stmtEliminar = $conn->prepare($sqlEliminar);
    $stmtEliminar->bind_param("i", $idReseña);

    if ($stmtEliminar->execute()) {
        echo "<script>alert('Reseña eliminada exitosamente.'); window.location.href='reseñas.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar reseña.');</script>";
    }
}

// Editar reseña
if (isset($_POST['editar'])) {
    $idReseña = $_POST['id_reseña'];
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $puntuacion = (int)$_POST['puntuacion'];

    $sqlEditar = "UPDATE ReseñasYComentarios SET Comentario = ?, Puntuacion = ? WHERE ID_Reseña = ?";
    $stmtEditar = $conn->prepare($sqlEditar);
    $stmtEditar->bind_param("sii", $comentario, $puntuacion, $idReseña);

    if ($stmtEditar->execute()) {
        echo "<script>alert('Reseña editada exitosamente.'); window.location.href='reseñas.php';</script>";
    } else {
        echo "<script>alert('Error al editar reseña.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #fe0066; /* Color rosita */
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #fe0066; /* Color rosita */
            color: white;
            padding: 12px;
        }
        td {
            padding: 12px;
            text-align: center;
        }
        td img {
            width: 100px;
            height: auto;
        }
        td p {
            font-size: 14px;
            color: #555;
        }
        .tabla-container {
            overflow-x: auto;
        }
        .botones {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .boton {
            background-color: #fe0066; /* Color rosita */
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .boton:hover {
            background-color: #b1085b;
        }
        /* Estilo para el formulario de edición */
        .formulario-editar {
            display: none;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 50%;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col">
            <?php include_once 'Aplicacionestaticaadmin.php'; ?>
        </div>
    </div>
    <h1>Reseñas de Productos</h1>

    <!-- Formulario para agregar reseña -->
    <div class="formulario-agregar">
        <h3>Agregar Reseña</h3>
        <form method="POST">
            <label for="id_producto">Selecciona Producto:</label>
            <select name="id_producto" required>
                <?php
                // Obtener productos para que el usuario seleccione uno
                $sqlProductos = "SELECT ID_Producto, Nombre FROM Producto";
                $resultProductos = $conn->query($sqlProductos);
                while ($producto = $resultProductos->fetch_assoc()) {
                    echo "<option value='" . $producto['ID_Producto'] . "'>" . $producto['Nombre'] . "</option>";
                }
                ?>
            </select><br>
            <label for="puntuacion">Puntuación (1-5):</label>
            <input type="number" name="puntuacion" min="1" max="5" required><br>
            <label for="comentario">Comentario:</label>
            <textarea name="comentario" required></textarea><br>
            <button class="boton" type="submit" name="agregar">Agregar Reseña</button>
        </form>
    </div>

    <!-- Tabla de reseñas -->
    <div class="tabla-container">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Usuario</th>
                    <th>Puntuación</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultadoReseñas->num_rows > 0): ?>
                    <?php while ($fila = $resultadoReseñas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['NombreProducto']); ?></td>
                            <td><?php echo htmlspecialchars($fila['Descripcion']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($fila['Precio'], 2)); ?></td>
                            <td><img src="<?php echo htmlspecialchars($fila['Imagen']); ?>" alt="<?php echo htmlspecialchars($fila['NombreProducto']); ?>"></td>
                            <td><?php echo htmlspecialchars($fila['NombreUsuario']); ?></td>
                            <td><?php echo htmlspecialchars($fila['Puntuacion']); ?>/5</td>
                            <td><?php echo htmlspecialchars($fila['Comentario']); ?></td>
                            <td class="botones">
                                <!-- Editar -->
                                <button class="boton" onclick="editarReseña(<?php echo $fila['ID_Reseña']; ?>, '<?php echo addslashes($fila['Comentario']); ?>', <?php echo $fila['Puntuacion']; ?>)">Editar</button>
                                <!-- Borrar -->
                                <a href="?eliminar=<?php echo $fila['ID_Reseña']; ?>" class="boton">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8">No hay reseñas disponibles.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Formulario para editar reseña -->
    <div class="formulario-editar" id="formulario-editar">
        <h3>Editar Reseña</h3>
        <form method="POST">
            <input type="hidden" name="id_reseña" id="id_reseña">
            <label for="puntuacion-editar">Puntuación (1-5):</label>
            <input type="number" name="puntuacion" id="puntuacion-editar" min="1" max="5" required><br>
            <label for="comentario-editar">Comentario:</label>
            <textarea name="comentario" id="comentario-editar" required></textarea><br>
            <button class="boton" type="submit" name="editar">Actualizar Reseña</button>
        </form>
    </div>

    <script>
        function editarReseña(id, comentario, puntuacion) {
            document.getElementById('id_reseña').value = id;
            document.getElementById('comentario-editar').value = comentario;
            document.getElementById('puntuacion-editar').value = puntuacion;
            document.getElementById('formulario-editar').style.display = 'block';
        }
    </script>
    <div class="row">
        <div class="col">
            <?php include_once 'aplicacion_pie.php'; ?>
        </div>
    </div>
</body>
</html>
