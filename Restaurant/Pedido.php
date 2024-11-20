<?php
// Conexión a la base de datos
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_comida'], $_POST['cantidad'], $_POST['precio'], $_POST['ID_usuario'], $_POST['notas'], $_POST['Numero_mesa'])) {
    // Recibir datos del formulario
    $ID_comida = intval($_POST['ID_comida']);
    $cantidad = intval($_POST['cantidad']);
    $precio = floatval($_POST['precio']);
    $ID_usuario = intval($_POST['ID_usuario']);
    $notas = mysqli_real_escape_string($conn, $_POST['notas']);
    $Numero_mesa = intval($_POST['Numero_mesa']);
    
    // 1. Obtener el nombre de la comida desde la tabla productos
    $consulta_comida = "SELECT comida FROM productos WHERE ID_comida = $ID_comida";
    $result_comida = mysqli_query($conn, $consulta_comida);
    
    if ($result_comida && mysqli_num_rows($result_comida) > 0) {
        // 2. Si existe la comida, obtener el nombre
        $row_comida = mysqli_fetch_assoc($result_comida);
        $comida = $row_comida['comida'];

        // 3. Insertar el pedido en la tabla `pedidos` con ID_comida y el nombre de la comida
        $sql = "INSERT INTO pedidos (ID_comida, comida, cantidad, precio, ID_usuario, notas, Numeromesa)
                VALUES ('$ID_comida', '$comida', '$cantidad', '$precio', '$ID_usuario', '$notas', '$Numero_mesa')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Pedido insertado correctamente para la comida ID: $ID_comida ($comida)<br>";
        } else {
            echo "Error al insertar el pedido: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "No se encontró la comida con ID: $ID_comida<br>";
    }

    // Limpiar la sesión después de confirmar los pedidos
    session_start();
    unset($_SESSION['lineas_pedido']);  // Si deseas limpiar la sesión de pedidos
} else {
    echo "Faltan datos necesarios para procesar el pedido.";
}

mysqli_close($conn);
?>

<!-- Botón o enlace para volver a las mesas -->
<p style="margin-top: 20px;">
    <a href="Mesas.php" style="text-decoration: none; color: #007bff; font-weight: bold;">Volver a las Mesas</a>
</p>
