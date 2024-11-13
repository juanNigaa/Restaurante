<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Menú</title>
    <style>
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
            height: 100vh;
            color: #333;
        }

        section {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            text-align: center;
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
        }

        p {
            margin: 15px 0;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</head>
<body>
<section>
        <h1>Menú Administrador</h1>
        <p><a href="Eliminacion.php">Eliminar Usuario</a></p>
        <p><a href="Registrar.php">Registrar Usuario</a></p>
        <p><a href="trabajadores.php">Ver Trabajadores</a></p>
        <p><a href="Loggin.php">Volver al Login</a></p>
</section>
</body>
</html>
