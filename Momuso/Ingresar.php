<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a Tienda Momuso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .container h1 {
            font-size: 24px;
            color: #ff4081; /* Rosa fuerte */
            margin-bottom: 10px;
        }

        .container p {
            font-size: 16px;
            color: #333333;
            margin-bottom: 20px;
        }

        .container button {
            background-color: #ff4081;
            color: white;
            border: none;
            padding: 15px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        .container button:hover {
            background-color: #e63971;
        }

        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenidos a Tienda Momuso</h1>
        <p>Gracias por visitar nuestra tienda. Haz clic en el botón para continuar.</p>
        <form action="InicioMomuso.php" method="get">
            <button type="submit">Ingresar</button>
        </form>
        <footer>
            <p>Propiedad de Felipe Kuyoc Cahuich y Katherine Sanchez Pacheco</p>
        </footer>
    </div>
</body>
</html>
