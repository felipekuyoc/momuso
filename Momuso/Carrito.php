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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #f2f2f2;
        }
        th {
            background-color: #f8c8d5;
            color: #d9534f;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        tr:hover {
            background-color: #fce6f1;
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

<?php
 
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

$id_usuario = $_SESSION['ID_Usuario'];

// Consultar productos en el carrito
$stmt = $conn->prepare("
    SELECT Producto.ID_Producto, Producto.Nombre, CarritoDeCompras.Cantidad, Producto.Precio, 
           (CarritoDeCompras.Cantidad * Producto.Precio) AS Total
    FROM CarritoDeCompras
    INNER JOIN Producto ON CarritoDeCompras.ID_Producto = Producto.ID_Producto
    WHERE CarritoDeCompras.ID_Usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Mi Carrito</h1>";
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Nombre']}</td>
                <td>{$row['Cantidad']}</td>
                <td>$" . number_format($row['Precio'], 2) . "</td>
                <td>$" . number_format($row['Total'], 2) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No tienes productos en tu carrito.</p>";
}

$conn->close();
?>

<div class="row">
                <div class="col">
                  <?php include_once 'aplicacion_pie.php'; ?>
                </div>
            </div>
        </div>
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
