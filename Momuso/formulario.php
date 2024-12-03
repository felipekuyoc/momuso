<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Compra</title>
</head>
<body>
    <h1>Realizar Compra</h1>

    <!-- Formulario para ingresar los datos del producto y la cantidad -->
    <form action="procesar_compra.php" method="POST">
        <label for="id_producto">ID del Producto:</label>
        <input type="number" name="id_producto" id="id_producto" placeholder="ID del Producto" required><br><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad" required><br><br>

        <button type="submit">Comprar</button>
    </form>
</body>
</html>
