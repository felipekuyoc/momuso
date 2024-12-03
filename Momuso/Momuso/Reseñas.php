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

// Insertar nueva reseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_resena'])) {
    $id_producto = $_POST['id_producto'];
    $id_usuario = $_POST['id_usuario'];
    $puntuacion = $_POST['puntuacion'];
    $comentario = $_POST['comentario'];

    $id_producto = (int)$id_producto;
    $id_usuario = (int)$id_usuario;
    $puntuacion = (int)$puntuacion;
    $comentario = $conn->real_escape_string($comentario);

    $sql_insert = $conn->prepare("INSERT INTO ReseñasYComentarios (ID_Producto, ID_Usuario, Puntuacion, Comentario) VALUES (?, ?, ?, ?)");
    $sql_insert->bind_param("iiis", $id_producto, $id_usuario, $puntuacion, $comentario);

    if ($sql_insert->execute()) {
        echo "Reseña agregada exitosamente.<br>";
    } else {
        echo "Error: " . $sql_insert->error . "<br>";
    }

    $sql_insert->close();
}

// Eliminar reseña
if (isset($_GET['eliminar_resena'])) {
    $id_resena = (int)$_GET['eliminar_resena'];
    $sql_delete = $conn->prepare("DELETE FROM ReseñasYComentarios WHERE ID_Reseña = ?");
    $sql_delete->bind_param("i", $id_resena);

    if ($sql_delete->execute()) {
        echo "Reseña eliminada exitosamente.<br>";
    } else {
        echo "Error: " . $sql_delete->error . "<br>";
    }

    $sql_delete->close();
}

// Editar reseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_resena'])) {
    // Validar y sanitizar los datos
    $id_resena = isset($_POST['id_resena']) ? (int)$_POST['id_resena'] : 0;
    $id_producto = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;
    $id_usuario = isset($_POST['id_usuario']) ? (int)$_POST['id_usuario'] : 0;
    $puntuacion = isset($_POST['puntuacion']) ? (int)$_POST['puntuacion'] : 0;
    $comentario = isset($_POST['comentario']) ? $conn->real_escape_string($_POST['comentario']) : '';

    // Validar que los campos no estén vacíos o fuera de rango
    if ($id_resena > 0 && $id_producto > 0 && $id_usuario > 0 && $puntuacion >= 1 && $puntuacion <= 5 && !empty($comentario)) {
        // Preparar la consulta de actualización
        $sql_update = $conn->prepare("UPDATE ReseñasYComentarios SET ID_Producto = ?, ID_Usuario = ?, Puntuacion = ?, Comentario = ? WHERE ID_Reseña = ?");
        $sql_update->bind_param("iiisi", $id_producto, $id_usuario, $puntuacion, $comentario, $id_resena);

        // Ejecutar y verificar el resultado
        if ($sql_update->execute()) {
            echo "<script>alert('Reseña actualizada exitosamente.');</script>";
            echo "<script>window.location.href = 'index.php';</script>"; // Redirige para evitar reenvío de formulario
        } else {
            echo "<script>alert('Error al actualizar la reseña: " . $sql_update->error . "');</script>";
        }

        $sql_update->close();
    } else {
        echo "<script>alert('Por favor, complete todos los campos correctamente.');</script>";
    }
}


// Obtener todas las reseñas
$sql = "
    SELECT 
        r.ID_Reseña, 
        p.Nombre AS Producto, 
        u.Nombre AS Usuario, 
        r.Puntuacion, 
        r.Comentario, 
        r.Fecha
    FROM ReseñasYComentarios r
    JOIN Producto p ON r.ID_Producto = p.ID_Producto
    JOIN Usuario u ON r.ID_Usuario = u.ID_Usuario
    ORDER BY r.ID_Reseña DESC
";
$result = $conn->query($sql);

// Obtener productos y usuarios para los formularios
$productos_result = $conn->query("SELECT ID_Producto, Nombre FROM Producto");
$usuarios_result = $conn->query("SELECT ID_Usuario, Nombre FROM Usuario");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Momuso - Comentarios y Reseñas</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        /* Encabezado */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #ffffff;
        }

        .header img {
            height: 100px;
            width: auto;
        }

        .header .search-bar {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 600px;
            position: relative;
        }

        .header .search-bar input {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 25px;
            padding-left: 15px;
            font-size: 14px;
        }

        .header .search-bar button {
            position: absolute;
            right: 5px;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header .search-bar button img {
            width: 30px;
            height: 30px;
        }

        /* Barra de navegación */
        .nav {
            display: flex;
            justify-content: center;
            background-color: #fe0066;
            padding: 10px;
        }

        .nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 14px;
        }

        .nav a:hover {
            background-color: #cccccc;
        }

        /* Banner */
        .banner {
            background-color: #ffcc00;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
        }

        /* Información del producto */
        .product-info {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            max-width: 80%;
            border: 1px solid #cccccc;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-info h3 {
            margin: 0;
            color: #333;
        }

        .product-info p {
            margin: 5px 0;
            color: #666;
        }

        .product-info img {
            max-width: 100px;
            height: auto;
            margin-right: 20px;
            float: left;
        }

        .reviews {
            margin-top: 20px;
            border-top: 1px solid #cccccc;
            padding-top: 10px;
        }

        .review-item {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #eeeeee;
            border-radius: 5px;
            background-color: #fafafa;
        }

        .review-item h4 {
            margin: 0;
            font-size: 16px;
            color: #555;
        }

        .review-item p {
            margin: 5px 0;
            color: #777;
        }

        .review-item .rating {
            color: #fe0066;
        }

        /* Sección de comentarios y reseñas */
        .reviews-section {
            background-color: white;
            padding: 20px;
        }

        .reviews-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .reviews-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .reviews-section th, .reviews-section td {
            border: 1px solid #cccccc;
            text-align: center;
            padding: 10px;
        }

        .reviews-section th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .reviews-section button {
            background-color: #fe0066;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 80px;
            height: 35px;
        }

        .reviews-section button:hover {
            background-color: #ff4081;
        }

        /* Nueva columna de botones */
        .action-buttons {
            text-align: center;
        }

        .action-buttons button {
            margin: 5px;
        }
    </style>
</head>
<body>

    <!-- Encabezado con barra de búsqueda e iconos -->
    <div class="header">
        <img src="Momuso/LO.png" alt="Momuso Logo">
        <div class="search-bar">
            <input type="text" placeholder="¿Buscas ofertas? Este mes, explora los mejores descuentos">
            <button><img src="Momuso/busqueda.png" alt="Buscar"></button>
        </div>
        <div class="top-bar">
            <p>Únete a Momuso</p>
            <a href="registro.html">
                <button class="img-button">
                    <img src="Momuso/Personal.png" alt="Tienda Virtual">
                </button>
            </a>
            <a href="favoritos.html">
                <button class="img-button">
                    <img src="Momuso/Favorito.png" alt="Favoritos">
                </button>
            </a>
            <a href="mi-cuenta.html">
                <button class="img-button">
                    <img src="Momuso/Cestas.png" alt="Mi Cuenta">
                </button>
            </a>
            <a href="carrito.html">
                <button class="img-button">
                    <img src="Momuso/Mensaje.png" alt="Carrito de Compras">
                </button>
            </a>
        </div>
    </div>

    <!-- Barra de navegación -->
    <div class="nav">
        <a href="Categoria.php">Categorías</a>
        <a href="Ofertas.php">Ofertas y Descuentos</a>
    </div>

    <!-- Banner -->
    <section class="banner">
        <img src="Momuso/SE.png" alt="Happy Halloween">
    </section>

    <!-- Información del producto -->
    <div class="product-info">
        <img src="Momuso/producto.png" alt="Producto">
        <h3>Nombre del Producto</h3>
        <p>Descripción breve del producto. Aquí puedes agregar detalles importantes sobre el artículo.</p>
        <p><strong>Precio:</strong> $99.99</p>
    </div>

    <!-- Sección de reseñas -->
    <div class="reviews-section">
        <h2>Comentarios y Reseñas</h2>

        <!-- Formulario para agregar una reseña -->
        <form method="POST" action="">
            <select name="id_producto">
                <option value="">Seleccione el producto</option>
                <?php while ($row = $productos_result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ID_Producto']; ?>"><?php echo $row['Nombre']; ?></option>
                <?php } ?>
            </select>

            <select name="id_usuario">
                <option value="">Seleccione el usuario</option>
                <?php while ($row = $usuarios_result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ID_Usuario']; ?>"><?php echo $row['Nombre']; ?></option>
                <?php } ?>
            </select>

            <input type="number" name="puntuacion" min="1" max="5" placeholder="Puntuación (1-5)" required>
            <textarea name="comentario" rows="5" placeholder="Escribe tu comentario aquí..." required></textarea>

            <button type="submit" name="submit_resena">Agregar Reseña</button>
        </form>
         
            
        
        <!-- Mostrar reseñas -->
        <table>
            <tr>
                <th>Producto</th>
                <th>Usuario</th>
                <th>Puntuación</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th> <!-- Nueva columna para los botones -->
            </tr>

            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['Producto']}</td>
                        <td>{$row['Usuario']}</td>
                        <td class='rating'>{$row['Puntuacion']}</td>
                        <td>{$row['Comentario']}</td>
                        <td>{$row['Fecha']}</td>
                        <td class='action-buttons'>
                            <a href='?editar_resena={$row['ID_Reseña']}'>
                                <button>Editar</button>
                            </a>
                            <a href='?eliminar_resena={$row['ID_Reseña']}'>
                                <button>Eliminar</button>
                            </a>
                        </td>
                    </tr>";
                }
            } ?>
        </table>
    </div>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
