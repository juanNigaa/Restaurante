<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Pedido</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #333;
        }

        section {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="number"],
        input[type="file"],
        input[type="submit"],
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<section>
    <?php
        // Conexión a la base de datos
        include("conexion.php");

        // Consulta para obtener los productos
        $consulta_productos = "SELECT ID_comida, comida, cantidad, precio FROM productos";
        $result_productos = mysqli_query($conn, $consulta_productos);

        // Variables iniciales
        $precio = $cantidad = "";
        $id_comida_seleccionada = "";
        if (isset($_POST['ID_comida'])) {
            // Si se seleccionó una comida, obtener el precio y otros detalles
            $id_comida_seleccionada = $_POST['ID_comida'];
            $consulta_detalle_comida = "SELECT precio FROM productos WHERE ID_comida = '$id_comida_seleccionada'";
            $resultado_detalle_comida = mysqli_query($conn, $consulta_detalle_comida);
            $comida = mysqli_fetch_assoc($resultado_detalle_comida);
            $precio = $comida['precio'];
        }
    ?>

    <form action="Pedido.php" method="POST" enctype="multipart/form-data">
        <h2>Realiza El Pedido</h2>

        <!-- Menú desplegable para seleccionar la comida -->
        <select name="ID_comida" id="ID_comida" required>
            <option value="">Selecciona la comida</option>
            <?php
                // Llenar el select con los productos de la base de datos
                if (mysqli_num_rows($result_productos) > 0) {
                    while ($row = mysqli_fetch_assoc($result_productos)) {
                        $selected = ($row['ID_comida'] == $id_comida_seleccionada) ? "selected" : "";
                        echo "<option value='" . $row['ID_comida'] . "' $selected>" . $row['comida'] . "</option>";
                    }
                }
            ?>
        </select>

        <!-- Mostrar el precio automáticamente si se seleccionó una comida -->
        <input type="number" id="precio" placeholder="Precio" name="precio" value="<?= htmlspecialchars($precio) ?>" readonly>

        <input type="number" placeholder="Cantidad" name="cantidad" required>

        <!-- Campo de imagen obligatorio -->
        <input type="file" name="imagen" required>

        <!-- Eliminar el campo de mesa, ya no se incluye aquí -->
        <!-- <select name="Numero_mesa" required> -->
        <!-- <option value="">Selecciona la mesa</option> -->
        <!-- ... código para mesas eliminado ... -->
        <!-- </select> -->

        <input type="number" name="ID_usuario" placeholder="ID Usuario" required>
        <input type="text" name="notas" placeholder="Notas extra del cliente">
        <input type="submit" value="Ingresar Pedido">
    </form>

    <p><a href="Camarero.php">Volver al Menú</a></p>  
</section>

</body>
</html>
