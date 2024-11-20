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

        .form-container {
            margin: 20px auto;
            padding: 20px;
            width: 300px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            font-size: 1.2em;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #0078d7;
            color: white;
            padding: 10px;
            width: 100%;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0053a4;
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
// Incluir la conexión a la base de datos
include("conexion.php");

if (isset($_POST['mesa'])) {
    // Recuperar el número de mesa desde el formulario (POST)
    $numeroMesa = intval($_POST['mesa']);  // Convertir a número entero para evitar inyecciones SQL

    // Consulta para obtener los pedidos y el número de comensales de la mesa seleccionada
    $consulta = "
        SELECT 
            p.ID_Pedido, 
            p.ID_usuario, 
            p.Numeromesa, 
            p.Fecha, 
            lp.Cantidad, 
            lp.precio, 
            pr.Comida
        FROM 
            pedidos p
        INNER JOIN 
            lineas_pedido lp ON p.ID_Pedido = lp.ID_Pedido
        INNER JOIN 
            productos pr ON lp.ID_comida = pr.ID_comida
        WHERE 
            p.Numeromesa = $numeroMesa";

    // Ejecutar la consulta
    $result = mysqli_query($conn, $consulta);

    // Verificar si hubo errores en la consulta
    if (!$result) {
        die("Error en la consulta SQL: " . mysqli_error($conn));
    }

    // Consulta para obtener el número de comensales de la mesa
    $consultaMesas = "SELECT Numero_comensales FROM mesas WHERE Numero_mesa = $numeroMesa";
    $resultMesas = mysqli_query($conn, $consultaMesas);
    $numeroComensales = 0;

    if ($resultMesas && mysqli_num_rows($resultMesas) > 0) {
        $rowMesa = mysqli_fetch_assoc($resultMesas);
        $numeroComensales = $rowMesa['Numero_comensales'];
    }

    // Mostrar formulario para cambiar número de comensales
    echo '<div class="form-container">';
    echo '<form action="" method="POST">';
    echo '<input type="hidden" name="mesa" value="' . $numeroMesa . '">';
    echo '<label for="comensales">Número de comensales:</label>';
    echo '<input type="number" name="comensales" value="' . $numeroComensales . '" min="1" required>';
    echo '<input type="submit" value="Actualizar Número de Comensales">';
    echo '</form>';
    echo '</div>';

    // Si se envió el formulario para actualizar el número de comensales
    if (isset($_POST['comensales'])) {
        $nuevoNumeroComensales = intval($_POST['comensales']);
        
        // Actualizar el número de comensales en la base de datos
        $updateQuery = "UPDATE mesas SET Numero_comensales = $nuevoNumeroComensales WHERE Numero_mesa = $numeroMesa";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<p><strong>El número de comensales se ha actualizado a " . htmlspecialchars($nuevoNumeroComensales) . ".</strong></p>";
            // Redirigir a la página de mesas.php después de actualizar
            header("Location: mesas.php");
            exit();
        } else {
            echo "<p>Error al actualizar el número de comensales.</p>";
        }
    }

    // Verificar si hay resultados en la tabla de pedidos
    if (mysqli_num_rows($result) > 0) {
        echo "<p><strong>Número de comensales: " . htmlspecialchars($numeroComensales) . "</strong></p>";

        // Mostrar los pedidos
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='pedido'>";
            echo "<strong>ID Pedido: </strong>" . htmlspecialchars($row['ID_Pedido']) . "<br>";
            echo "<strong>Comida: </strong>" . htmlspecialchars($row['Comida']) . "<br>";
            echo "<strong>Precio por unidad: </strong>" . number_format($row['precio'], 2) . " €<br>";
            echo "<strong>Cantidad: </strong>" . htmlspecialchars($row['Cantidad']) . "<br>";
            echo "<strong>Camarero: </strong>" . htmlspecialchars($row['ID_usuario']) . "<br>";
            echo "<strong>Número Mesa: </strong>" . htmlspecialchars($row['Numeromesa']) . "<br>";
            echo "<br>";
            echo "</div>";
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
