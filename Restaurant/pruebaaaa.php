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
            p.Numeromesa = $numeroMesa AND p.Estado = 'pagado'"; // Aseguramos que solo se incluyan los pedidos pagados

        $resultCuenta = mysqli_query($conn, $consultaCuenta);
        require('./vendor/autoload.php'); // Incluir el autoloader de Composer

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
        $mpdf->Output("Cuenta_Mesa_$numeroMesa.pdf", "I"); // Mostrar el PDF en el navegador
    } catch (\Throwable $th) {
        echo "Error -> ".$th;
    }

?>