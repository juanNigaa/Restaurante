<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #0078d7;
            margin-top: 20px;
            font-size: 2.5em;
        }

        h2 {
            text-align: center;
            color: #444;
            font-size: 1.5em;
            margin: 10px 0;
        }

        .mesas-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
            max-width: 800px;
        }

        .mesa-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 180px;
            padding: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .mesa-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .mesa-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .mesa-card button {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            width: 100%;
        }

        .volver {
            text-align: center;
            margin-top: 30px;
        }

        .volver a {
            text-decoration: none;
            color: #0078d7;
            font-size: 1.2em;
            transition: color 0.3s ease;
        }

        .volver a:hover {
            color: #0053a4;
        }
    </style>
</head>
<body>

<h1>Selecciona una Mesa</h1>

<div class="mesas-container">
    <!-- Formulario para la Mesa 1 -->
    <div class="mesa-card">
        <h2>Mesa 1</h2>
        <form action="Camarero.php" method="POST">
            <input type="hidden" name="mesa" value="1">
            <button type="submit">
                <img src="Imagenes/mesa.jpg" id="mesa1" alt="Mesa 1">
            </button>
        </form>
    </div>
    
    <!-- Formulario para la Mesa 2 -->
    <div class="mesa-card">
        <h2>Mesa 2</h2>
        <form action="Camarero.php" method="POST">
            <input type="hidden" name="mesa" value="2">
            <button type="submit">
                <img src="Imagenes/mesa.jpg" id="mesa2" alt="Mesa 2">
            </button>
        </form>
    </div>

    <!-- Formulario para la Mesa 3 -->
    <div class="mesa-card">
        <h2>Mesa 3</h2>
        <form action="Camarero.php" method="POST">
            <input type="hidden" name="mesa" value="3">
            <button type="submit">
                <img src="Imagenes/mesa.jpg" id="mesa3" alt="Mesa 3">
            </button>
        </form>
    </div>

    <!-- Formulario para la Mesa 4 -->
    <div class="mesa-card">
        <h2>Mesa 4</h2>
        <form action="Camarero.php" method="POST">
            <input type="hidden" name="mesa" value="4">
            <button type="submit">
                <img src="Imagenes/mesa.jpg" id="mesa4" alt="Mesa 4">
            </button>
        </form>
    </div>
</div>

<div class="volver">
    <p><a href="Loggin.php">Volver al loggin</a></p>
</div>

</body>
</html>
