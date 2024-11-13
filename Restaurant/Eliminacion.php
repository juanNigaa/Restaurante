<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrador</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
            color: #333;
        }

        section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            color: #007bff;
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #666;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 15px;
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
        <form action="Eliminar.php" method="POST">
            <h2>Eliminar camarero</h2>
            <label for="Usuario">ID Camarero:</label>
            <input type="number" placeholder="ID del camarero" name="Usuario" id="Usuario" maxlength="2" required>
            <input type="submit" value="Eliminar">
        </form>
    </section>
    <p><a href="Encargado.php">Volver al menú</a></p> 
</body>
</html>
