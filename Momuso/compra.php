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
    <div class="row">
                <div class="col">
                  <?php include_once 'aplicacion_pie.php'; ?>
                </div>
            </div>
        </div>
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

<?php
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID_Usuario'])) {
    header("Location: InicioMomuso.php");
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Momuso";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
    $id_usuario = $_SESSION['ID_Usuario'];

    if ($id_producto && $cantidad && $cantidad > 0) {
        // Verificar si hay suficiente inventario disponible
        $stmt = $conn->prepare("SELECT Cantidad_En_Inventario FROM Producto WHERE ID_Producto = ?");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc();
            if ($producto['Cantidad_En_Inventario'] >= $cantidad) {
                // Reducir el inventario
                $nuevo_inventario = $producto['Cantidad_En_Inventario'] - $cantidad;
                $update_inventario = $conn->prepare("UPDATE Producto SET Cantidad_En_Inventario = ? WHERE ID_Producto = ?");
                $update_inventario->bind_param("ii", $nuevo_inventario, $id_producto);
                $update_inventario->execute();

                // Verificar si el producto ya está en el carrito
                $stmt_carrito = $conn->prepare("SELECT ID_Carrito, Cantidad FROM CarritoDeCompras WHERE ID_Usuario = ? AND ID_Producto = ?");
                $stmt_carrito->bind_param("ii", $id_usuario, $id_producto);
                $stmt_carrito->execute();
                $result_carrito = $stmt_carrito->get_result();

                if ($result_carrito->num_rows > 0) {
                    // Actualizar la cantidad del producto en el carrito
                    $row_carrito = $result_carrito->fetch_assoc();
                    $nueva_cantidad_carrito = $row_carrito['Cantidad'] + $cantidad;
                    $update_carrito = $conn->prepare("UPDATE CarritoDeCompras SET Cantidad = ? WHERE ID_Carrito = ?");
                    $update_carrito->bind_param("ii", $nueva_cantidad_carrito, $row_carrito['ID_Carrito']);
                    $update_carrito->execute();
                    echo "<p>El producto ha sido actualizado en tu carrito.</p>";
                } else {
                    // Insertar el producto en el carrito
                    $insert_carrito = $conn->prepare("INSERT INTO CarritoDeCompras (ID_Usuario, ID_Producto, Cantidad) VALUES (?, ?, ?)");
                    $insert_carrito->bind_param("iii", $id_usuario, $id_producto, $cantidad);
                    $insert_carrito->execute();
                    echo "<p>Producto agregado al carrito. ¡Sigue comprando!</p>";
                }
            } else {
                echo "<p>No hay suficiente inventario para completar la compra.</p>";
            }
        } else {
            echo "<p>Producto no encontrado.</p>";
        }
    } else {
        echo "<p>Error en los datos enviados. Verifique la cantidad seleccionada.</p>";
    }
}
$conn->close();
?>
