<?php
// Conexión a la base de datos
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedidos'])) {
    $pedidos = json_decode($_POST['pedidos'], true);
    
    if (!empty($pedidos)) {
        foreach ($pedidos as $pedido) {
            // Validar y limpiar datos
            $ID_comida = intval($pedido['ID_comida']);
            $cantidad = intval($pedido['cantidad']);
            $precio = floatval($pedido['precio']);
            $ID_usuario = intval($pedido['ID_usuario']);
            $notas = mysqli_real_escape_string($conn, $pedido['notas']);
            $Numero_mesa = intval($pedido['Numero_mesa']);
            
            // Consulta para insertar el pedido
            $sql = "INSERT INTO pedidos (ID_comida, cantidad, precio, ID_usuario, notas, Numeromesa)
                    VALUES ('$ID_comida', '$cantidad', '$precio', '$ID_usuario', '$notas', '$Numero_mesa')";
            
            if (mysqli_query($conn, $sql)) {
                echo "Pedido insertado correctamente para la comida ID: $ID_comida<br>";
            } else {
                echo "Error al insertar el pedido: " . mysqli_error($conn) . "<br>";
            }
        }
        // Limpiar la sesión después de confirmar los pedidos
        session_start();
        unset($_SESSION['pedidos']);
    } else {
        echo "No se recibieron pedidos.";
    }
}
mysqli_close($conn);
?>

<!-- Botón o enlace para volver a las mesas -->
<p style="margin-top: 20px;">
    <a href="Mesas.php" style="text-decoration: none; color: #007bff; font-weight: bold;">Volver a las Mesas</a>
</p>
