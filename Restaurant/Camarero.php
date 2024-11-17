<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos de la Mesa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #444;
            text-align: center;
            margin-bottom: 20px;
        }

        h1 u {
            text-decoration-color: #0078d7;
        }

        p {
            font-size: 1.1em;
        }

        .pedido {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pedido img {
            display: block;
            margin: 10px auto;
            border-radius: 8px;
        }

        .pedido strong {
            color: #0078d7;
        }

        .comensales {
            font-weight: bold;
            font-size: 1.2em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .boton {
            text-align: center;
            margin-top: 20px;
        }

        .boton a {
            text-decoration: none;
            background-color: #0078d7;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .boton a:hover {
            background-color: #0053a4;
        }

        .volver {
            margin-top: 30px;
            text-align: center;
        }

        .volver a {
            text-decoration: none;
            color: #0078d7;
            font-size: 1.1em;
        }

        .volver a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>
    <u>Pedidos de la Mesa 
    <?php echo htmlspecialchars($_POST['mesa']); ?>
    </u>
</h1>

<?php
include("conexion.php");

if (isset($_POST['mesa'])) {
    // Recupera el número de mesa desde el formulario (POST)
    $numeroMesa = intval($_POST['mesa']);  // Convertir a un número entero para evitar inyecciones SQL

    // Consulta para obtener los pedidos y el número de comensales de la mesa seleccionada
    $consulta = "
        SELECT 
            p.*, 
            m.Numero_comensales 
        FROM 
            pedidos p
        INNER JOIN 
            mesas m 
        ON 
            p.Numeromesa = m.Numero_mesa
        WHERE 
            p.Numeromesa = $numeroMesa";
    $result = mysqli_query($conn, $consulta);

    // Mostrar los errores de la consulta, si los hay
    if (!$result) {
        die("Error en la consulta SQL: " . mysqli_error($conn));
    }

    // Verificar si hay resultados
    if (mysqli_num_rows($result) > 0) {
        // Recuperar la primera fila para mostrar el número de comensales
        $primerPedido = mysqli_fetch_array($result);
        echo "<p><strong>Número de comensales: " . $primerPedido['Numero_comensales'] . "</strong></p>";

        // Volver a recorrer los resultados desde el inicio
        mysqli_data_seek($result, 0);

        // Mostrar los pedidos
        while ($row = mysqli_fetch_array($result)) {
            echo "<strong>ID_Pedido: " . $row['ID_Pedido'] . "</strong><br>";
            echo "Comida: " . $row['Comida'] . " <br>";
            echo "Precio: " . $row['Precio'] . " € <br>";
            echo "Cantidad: " . $row['Cantidad'] . " <br>";
            echo "<img width=250 height=250 src='" . $row['Imagen'] . "' alt='Imagen de comida'><br>";
            echo "Camarero: " . $row['ID_usuario'] . " <br>";
            echo "Numero Mesa: " . $row['Numeromesa'] . " <br>";
            echo "Notas extra: " . $row['Notas'] . " <br>";
            echo "<br>";
        }
    } else {
        echo "<p>No hay pedidos para esta mesa.</p>";
    }

    // Botón para agregar un nuevo pedido a esta mesa
    echo '<p><a href="IngresaPedido.php?mesa=' . $numeroMesa . '">Agregar un nuevo pedido a esta mesa</a></p>';

    // Cerrar la conexión con la base de datos
    mysqli_close($conn);
} else {
    echo "<p>No se ha seleccionado ninguna mesa.</p>";
}
?>

<p><a href="mesas.php">Volver a las mesas</a></p>

</body>
</html>
