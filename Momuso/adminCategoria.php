<?php
// Incluir la conexión a la base de datos
include 'db_connection.php';

// Manejar la inserción de una nueva categoría
if (isset($_POST['add_category'])) {
    $nombre = $_POST['nombre'];

    if (!empty($nombre)) {
        $query = "INSERT INTO categoria (Nombre) VALUES ('$nombre')";
        mysqli_query($conn, $query);
    }
}

// Manejar la eliminación de una categoría
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM categoria WHERE ID_Categoria = $id"; 
    mysqli_query($conn, $query);
}

// Manejar la edición de una categoría
if (isset($_POST['edit_category'])) {
    $id = $_POST['id_categoria'];
    $nombre = $_POST['nombre'];

    if (!empty($nombre)) {
        $query = "UPDATE categoria SET Nombre = '$nombre' WHERE ID_Categoria = $id"; 
        mysqli_query($conn, $query);
    }
}

// Obtener todas las categorías
$query = "SELECT * FROM categoria";
$result = mysqli_query($conn, $query);
$categorias = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Momuso - Categoría y Administración de Contenido</title>
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

        /* Barra superior con botones de imagen */
        .top-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-bar p {
            margin: 0;
            color: white;
            font-weight: bold;
        }

        .top-bar img {
            width: 25px;
            height: 25px;
        }

        /* Estilos para los botones de imagen */
        .img-button {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: transform 0.2s ease-in-out; /* Efecto al pasar el mouse */
        }

        /* Efecto cuando el mouse pasa por encima */
        .img-button:hover {
            transform: scale(1.1); /* Aumenta el tamaño de la imagen */
        }

        /* Ajuste de las imágenes */
        .img-button img {
            width: 40px; /* Ajusta el tamaño de las imágenes */
            height: auto;
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

        /* Productos destacados */
        .products-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 20px;
            background-color: white;
        }

        .product {
            background-color: white;
            text-align: center;
            margin: 10px;
            padding: 10px;
            width: 150px;
        }

        .product img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .product p {
            margin: 10px 0;
            font-size: 14px;
        }

        .product button {
            background-color: #ff0066;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .product button:hover {
            background-color: #ff0066;
        }

        /* Anuncio */
        .announcement {
            background-color: #cccccc;
            color: black;
            padding: 15px;
            text-align: center;
            margin: 20px;
            border-radius: 10px;
        }

        /* Sección de categorías */
        .categories-section {
            background-color: white;
            padding: 20px;
        }

        .categories-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .category {
            display: inline-block;
            width: 150px;
            margin: 10px;
            text-align: center;
        }

        .category img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        .category p {
            margin: 10px 0;
            font-size: 14px;
        }

        .subcategory-menu {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0 8px 16px rgb(253, 253, 253);
            border-radius: 10px;
            top: 130px;
            left: 0;
            z-index: 1;
            width: 100%;
        }

        .subcategory-menu a {
            color: black;
            padding: 10px;
            text-decoration: none;
            display: block;
            text-align: left;
            font-size: 13px;
        }

        .subcategory-menu a:hover {
            background-color: #f1f1f1;
        }

        .category:hover .subcategory-menu {
            display: block;
        }

        /* Administración de contenido */
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            color: #333;
        }

        /* Tabla de categorías */
        .category-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .category-table th, .category-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .category-table th {
            background-color: #fe0066;
            color: #ffffff;
        }

        .category-table td img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
        }

        /* Botones */
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-add {
            background-color: #4CAF50;
            color: white;
            margin-bottom: 20px;
        }

        .btn-edit {
            background-color: #ffa500;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
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
            <a href="adminPerfil.php">
                <button class="img-button">
                    <img src="Momuso/Personal.png" alt="Tienda Virtual">
                </button>
            </a>
            <a href="adminCarrito.php">
                <button class="img-button">
                    <img src="Momuso/Cestas.png" alt="Mi Cuenta">
                </button>
            </a>
            <a href="adminReseñas.php">
                <button class="img-button">
                    <img src="Momuso/Mensaje.png" alt="Reseñas">
                </button>
            </a>
            <a href="Cerrar.php">
                <button class="img-button">
                    <img src="Momuso/salir.png" alt="salir">
                </button>
            </a>
        </div>
    </div>
    

    <!-- Barra de navegación -->
    <div class="nav">
    <a href="adminmomuso.php">Inicio</a>
        <a href="adminCategoria.php">Categorías</a>
        <a href="adminProducto.php">Producto</a>
        <a href="adminOfertas.php">Ofertas y Descuentos</a>
    </div>

    <!-- Sección de categorías -->
   <div class="categories-section">
    <h2>Comprar por categoría</h2>
    
    <?php foreach ($categorias as $categoria): ?>
        <div class="category">
            <?php 
            // Rutas posibles para las imágenes
            $image_path_jpg = "Momuso/" . strtolower($categoria['Nombre']) . ".jpg";
            $image_path_jpeg = "Momuso/" . strtolower($categoria['Nombre']) . ".jpeg";
            $image_path_png = "Momuso/" . strtolower($categoria['Nombre']) . ".png";

            // Determinar cuál imagen usar
            if (file_exists($image_path_jpg)) {
                $image_src = $image_path_jpg;
            } elseif (file_exists($image_path_jpeg)) {
                $image_src = $image_path_jpeg;
            } elseif (file_exists($image_path_png)) {
                $image_src = $image_path_png;
            } else {
                $image_src = "Momuso/default.png"; // Imagen predeterminada
            }
            ?>
            <img src="<?= $image_src ?>" alt="<?= $categoria['Nombre'] ?>">
            <p><?php echo $categoria['Nombre']; ?></p>
            <div class="subcategory-menu">
            </div>
        </div>
    <?php endforeach; ?>
</div>


    <!-- Sección de gestión de categorías -->
    <div class="container">
        <h2>Gestión de Categorías</h2>

        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre de la categoría" required>
            <button type="submit" name="add_category" class="btn btn-add">Agregar Nueva Categoría</button>
        </form>

        <table class="category-table">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre de la Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
    <td>
        <?php 
        // Rutas posibles para las imágenes
        $image_path_jpg = "Momuso/" . strtolower($categoria['Nombre']) . ".jpg";
        $image_path_jpeg = "Momuso/" . strtolower($categoria['Nombre']) . ".jpeg";
        $image_path_png = "Momuso/" . strtolower($categoria['Nombre']) . ".png";

        // Determinar cuál imagen usar
        if (file_exists($image_path_jpg)) {
            $image_src = $image_path_jpg;
        } elseif (file_exists($image_path_jpeg)) {
            $image_src = $image_path_jpeg;
        } elseif (file_exists($image_path_png)) {
            $image_src = $image_path_png;
        } else {
            $image_src = "Momuso/default.png"; // Imagen por defecto si no existe ninguna
        }
        ?>
        <img src="<?= $image_src ?>" alt="<?= $categoria['Nombre'] ?>">
    </td>
    <td><?php echo $categoria['Nombre']; ?></td>
    <td>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="id_categoria" value="<?php echo $categoria['ID_Categoria']; ?>">
            <input type="text" name="nombre" placeholder="Nuevo nombre" required>
            <button type="submit" name="edit_category" class="btn btn-edit">Editar</button>
        </form>
        <a href="?delete=<?php echo $categoria['ID_Categoria']; ?>" class="btn btn-delete">Eliminar</a>
    </td>
</tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col">
            <?php include_once 'aplicacion_pie.php'; ?>
        </div>
    </div>
</body>
</html>