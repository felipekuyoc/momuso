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
$idCliente = $_SESSION['ID_Usuario'];

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

// Función para agregar reseña (solo si el usuario está autenticado)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario']) && isset($_POST['puntuacion']) && isset($_POST['id_producto'])) {
    $idProducto = $_POST['id_producto'];
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $puntuacion = (int)$_POST['puntuacion'];

    // Insertar la reseña de manera segura
    $sqlInsertar = "INSERT INTO ReseñasYComentarios (ID_Producto, ID_Usuario, Puntuacion, Comentario) VALUES (?, ?, ?, ?)";
    $stmtInsertar = $conn->prepare($sqlInsertar);
    $stmtInsertar->bind_param("iiis", $idProducto, $idCliente, $puntuacion, $comentario);

    if ($stmtInsertar->execute()) {
        echo "Reseña añadida exitosamente.";
    } else {
        echo "Error al añadir reseña: " . $stmtInsertar->error;
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
        .cuadro-reseña {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin: 16px;
            max-width: 300px;
            display: inline-block;
            vertical-align: top;
            text-align: center;
            background-color: #f9f9f9;
        }
        .cuadro-reseña img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .formulario-reseña {
            margin-top: 16px;
        }
    </style>
</head>
<body>

    <div class="row">
        <div class="col">
            <?php include_once 'Aplicacionestatica.php'; ?>
        </div>
    </div>

    <h1>Reseñas de Productos</h1>

    <?php if ($resultadoReseñas->num_rows > 0): ?>
        <?php while ($fila = $resultadoReseñas->fetch_assoc()): ?>
            <div class="cuadro-reseña">
                <img src="<?php echo htmlspecialchars($fila['Imagen']); ?>" alt="<?php echo htmlspecialchars($fila['NombreProducto']); ?>">
                <h2><?php echo htmlspecialchars($fila['NombreProducto']); ?></h2>
                <p><?php echo htmlspecialchars($fila['Descripcion']); ?></p>
                <p>Precio: $<?php echo htmlspecialchars(number_format($fila['Precio'], 2)); ?></p>
                <h3>Reseña:</h3>
                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($fila['NombreUsuario']); ?></p>
                <p><strong>Puntuación:</strong> <?php echo htmlspecialchars($fila['Puntuacion']); ?>/5</p>
                <p><?php echo htmlspecialchars($fila['Comentario']); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay reseñas disponibles.</p>
    <?php endif; ?>

    <div class="formulario-reseña">
        <h2>Agregar una reseña</h2>
        <form method="POST">
            <label for="id_producto">Selecciona el Producto:</label>
            <select name="id_producto" id="id_producto" required>
                <?php
                    // Mostrar los productos disponibles en el formulario
                    $sqlProductos = "SELECT ID_Producto, Nombre FROM Producto";
                    $resultadoProductos = $conn->query($sqlProductos);
                    while ($producto = $resultadoProductos->fetch_assoc()) {
                        echo "<option value='" . $producto['ID_Producto'] . "'>" . htmlspecialchars($producto['Nombre']) . "</option>";
                    }
                ?>
            </select><br>

            <label for="puntuacion">Puntuación (1-5):</label>
            <input type="number" name="puntuacion" id="puntuacion" min="1" max="5" required><br>
            <label for="comentario">Comentario:</label>
            <textarea name="comentario" id="comentario" required></textarea><br>
            <button type="submit">Enviar Reseña</button>
        </form>
    </div>

    <div class="row">
        <div class="col">
            <?php include_once 'aplicacion_pie.php'; ?>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
