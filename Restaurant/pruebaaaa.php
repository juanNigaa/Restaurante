<?php

include("conexion.php");

$numeroMesa = $_POST['mesa'];

try {
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
        p.Numeromesa = $numeroMesa AND p.Estado = 'pendiente'";

    $resultCuenta = mysqli_query($conn, $consultaCuenta);

    require('./vendor/autoload.php');

    // Configuración de mPDF para impresora térmica de 80 mm
    $mpdf = new \Mpdf\Mpdf([
        'format' => [72, 297], // 72 mm de ancho
        'margin_left' => 0,
        'margin_right' => 0,
        'margin_top' => 0,
        'margin_bottom' => 0,
    ]);

    $html = "
    <style>
       <style>
    body { 
        font-size: 12px;
        font-family: Arial, sans-serif;
        width: 72mm;
    }
    .header {
        text-align: center; /* Centrar el texto */
        font-size: 16px; /* Tamaño de la fuente del encabezado */
        font-weight: bold; /* Texto en negrita */
        margin-bottom: 10px; /* Espacio debajo del encabezado */
    }
    h1 {
        font-size: 14px;
        text-align: center;
        margin-bottom: 10px; /* Espacio debajo del título */
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
        text-align: left;
        font-size: 12px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>

<body>
    <div class='header'>Restaurante Juan Andrés</div>
    <h1>Cuenta de la Mesa $numeroMesa</h1>
    <table>
        <thead>
            <tr>
                <th>Comida</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
";

    $totalCuenta = 0;

    while ($row = mysqli_fetch_assoc($resultCuenta)) {
        $totalLinea = $row['Cantidad'] * $row['precio'];
        $totalCuenta += $totalLinea;
        $html .= "
            <tr>
                <td>" . htmlspecialchars($row['Comida']) . "</td>
                <td>" . htmlspecialchars($row['Cantidad']) . "</td>
                <td>" . number_format($row['precio'], 2) . " €</td>
                <td>" . number_format($totalLinea, 2) . " €</td>
            </tr>
        ";
    }

    $html .= "
            </tbody>
        </table>
        <h3>Total: " . number_format($totalCuenta, 2) . " €</h3>
    </body>";

    $mpdf->WriteHTML($html);
    $mpdf->Output("Cuenta_Mesa_$numeroMesa.pdf", "I");

} catch (\Throwable $th) {
    echo "Error -> ".$th;
}

?>
