<?php
// Incluir el archivo de conexión
include('conexion.php');

// Consulta de ingresos totales por día
$queryIngresos = "
    SELECT DATE(p.Fecha) AS fecha, SUM(lp.precio) AS ingresos
    FROM pedidos p
    JOIN lineas_pedido lp ON p.ID_Pedido = lp.ID_pedido
    GROUP BY DATE(p.Fecha)
    ORDER BY fecha DESC
";
$resultadoIngresos = mysqli_query($conn, $queryIngresos);

// Consulta de número total de pedidos por día
$queryPedidos = "
    SELECT DATE(Fecha) AS fecha, COUNT(ID_Pedido) AS total_pedidos
    FROM pedidos
    GROUP BY DATE(Fecha)
    ORDER BY fecha DESC
";
$resultadoPedidos = mysqli_query($conn, $queryPedidos);

// Consulta de número total de comensales por día
$queryComensales = "
    SELECT DATE(p.Fecha) AS fecha, 
           SUM(m.Numero_comensales) AS total_comensales 
    FROM mesas m
    JOIN pedidos p ON m.Numero_mesa = p.Numeromesa
    WHERE m.Estado IN ('ocupada', 'pagada')  -- Solo mesas ocupadas o pagadas
    GROUP BY DATE(p.Fecha)
    ORDER BY fecha DESC";


$resultadoComensales = mysqli_query($conn, $queryComensales);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Rendimiento del Restaurante</title>
    <style>
           /* Estilo general */
           body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #4CAF50;
        }

        /* Estilo para las tablas */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            padding: 12px 18px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Informe de Rendimiento del Restaurante</h1>

    <!-- Tabla de ingresos -->
    <h2>Ingresos Totales por Día</h2>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Ingresos</th>
        </tr>
        <?php while ($fila = mysqli_fetch_assoc($resultadoIngresos)) { ?>
            <tr>
                <td><?php echo $fila['fecha']; ?></td>
                <td><?php echo number_format($fila['ingresos'], 2); ?> €</td>
            </tr>
        <?php } ?>
    </table>

    <!-- Tabla de pedidos -->
    <h2>Total de Pedidos por Día</h2>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Total de Pedidos</th>
        </tr>
        <?php while ($fila = mysqli_fetch_assoc($resultadoPedidos)) { ?>
            <tr>
                <td><?php echo $fila['fecha']; ?></td>
                <td><?php echo $fila['total_pedidos']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <!-- Tabla de comensales -->
    <h2>Total de Comensales por Día</h2>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Total de Comensales</th>
        </tr>
        <?php while ($fila = mysqli_fetch_assoc($resultadoComensales)) { ?> 
            <tr>
                <td><?php echo $fila['fecha']; ?></td>
                <td><?php echo $fila['total_comensales']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <p><a href="Encargado.php">Volver al Menú</a></p>  
</body>
</html>
