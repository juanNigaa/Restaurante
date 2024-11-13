<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Pedido</title>
    <style>
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
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        input[type="submit"] {
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

        p a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<section>
        <form action="Pedido.php" method="POST">
            <h2>Registro de Pedido</h2>
            <input type="text" placeholder="Nombre" id="nombre" name="nombre" required>
            <input type="text" placeholder="ID Comida" id="usuario" name="usuario" required>
            <input type="number" placeholder="Precio" id="contra" name="contra" required>
            <input type="file" name="Comida" required>
            <input type="number" name="USUARIO" placeholder="Usuario ID" required>
            <input type="number" name="Mesa" placeholder="Número de Mesa" required>
            <input type="text" name="notas" placeholder="Notas extra del cliente">
            <input type="submit" value="Ingresar Pedido">
        </form>
        <p><a href="Camarero.php">Volver al Menú</a></p>  
    </section>
</body>
</html>
