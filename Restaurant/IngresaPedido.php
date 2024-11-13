<?php
// Recibir el número de la mesa desde la URL
$numeroMesa = isset($_GET['mesa']) ? intval($_GET['mesa']) : 0;

if ($numeroMesa === 0) {
    echo "<p>Error: No se ha recibido un número de mesa válido.</p>";
    exit;
}

// Manejo de pedidos en sesión temporal
session_start();
if (!isset($_SESSION['pedidos'])) {
    $_SESSION['pedidos'] = [];
}

// Agregar pedido temporal al array de la sesión si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_comida'])) {
    $pedido = [
        'ID_comida' => $_POST['ID_comida'],
        'cantidad' => $_POST['cantidad'],
        'imagen' => $_FILES['imagen']['name'], // Solo el nombre del archivo
        'ID_usuario' => $_POST['ID_usuario'],
        'notas' => $_POST['notas'],
        'Numero_mesa' => $numeroMesa
    ];
    $_SESSION['pedidos'][] = $pedido;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Pedido</title>
    <style>
        /* Incluye tu CSS aquí */
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
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h2, h3 {
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

        .pedido-item {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f9fa;
            text-align: left;
        }
    </style>
</head>
<body>
<section>
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Realiza El Pedido para la Mesa <?= htmlspecialchars($numeroMesa) ?></h2>

        <select name="ID_comida" required>
            <option value="">Selecciona la comida</option>
            <?php
            include("conexion.php");
            $consulta_productos = "SELECT ID_comida, comida FROM productos";
            $result_productos = mysqli_query($conn, $consulta_productos);

            if (mysqli_num_rows($result_productos) > 0) {
                while ($row = mysqli_fetch_assoc($result_productos)) {
                    echo "<option value='" . $row['ID_comida'] . "'>" . $row['comida'] . "</option>";
                }
            }
            mysqli_close($conn);
            ?>
        </select>

        <input type="number" placeholder="Cantidad" name="cantidad" required>
        <input type="file" name="imagen" required>
        <input type="number" name="ID_usuario" placeholder="ID Usuario" required>
        <input type="text" name="notas" placeholder="Notas extra del cliente">
        <input type="hidden" name="Numero_mesa" value="<?= htmlspecialchars($numeroMesa) ?>">

        <input type="submit" value="Agregar Pedido">
    </form>

    <h3>Pedidos Pendientes</h3>
    <?php if (!empty($_SESSION['pedidos'])): ?>
        <?php foreach ($_SESSION['pedidos'] as $pedido): ?>
            <div class="pedido-item">
                <p><strong>Comida ID:</strong> <?= htmlspecialchars($pedido['ID_comida']) ?></p>
                <p><strong>Cantidad:</strong> <?= htmlspecialchars($pedido['cantidad']) ?></p>
                <p><strong>ID Usuario:</strong> <?= htmlspecialchars($pedido['ID_usuario']) ?></p>
                <p><strong>Notas:</strong> <?= htmlspecialchars($pedido['notas']) ?></p>
                <p><strong>Número de Mesa:</strong> <?= htmlspecialchars($pedido['Numero_mesa']) ?></p>
            </div>
        <?php endforeach; ?>
        <form action="Pedido.php" method="POST">
            <input type="hidden" name="pedidos" value='<?= json_encode($_SESSION['pedidos']) ?>'>
            <input type="submit" value="Confirmar Pedidos">
        </form>
    <?php else: ?>
        <p>No hay pedidos en espera.</p>
    <?php endif; ?>

    <p><a href="Camarero.php">Volver al Menú</a></p>  
</section>
</body>
</html>
