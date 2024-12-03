<?php
// Incluir la conexión a la base de datos
include 'db_connection.php';

session_start();

// Verificar si el rol del usuario está definido en la sesión
if (!isset($_SESSION['Rol'])) {
    // Si no hay rol, redirigir al login
    header("Location: login.php");
    exit();
}

// Obtener el rol almacenado en la sesión y normalizar
$rol = strtolower(trim($_SESSION['Rol'])); // Convertir a minúsculas y eliminar espacios extra

// Validar y mostrar el mensaje según el rol
switch ($rol) {
    case 'invitado':
        echo "Bienvenido, invitado!";
        break;
    case 'cliente':
        echo "Bienvenido, cliente!";
        break;
    case 'administrador':
        echo "Bienvenido, administrador!";
        break;
    default:
        echo "Rol desconocido.";
        break;
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
    <title>Momuso</title>
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
            color: black;
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
            <a href="perfil.php">
                <button class="img-button">
                    <img src="Momuso/Personal.png" alt="Tienda Virtual">
                </button>
            </a>
            <a href="Carrito.php">
                <button class="img-button">
                    <img src="Momuso/Cestas.png" alt="Mi Cuenta">
                </button>
            </a>
            <a href="Reseñas.php">
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
        <a href="Momuso.php">Inicio</a>
        <a href="Producto.php">Producto</a>
        <a href="Categoria.php">Categorías</a>
        <a href="Ofertas.php">Ofertas y Descuentos</a>
    </div>

    <!-- Banner -->
    <section class="banner">
        <img src="Momuso/ban.png" alt="Happy CHRISTMAS">
    </section>

    <!-- Productos destacados -->
    <div class="products-section">
        <div class="product">
            <img src="Momuso/descarga (2).jpeg" alt="Recoger en Tienda">
            <p>Recoger en Tienda</p>
            <button>Ver más</button>
        </div>
        <div class="product">
            <img src="Momuso/descarga (3).jpeg" alt="Lo Nuevo">
            <p>Lo Nuevo</p>
            <button>Ver más</button>
        </div>
        <div class="product">
            <img src="Momuso/menos.jpeg" alt="Menos de $79">
            <p>Menos de $79</p>
            <button>Ver más</button>
        </div>
        <div class="product">
            <img src="Momuso/ropainvierno.jpg" alt="Colección Destacada">
            <p>Colección Ropa Invierno</p>
            <button>Ver más</button>
        </div>
        <div class="product">
            <img src="Momuso/virtual.jpg" alt="Tienda Virtual">
            <p>Tienda Virtual</p>
            <button>Ver más</button>
        </div>
        <div class="product">
            <img src="Momuso/Disfraz.jpeg" alt="Productos de Temporada">
            <p>Productos de Temporada</p>
            <button>Ver más</button>
        </div>
    </div>

    <!-- Anuncio -->
    <div class="announcement">
        <h3>¡APERTURA EXCLUSIVA DE NUESTRA LÍNEA DE LENCERÍA SENSUAL!</h3>
        <p>Te invitamos a descubrir nuestra nueva colección de lencería sensual diseñada para hacerte sentir increíble.</p>
        <p>Fecha de apertura: 19 de diciembre de 2024</p>
        <p>¡Te esperamos en Momuso para vivir una experiencia única de moda y sensualidad!</p>
    </div>

    <!-- Sección de categorías -->
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
    <div class="row">
                <div class="col">
                  <?php include_once 'aplicacion_pie.php'; ?>
                </div>
            </div>
        </div>
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
