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

// Consulta de productos
$sql = "SELECT ID_Producto, Nombre, Descripcion, Precio, Cantidad_En_Inventario FROM Producto";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Momuso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
        }
        .product img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
        }
        .product h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .product p {
            margin-bottom: 10px;
            color: #555;
        }
        .product strong {
            color: #d9534f;
        }
        form {
            margin-top: 10px;
        }
        button {
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #c9302c;
        }
    </style>
    <script>
        // Función de verificación de autenticación
        function verificarAutenticacion() {
            <?php if (!isset($_SESSION['ID_Usuario'])): ?>
                alert("Por favor, inicie sesión para realizar una compra.");
                window.location.href = "InicioMomuso.php"; // Redirige a la página de inicio de sesión
                return false; // No envía el formulario
            <?php else: ?>
                return true; // Si el usuario está autenticado, envía el formulario
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <div class="row">
        <div class="col">
            <?php include_once 'Aplicacionestatica.php'; ?>
        </div>
    </div>
    <div class="container">
        <h1>Productos Momuso</h1>
        <div class="products">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <img src="Momuso/<?php echo htmlspecialchars($row['Nombre']); ?>.png" alt="<?php echo htmlspecialchars($row['Nombre']); ?>">
                        <h3><?php echo htmlspecialchars($row['Nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($row['Descripcion']); ?></p>
                        <p><strong>$<?php echo number_format($row['Precio'], 2); ?></strong></p>
                        <p>Disponibles: <?php echo htmlspecialchars($row['Cantidad_En_Inventario']); ?></p>
                        <form action="compra.php" method="POST">
                            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($row['ID_Producto']); ?>">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" name="cantidad" min="1" max="<?php echo htmlspecialchars($row['Cantidad_En_Inventario']); ?>" required>
                            <button type="submit" onclick="return verificarAutenticacion();">Comprar</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay productos disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
                <div class="col">
                  <?php include_once 'aplicacion_pie.php'; ?>
                </div>
            </div>
        </div>
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
