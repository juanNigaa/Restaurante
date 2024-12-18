<?php
// Recibir el número de la mesa desde la URL
$numeroMesa = isset($_GET['mesa']) ? intval($_GET['mesa']) : 0;

if ($numeroMesa === 0) {
    echo "<p>Error: No se ha recibido un número de mesa válido.</p>";
    exit;
}

// Manejo de la sesión para líneas del pedido
session_start();
if (!isset($_SESSION['lineas_pedido'])) {
    $_SESSION['lineas_pedido'] = [];
}

// Cargar productos desde la base de datos
include("conexion.php");
$productosPorTipo = [];
$query = "SELECT ID_comida, comida, tipo, precio, imagen FROM productos";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productosPorTipo[$row['tipo']][] = $row; // Agrupamos productos por tipo
    }
} else {
    echo "<p>Error al cargar los productos: " . mysqli_error($conn) . "</p>";
}

// Limpiar pedidos si el botón 'limpiar' se ha pulsado
if (isset($_POST['limpiar_pedidos'])) {
    unset($_SESSION['lineas_pedido']);
}

// Agregar línea de pedido temporal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_comida'], $_POST['cantidad'], $_POST['precio'], $_POST['nombre'])) {
    $linea = [
        'ID_comida' => $_POST['ID_comida'],
        'cantidad' => $_POST['cantidad'],
        'precio' => $_POST['precio'],
        'nombre' => $_POST['nombre'], // Para mostrar en el listado
        'nota' => isset($_POST['nota']) ? $_POST['nota'] : '', // Capturamos la nota si existe
    ];
    $_SESSION['lineas_pedido'][] = $linea;
}

// Confirmar pedido completo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pedido'])) {
    $ID_usuario = intval($_POST['ID_usuario']);
    $lineas_pedido = $_SESSION['lineas_pedido'];

    if (!empty($lineas_pedido)) {
        // Crear el pedido en la tabla `pedidos` (sin ID_comida), ahora con el estado 'pendiente'
        $sql_pedido = "INSERT INTO pedidos (Numeromesa, ID_usuario, fecha, Estado) 
                       VALUES ('$numeroMesa', '$ID_usuario', NOW(), 'pendiente')";
        if (mysqli_query($conn, $sql_pedido)) {
            $ID_pedido = mysqli_insert_id($conn); // Obtener el ID del pedido recién creado

            // Insertar las líneas del pedido en la tabla `lineas_pedido`
            foreach ($lineas_pedido as $linea) {
                // Validar que el producto existe antes de insertar
                $check_producto = mysqli_query($conn, "SELECT 1 FROM productos WHERE ID_comida = '{$linea['ID_comida']}'");
                if (mysqli_num_rows($check_producto) > 0) {
                    $sql_linea = "INSERT INTO lineas_pedido (ID_pedido, ID_comida, cantidad, precio, nota) 
                                  VALUES ('$ID_pedido', '{$linea['ID_comida']}', '{$linea['cantidad']}', '{$linea['precio']}', '{$linea['nota']}')";
                    if (!mysqli_query($conn, $sql_linea)) {
                        echo "<p>Error al guardar la línea de pedido: " . mysqli_error($conn) . "</p>";
                        exit;
                    }
                } else {
                    echo "<p>Error: Producto con ID {$linea['ID_comida']} no existe.</p>";
                    exit;
                }
            }

            echo "<p>Pedido confirmado exitosamente.</p>";
        } else {
            echo "<p>Error al guardar el pedido: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>No hay productos en el pedido.</p>";
    }

    // Limpiar las líneas de pedido después de confirmar
    unset($_SESSION['lineas_pedido']);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresar Pedido</title>
    <script type="text/javascript" src="js/qz-tray.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qz-tray/2.1.0/qz-tray.js"></script>
    <style>
        /* Estilo básico para el formulario */
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
        select,
        textarea {
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

        .preview {
            margin-top: 15px;
        }

        .preview img {
            max-width: 100%;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        img {
            width: 200px; /* Establecer un tamaño fijo para el ancho */
            height: 200px; /* Establecer un tamaño fijo para la altura */
            object-fit: cover; /* Asegura que la imagen mantenga la proporción sin distorsionarse */
        }
    </style>
</head>
<body>
<section>
    <h2>Pedido para la Mesa <?= htmlspecialchars($numeroMesa) ?></h2>

    <form method="POST">
        <!-- Selector de Tipo de Producto -->
        <label for="tipo_producto">Selecciona Tipo de Producto:</label>
        <select id="tipo_producto" name="tipo_producto" onchange="this.form.submit()" required>
            <option value="">--Seleccionar--</option>
            <?php foreach (array_keys($productosPorTipo) as $tipo): ?>
                <option value="<?= htmlspecialchars($tipo) ?>" 
                    <?= (isset($_POST['tipo_producto']) && $_POST['tipo_producto'] === $tipo) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tipo) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (isset($_POST['tipo_producto']) && !empty($_POST['tipo_producto'])): ?>
        <?php $tipoSeleccionado = $_POST['tipo_producto']; ?>

        <form method="POST">
            <input type="hidden" name="tipo_producto" value="<?= htmlspecialchars($tipoSeleccionado) ?>">
            <!-- Selector de Producto -->
            <label for="ID_comida">Selecciona Producto:</label>
            <select id="ID_comida" name="ID_comida" required>
                <option value="">--Seleccionar--</option>
                <?php foreach ($productosPorTipo[$tipoSeleccionado] as $producto): ?>
                    <option value="<?= $producto['ID_comida'] ?>" 
                            data-precio="<?= $producto['precio'] ?>" 
                            data-nombre="<?= htmlspecialchars($producto['comida']) ?>" 
                            data-imagen="<?= htmlspecialchars($producto['imagen']) ?>">
                        <?= htmlspecialchars($producto['comida']) ?> - $<?= $producto['precio'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            
            <div class="preview" id="preview">
                <p>Selecciona un producto para ver su imagen.</p>
            </div>

            
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" required>

            
            <label for="nota">Notas:</label>
            <input type="text" id="nota" name="nota" placeholder="Ejemplo: Cocacola con hielo">

            
            <input type="hidden" id="precio" name="precio">
            <input type="hidden" id="nombre" name="nombre">

           
            <input type="submit" value="Agregar Producto">
        </form>
    <?php endif; ?>

    <h3>Productos en el Pedido</h3>
    <?php if (!empty($_SESSION['lineas_pedido'])): ?>
        <ul>
            <?php foreach ($_SESSION['lineas_pedido'] as $linea): ?>
                <li><?= $linea['cantidad'] ?>x <?= htmlspecialchars($linea['nombre']) ?> - $<?= $linea['precio'] ?>
                    <?php if (!empty($linea['nota'])): ?>
                        <br><small><strong>Nota:</strong> <?= htmlspecialchars($linea['nota']) ?></small>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <form method="POST">
            <input type="number" name="ID_usuario" placeholder="ID Usuario" required>
            <input type="submit" name="confirmar_pedido" value="Confirmar Pedido">
            <input type="submit" name="limpiar_pedidos" value="Limpiar Pedido">
            
        </form>
        <button id="printButton">Imprimir Ticket</button>
    <?php else: ?>
        <p>No hay productos en el pedido.</p>
    <?php endif; ?>
</section>

<script>
    document.getElementById('ID_comida').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('precio').value = selectedOption.getAttribute('data-precio');
        document.getElementById('nombre').value = selectedOption.getAttribute('data-nombre');
        var imageUrl = selectedOption.getAttribute('data-imagen');
        var preview = document.getElementById('preview');
        preview.innerHTML = `<img src="${imageUrl}" alt="Vista previa">`;
    });
    const PRINTER_NAME = "RP-10N"; // Cambia esto por el nombre exacto de tu impresora

// Conectar a QZ Tray
async function connectToQZTray() {
    try {
        await qz.websocket.connect(); // Conecta QZ Tray
        console.log("Conectado a QZ Tray.");
    } catch (err) {
        console.error("Error al conectar QZ Tray:", err);
    }
}

// Configuración de la impresora
async function getPrinterConfig() {
    try {
        const config = qz.configs.create(PRINTER_NAME); // Usa la constante PRINTER_NAME
        console.log("Configuración de impresora creada:", config);
        return config;
    } catch (err) {
        console.error("Error al configurar la impresora:", err);
    }
}

// Función para imprimir el ticket con los pedidos del formulario
async function imprimirTicket() {
    try {
        const config = await getPrinterConfig(); // Configurar la impresora

        // Obtener las líneas de pedido desde PHP (almacenadas en $_SESSION['lineas_pedido'])
        var lineasPedido = <?= json_encode($_SESSION['lineas_pedido']) ?>;

        if (lineasPedido.length === 0) {
            alert("No hay productos en el pedido para imprimir.");
            return;
        }

        // Generar el contenido del ticket
        var ticket = "Ticket de Pedido\n";
        ticket += "Mesa: <?= htmlspecialchars($numeroMesa) ?>\n\n";
        lineasPedido.forEach(function(linea) {
            ticket += `${linea.cantidad}x ${linea.nombre}\n`;
            if (linea.nota) {
                ticket += `Nota: ${linea.nota}\n`;
            }
        });
        ticket += "\n\n";
        ticket += "\n\n\n";  // Esto agrega espacio adicional

        // Comando ESC/POS para cortar el papel
        var cortarPapel = '\x1D\x56\x00';  // Comando para cortar el papel

        // Preparar los datos en formato de texto plano para la impresora
        const data = [
            { type: 'raw', format: 'plain', data: ticket + cortarPapel }  // Agregar el comando de corte al final
        ];

        // Imprimir el ticket
        await qz.print(config, data);
        console.log("Ticket enviado a la impresora.");
    } catch (err) {
        console.error("Error al imprimir el ticket:", err);
    }
}

// Conectar a QZ Tray al cargar la página
connectToQZTray();

// Asociar evento al botón para imprimir
document.getElementById('printButton').addEventListener('click', imprimirTicket);
    
</script>
<p><a href="mesas.php">Volver a las mesas</a></p>

</body>
</html>
