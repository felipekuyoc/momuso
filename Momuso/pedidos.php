<?php
// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los pedidos del usuario
$id_usuario = 1;  // ID del usuario (puede venir de la sesión)
$sql = "SELECT p.ID_Pedido, p.Fecha_Compra, p.Estado_Pedido, dp.ID_Producto, dp.Cantidad, dp.Precio 
        FROM Pedido p
        JOIN Detalle_Pedido dp ON p.ID_Pedido = dp.ID_Pedido
        WHERE p.ID_Usuario = $id_usuario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Pedido ID: " . $row['ID_Pedido'] . "<br>";
        echo "Fecha: " . $row['Fecha_Compra'] . "<br>";
        echo "Estado: " . $row['Estado_Pedido'] . "<br>";
        echo "Producto: " . $row['ID_Producto'] . " | Cantidad: " . $row['Cantidad'] . " | Precio: $" . $row['Precio'] . "<br><br>";
    }
} else {
    echo "No tienes pedidos.";
}

$conn->close();
?>
