<?php
include 'db_connection.php'; // Incluye tu archivo de conexión

// Manejo de acciones: Agregar, Editar y Eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        $nombre = $_POST['Nombre_Oferta'];
        $descuento = $_POST['Porcentaje_Descuento'];
        $fecha_inicio = $_POST['Fecha_Inicio'];
        $fecha_fin = $_POST['Fecha_Finalizacion'];

        $query = "INSERT INTO ofertasydescuentos (Nombre_Oferta, Porcentaje_Descuento, Fecha_Inicio, Fecha_Finalizacion) 
                  VALUES ('$nombre', $descuento, '$fecha_inicio', '$fecha_fin')";
        if ($conn->query($query) === TRUE) {
            header('Location: Ofertas.php');
            exit;
        } else {
            echo "Error al agregar oferta: " . $conn->error;
        }
    }

    if (isset($_POST['editar'])) {
        $id_oferta = $_POST['ID_Oferta'];
        $nombre = $_POST['Nombre_Oferta'];
        $descuento = $_POST['Porcentaje_Descuento'];
        $fecha_inicio = $_POST['Fecha_Inicio'];
        $fecha_fin = $_POST['Fecha_Finalizacion'];

        $query = "UPDATE ofertasydescuentos 
                  SET Nombre_Oferta = '$nombre', Porcentaje_Descuento = $descuento, Fecha_Inicio = '$fecha_inicio', Fecha_Finalizacion = '$fecha_fin' 
                  WHERE ID_Oferta = $id_oferta";

        if ($conn->query($query) === TRUE) {
            header('Location: Ofertas.php');
            exit;
        } else {
            echo "Error al editar oferta: " . $conn->error;
        }
    }
}

if (isset($_GET['eliminar'])) {
    $id_oferta = $_GET['eliminar'];

    $query = "DELETE FROM ofertasydescuentos WHERE ID_Oferta = $id_oferta";

    if ($conn->query($query) === TRUE) {
        header('Location: Ofertas.php');
        exit;
    } else {
        echo "Error al eliminar oferta: " . $conn->error;
    }
}

$query = "SELECT ID_Oferta, Nombre_Oferta, Porcentaje_Descuento, Fecha_Inicio, Fecha_Finalizacion FROM ofertasydescuentos";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas y Descuentos</title>
    <style>
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
        /* Página de edición de ofertas */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }
        h1 {
            text-align: center;
            color: #fe0066;
        }
        .descuentos-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px;
        }
        .descuento-card {
            border: 2px solid #fe0066;
            border-radius: 10px;
            padding: 10px 20px;
            width: 200px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .descuento-card h2 {
            color: #fe0066;
            font-size: 18px;
        }
        .descuento-card .porcentaje {
            color: #fe0000;
            font-size: 24px;
            font-weight: bold;
        }
        .descuento-card .detalle {
            font-size: 14px;
            color: #666;
            text-decoration: line-through;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #fe0066;
            color: white;
        }
        .buttons {
            text-align: center;
            margin: 20px;
        }
        .buttons button, .action-buttons button {
            background-color: #fe0066;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .buttons button:hover, .action-buttons button:hover {
            background-color: #cc0055;
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
    <h1>Descuentos Exclusivos</h1>
    <div class="descuentos-container">
      <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='descuento-card'>
                        <h2>{$row['Nombre_Oferta']}</h2>
                        <p class='porcentaje'>{$row['Porcentaje_Descuento']}%</p>
                        <p class='detalle'>Válido desde {$row['Fecha_Inicio']} hasta {$row['Fecha_Finalizacion']}</p>
                      </div>";
            }
        } else {
            echo "<p>No hay descuentos disponibles en este momento.</p>";
        }
        ?>
    </div>


    <h1>Gestión de Ofertas</h1>

    <div class="buttons">
        <button onclick="document.getElementById('add-form').style.display='block';">Agregar Oferta</button>
    </div>

    <div id="add-form" style="display:none; text-align: center; margin: 20px;">
        <form method="POST">
            <input type="hidden" name="ID_Oferta" id="ID_Oferta">
            <label for="Nombre_Oferta">Nombre Oferta:</label>
            <input type="text" name="Nombre_Oferta" id="Nombre_Oferta" required><br><br>
            <label for="Porcentaje_Descuento">Porcentaje Descuento:</label>
            <input type="number" name="Porcentaje_Descuento" id="Porcentaje_Descuento" required><br><br>
            <label for="Fecha_Inicio">Fecha Inicio:</label>
            <input type="date" name="Fecha_Inicio" id="Fecha_Inicio" required><br><br>
            <label for="Fecha_Finalizacion">Fecha Finalización:</label>
            <input type="date" name="Fecha_Finalizacion" id="Fecha_Finalizacion" required><br><br>
            <button type="submit" name="agregar" id="add-button">Guardar</button>
            <button type="submit" name="editar" id="edit-button" style="display:none;">Actualizar</button>
            <button type="button" onclick="document.getElementById('add-form').style.display='none';">Cancelar</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Oferta</th>
                <th>Nombre Oferta</th>
                <th>Porcentaje Descuento</th>
                <th>Fecha Inicio</th>
                <th>Fecha Finalización</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query($query); // Vuelve a ejecutar el query
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ID_Oferta']}</td>
                            <td>{$row['Nombre_Oferta']}</td>
                            <td>{$row['Porcentaje_Descuento']}%</td>
                            <td>{$row['Fecha_Inicio']}</td>
                            <td>{$row['Fecha_Finalizacion']}</td>
                            <td class='action-buttons'>
                                <button onclick=\"editarOferta(
                                    {$row['ID_Oferta']}, 
                                    '{$row['Nombre_Oferta']}', 
                                    {$row['Porcentaje_Descuento']}, 
                                    '{$row['Fecha_Inicio']}', 
                                    '{$row['Fecha_Finalizacion']}'
                                )\">Editar</button>
                                <button onclick=\"if(confirm('¿Estás seguro de eliminar esta oferta?')) location.href='Ofertas.php?eliminar={$row['ID_Oferta']}'\">Eliminar</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay ofertas disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function editarOferta(id, nombre, descuento, inicio, fin) {
            document.getElementById('add-form').style.display = 'block';
            document.getElementById('ID_Oferta').value = id;
            document.getElementById('Nombre_Oferta').value = nombre;
            document.getElementById('Porcentaje_Descuento').value = descuento;
            document.getElementById('Fecha_Inicio').value = inicio;
            document.getElementById('Fecha_Finalizacion').value = fin;
            document.getElementById('add-button').style.display = 'none';
            document.getElementById('edit-button').style.display = 'block';
        }
    </script>
</body>
</html>
