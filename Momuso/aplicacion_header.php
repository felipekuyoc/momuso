<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Verifica si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header("Location: aplicacion_iniciosesion.php");
    exit();
}

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; // Verifica si el usuario es administrador



// Lógica para cerrar sesión
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: aplicacion_iniciosesion.php");
    exit();
}
?>
<div class="header">
        <img src="Imagenes/Logopapeleria.png" alt="Logo Papelería">
        <div class="search-bar">
            <input type="text" placeholder="Buscar productos de papelería...">
            <button><img src="Imagenes/busqueda.png" alt="Buscar"></button>
        </div>
        <div class="top-bar">
            <p>Mi Cuenta</p>
            <img src="Imagenes/Personal.png" alt="Mi Cuenta">
            <img src="Imagenes/Favorito.png" alt="Favoritos">
            <img src="Imagenes/cesta.png" alt="Carrito de Compras">
            <img src="Imagenes/cerrar.png" id="" alt="Cerrar Sesion" onclick="window.location.href='aplicacion_header.php?action=logout';" style="cursor: pointer;">
            <h1></h1>
            <h1></h1>
            <h1></h1>
        </div>
    </div>
<style>
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    background-color: #ffffff;
    position: fixed; /* Fija la posición del header */
    top: 0; /* Lo ubica en la parte superior */
    left: 0;
    width: 100%; /* Asegura que el header ocupe todo el ancho de la pantalla */
    z-index: 1000; /* Asegura que esté por encima de otros elementos */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Añade una sombra para distinguirlo del contenido al hacer scroll */
}

body {
    padding-top: 140px; /* Añade un margen superior para que el contenido no quede oculto detrás del header */
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
            background-color: #ec297b;
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
            width: 20px;
            height: 20px;
        }

        .header .top-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header .top-bar p {
            margin: 0;
            color: black;
            font-weight: bold;
        }

        .header .top-bar img {
            width: 25px;
            height: 25px;
        }
        </style>