<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffe6f0;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #ff80ab;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ffb3c6;
            text-align: left;
            padding: 10px;
        }
        th {
            background-color: #ffccd5;
            color: #000;
        }
        tr:nth-child(even) {
            background-color: #fff0f6;
        }
        button {
            background-color: #ff80ab;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff4d8a;
        }
        form {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            border: 1px solid #ffb3c6;
            border-radius: 5px;
            width: calc(33% - 10px);
        }
    </style>
</head>
<body>
<div class="row">
        <div class="col">
            <?php include_once 'Aplicacionestaticaadmin.php'; ?>
        </div>
    </div>
    <div class="container">
        <h1>Carrito de Compras</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Carrito</th>
                    <th>ID Usuario</th>
                    <th>ID Producto</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexión a la base de datos
                $conn = new mysqli("localhost", "root", "", "Momuso");
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                // Mostrar registros
                $sql = "SELECT * FROM CarritoDeCompras";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ID_Carrito']}</td>
                            <td>{$row['ID_Usuario']}</td>
                            <td>{$row['ID_Producto']}</td>
                            <td>{$row['Cantidad']}</td>
                            <td>
                                <form style='display:inline;' method='post'>
                                    <input type='hidden' name='id' value='{$row['ID_Carrito']}'>
                                    <button name='edit'>Editar</button>
                                    <button name='delete'>Borrar</button>
                                </form>
                            </td>
                          </tr>";
                }

                // Agregar registro
                if (isset($_POST['add'])) {
                    $id_usuario = $_POST['id_usuario'];
                    $id_producto = $_POST['id_producto'];
                    $cantidad = $_POST['cantidad'];
                    $sql = "INSERT INTO CarritoDeCompras (ID_Usuario, ID_Producto, Cantidad) VALUES ('$id_usuario', '$id_producto', '$cantidad')";
                    $conn->query($sql);
                    header("Refresh:0");
                }

                // Borrar registro
                if (isset($_POST['delete'])) {
                    $id = $_POST['id'];
                    $sql = "DELETE FROM CarritoDeCompras WHERE ID_Carrito = $id";
                    $conn->query($sql);
                    header("Refresh:0");
                }

                // Editar registro
                if (isset($_POST['edit'])) {
                    $id = $_POST['id'];
                    $sql = "SELECT * FROM CarritoDeCompras WHERE ID_Carrito = $id";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $id_usuario = $row['ID_Usuario'];
                    $id_producto = $row['ID_Producto'];
                    $cantidad = $row['Cantidad'];
                    echo "<form method='post' style='margin-top: 20px;'>
                            <h3>Editar Registro</h3>
                            <input type='hidden' name='id' value='$id'>
                            <input type='number' name='id_usuario' value='$id_usuario' required>
                            <input type='number' name='id_producto' value='$id_producto' required>
                            <input type='number' name='cantidad' value='$cantidad' required>
                            <button name='update'>Actualizar</button>
                          </form>";
                }

                // Actualizar registro
                if (isset($_POST['update'])) {
                    $id = $_POST['id'];
                    $id_usuario = $_POST['id_usuario'];
                    $id_producto = $_POST['id_producto'];
                    $cantidad = $_POST['cantidad'];
                    $sql = "UPDATE CarritoDeCompras SET ID_Usuario = '$id_usuario', ID_Producto = '$id_producto', Cantidad = '$cantidad' WHERE ID_Carrito = $id";
                    $conn->query($sql);
                    header("Refresh:0");
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <form method="post">
            <input type="number" name="id_usuario" placeholder="ID Usuario" required>
            <input type="number" name="id_producto" placeholder="ID Producto" required>
            <input type="number" name="cantidad" placeholder="Cantidad" required>
            <button name="add">Agregar</button>
        </form>
    </div>
    <div class="row">
        <div class="col">
            <?php include_once 'aplicacion_pie.php'; ?>
        </div>
    </div>
</body>
</html>
</body>
</html>
