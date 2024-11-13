<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos de la Mesa</title>
</head>
<body>

<h1><u> Pedidos de la Mesa <?php echo htmlspecialchars($_POST['mesa']); ?></u></h1>

<?php
include("conexion.php");

if (isset($_POST['mesa'])) {
    // Recupera el número de mesa desde el formulario (POST)
    $numeroMesa = intval($_POST['mesa']);  // Convertir a un número entero para evitar inyecciones SQL

    // Consulta para obtener los pedidos de la mesa seleccionada
    $consulta = "SELECT * FROM pedidos WHERE Numeromesa = $numeroMesa";
    $result = mysqli_query($conn, $consulta);

    // Mostrar los errores de la consulta, si los hay
    echo mysqli_error($conn);

    // Mostrar los pedidos
    if (mysqli_num_rows($result) > 0) {
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

    // Cerrar la conexión con la base de datos
    mysqli_close($conn);
} else {
    echo "<p>No se ha seleccionado ninguna mesa.</p>";
}

?>

<p><a href="mesas.php">Volver a las mesas</a></p>

</body>
</html>
