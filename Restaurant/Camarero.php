<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos de la Mesa</title>
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
    $numeroMesa = intval($_POST['mesa']);  // Número de mesa recibido por POST

    // Consulta para obtener pedidos pendientes de la mesa seleccionada
    $consulta = "
        SELECT 
            p.ID_Pedido, 
            p.ID_usuario, 
            p.Numeromesa, 
            p.Fecha, 
            lp.Cantidad, 
            lp.precio, 
            lp.nota, 
            pr.Comida,
            p.Estado
        FROM 
            pedidos p
        INNER JOIN 
            lineas_pedido lp ON p.ID_Pedido = lp.ID_Pedido
        INNER JOIN 
            productos pr ON lp.ID_comida = pr.ID_comida
        WHERE 
            p.Numeromesa = $numeroMesa AND p.Estado = 'pendiente'"; // Filtrar por estado pendiente

    $result = mysqli_query($conn, $consulta);

    if (!$result) {
        die("Error en la consulta SQL: " . mysqli_error($conn));
    }

    // Consulta para obtener el número de comensales
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

    if (isset($_POST['comensales'])) {
        $nuevoNumeroComensales = intval($_POST['comensales']);
        $updateQuery = "UPDATE mesas SET Numero_comensales = $nuevoNumeroComensales WHERE Numero_mesa = $numeroMesa";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<p><strong>El número de comensales se ha actualizado a " . htmlspecialchars($nuevoNumeroComensales) . ".</strong></p>";
            header("Location: mesas.php");
            exit();
        } else {
            echo "<p>Error al actualizar el número de comensales.</p>";
        }
    }

    // Mostrar pedidos pendientes
    if (mysqli_num_rows($result) > 0) {
        echo "<p><strong>Número de comensales: " . htmlspecialchars($numeroComensales) . "</strong></p>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='pedido'>";
            echo "<strong>ID Pedido: </strong>" . htmlspecialchars($row['ID_Pedido']) . "<br>";
            echo "<strong>Comida: </strong>" . htmlspecialchars($row['Comida']) . "<br>";
            echo "<strong>Precio por unidad: </strong>" . number_format($row['precio'], 2) . " €<br>";
            echo "<strong>Cantidad: </strong>" . htmlspecialchars($row['Cantidad']) . "<br>";
            echo "<strong>Camarero: </strong>" . htmlspecialchars($row['ID_usuario']) . "<br>";
            echo "<strong>Número Mesa: </strong>" . htmlspecialchars($row['Numeromesa']) . "<br>";
            if (!empty($row['nota'])) {
                echo "<strong>Nota: </strong>" . htmlspecialchars($row['nota']) . "<br>";
            }
            echo "<br>";
            echo "</div>";
        }

        // Formulario para generar el PDF de la cuenta
        echo '<form method="POST">';
        echo '<input type="hidden" name="mesa" value="' . $numeroMesa . '">';
        echo '<input type="submit" name="generar_pdf" value="Generar PDF de la Cuenta" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">';
        echo '</form>';

        // Botón para marcar la mesa como pagada
        echo '<form method="POST" action="">';
        echo '<input type="hidden" name="mesa" value="' . $numeroMesa . '">';
        echo '<input type="hidden" name="marcar_pagada" value="1">';
        echo '<input type="submit" value="Marcar Mesa como Pagada" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">';
        echo '</form>';

        // Enlace para ingresar nuevos pedidos
        echo '<p><a href="IngresaPedido.php?mesa=' . $numeroMesa . '">Agregar un nuevo pedido a esta mesa</a></p>';
    } else {
        echo "<p>No hay pedidos pendientes para esta mesa.</p>";
    }

    // Si se envió el formulario para generar el PDF de la cuenta
    if (isset($_POST['generar_pdf'])) {
        // Consulta para obtener los detalles de la cuenta
        $consultaCuenta = "
            SELECT 
                p.ID_Pedido, 
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
                p.Numeromesa = $numeroMesa AND p.Estado = 'pagado'"; // Aseguramos que solo se incluyan los pedidos pagados

        $resultCuenta = mysqli_query($conn, $consultaCuenta);
        
        require_once __DIR__ . '/vendor/autoload.php'; // Incluir el autoloader de Composer
        $mpdf = new \Mpdf\Mpdf();
        $html = "<h1>Cuenta de la Mesa $numeroMesa</h1><table><thead><tr><th>Comida</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr></thead><tbody>";
        $totalCuenta = 0;

        while ($row = mysqli_fetch_assoc($resultCuenta)) {
            $totalLinea = $row['Cantidad'] * $row['precio'];
            $totalCuenta += $totalLinea;
            $html .= "<tr>
                <td>" . htmlspecialchars($row['Comida']) . "</td>
                <td>" . htmlspecialchars($row['Cantidad']) . "</td>
                <td>" . number_format($row['precio'], 2) . " €</td>
                <td>" . number_format($totalLinea, 2) . " €</td>
            </tr>";
        }

        $html .= "</tbody></table>";
        $html .= "<h3>Total: " . number_format($totalCuenta, 2) . " €</h3>";

        // Generar el PDF
        $mpdf->WriteHTML($html);
        $mpdf->Output(); // Mostrar el PDF en el navegador
    }

    // Si se envió el formulario para marcar la mesa como pagada
    if (isset($_POST['marcar_pagada']) && intval($_POST['marcar_pagada']) === 1) {
        // Actualizar el estado de los pedidos a 'pagado'
        $updatePedidos = "UPDATE pedidos SET Estado = 'pagado' WHERE Numeromesa = $numeroMesa AND Estado = 'pendiente'";
        // Resetear el número de comensales a 0
        $resetComensales = "UPDATE mesas SET Numero_comensales = 0 WHERE Numero_mesa = $numeroMesa";

        if (mysqli_query($conn, $updatePedidos) && mysqli_query($conn, $resetComensales)) {
            echo "<p><strong>La mesa ha sido marcada como pagada. Los pedidos ya no se mostrarán y el número de comensales ha sido reiniciado.</strong></p>";
            header("Location: mesas.php");
            exit();
        } else {
            echo "<p>Error al marcar la mesa como pagada.</p>";
        }
    }

    mysqli_close($conn);
} else {
    echo "<p>No se ha seleccionado ninguna mesa.</p>";
}
?>

<p><a href="mesas.php">Volver a las mesas</a></p>
<p><a href="IngresaPedido.php?mesa=<?php echo $numeroMesa; ?>">Agregar un nuevo pedido a esta mesa</a></p>

</body>
</html>
