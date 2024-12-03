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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Momuso</title>
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

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .profile-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            color: #ff4081;
        }

        .profile-info {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        .logout-btn {
            background-color: #ff4081;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #e0356f;
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

    <!-- Banner -->
    <section class="banner">
        <img src="Momuso/ban.png" alt="Happy CHRISTMAS">
    </section>

    <div class="profile-container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h1>
        
        <div class="profile-info">
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
            <p><strong>Rol:</strong> <?php echo htmlspecialchars($rol); ?></p>
        </div>

    </div>

</body>
</html>