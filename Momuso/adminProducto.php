<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "momuso";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Agregar Producto
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['categoria'];

    $sql = "INSERT INTO Producto (Nombre, Descripcion, Precio, Cantidad_En_Inventario, ID_Categoria) 
            VALUES ('$nombre', '$descripcion', $precio, $cantidad, $categoria)";

    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Editar Producto
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['categoria'];

    $sql = "UPDATE Producto SET Nombre='$nombre', Descripcion='$descripcion', Precio=$precio, 
            Cantidad_En_Inventario=$cantidad, ID_Categoria=$categoria WHERE ID_Producto=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Producto actualizado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar Producto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM Producto WHERE ID_Producto=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Producto eliminado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM Producto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f1c6e7;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .boton {
            background-color: #f2b7d1;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
        }
        .boton:hover {
            background-color: #f6a0c4;
        }
        .formulario {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="row">
        <div class="col">
            <?php include_once 'Aplicacionestaticaadmin.php'; ?>
        </div>
    </div>
<h1 style="text-align: center;">Administración de Productos</h1>

<!-- Formulario de agregar producto -->
<div class="formulario">
    <h3>Agregar Producto</h3>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>
        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea><br><br>
        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" required><br><br>
        <label>Cantidad en Inventario:</label>
        <input type="number" name="cantidad" required><br><br>
        <label>Categoría:</label>
        <select name="categoria">
            <!-- Aquí debes cargar las categorías desde la base de datos -->
            <?php
            $categorias = $conn->query("SELECT * FROM Categoria");
            while ($categoria = $categorias->fetch_assoc()) {
                echo "<option value='" . $categoria['ID_Categoria'] . "'>" . $categoria['Nombre'] . "</option>";
            }
            ?>
        </select><br><br>
        <button type="submit" name="agregar" class="boton">Agregar Producto</button>
    </form>
</div>

<!-- Tabla de productos -->
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while($producto = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $producto['Nombre']; ?></td>
            <td><?php echo $producto['Descripcion']; ?></td>
            <td><?php echo $producto['Precio']; ?></td>
            <td><?php echo $producto['Cantidad_En_Inventario']; ?></td>
            <td><?php echo $producto['ID_Categoria']; ?></td>
            <td>
                <button class="boton" onclick="editarProducto(<?php echo $producto['ID_Producto']; ?>, '<?php echo addslashes($producto['Nombre']); ?>', '<?php echo addslashes($producto['Descripcion']); ?>', <?php echo $producto['Precio']; ?>, <?php echo $producto['Cantidad_En_Inventario']; ?>, <?php echo $producto['ID_Categoria']; ?>)">Editar</button>
                <a href="?eliminar=<?php echo $producto['ID_Producto']; ?>" class="boton" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Formulario de editar producto (oculto por defecto) -->
<div id="formEditar" class="formulario" style="display: none;">
    <h3>Editar Producto</h3>
    <form method="POST">
        <input type="hidden" id="editId" name="id">
        <label>Nombre:</label>
        <input type="text" id="editNombre" name="nombre" required><br><br>
        <label>Descripción:</label>
        <textarea id="editDescripcion" name="descripcion" required></textarea><br><br>
        <label>Precio:</label>
        <input type="number" id="editPrecio" name="precio" step="0.01" required><br><br>
        <label>Cantidad en Inventario:</label>
        <input type="number" id="editCantidad" name="cantidad" required><br><br>
        <label>Categoría:</label>
        <select id="editCategoria" name="categoria">
            <?php
            $categorias = $conn->query("SELECT * FROM Categoria");
            while ($categoria = $categorias->fetch_assoc()) {
                echo "<option value='" . $categoria['ID_Categoria'] . "'>" . $categoria['Nombre'] . "</option>";
            }
            ?>
        </select><br><br>
        <button type="submit" name="editar" class="boton">Actualizar Producto</button>
    </form>
</div>

<script>
function editarProducto(id, nombre, descripcion, precio, cantidad, categoria) {
    document.getElementById("formEditar").style.display = "block";
    document.getElementById("editId").value = id;
    document.getElementById("editNombre").value = nombre;
    document.getElementById("editDescripcion").value = descripcion;
    document.getElementById("editPrecio").value = precio;
    document.getElementById("editCantidad").value = cantidad;
    document.getElementById("editCategoria").value = categoria;
}
</script>
<div class="row">
        <div class="col">
            <?php include_once 'aplicacion_pie.php'; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
