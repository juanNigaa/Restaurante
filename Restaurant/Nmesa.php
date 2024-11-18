<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de Nueva Mesa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
            text-align: center;
        }

        .form-container input[type="number"],
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-container input[type="number"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-container p {
            font-size: 14px;
            color: #666666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Dar de Alta una Mesa</h2>
        <form action="ingresarMesa.php" method="POST">
            <input type="number" placeholder="Número de mesa" id="Nmesa" name="Nmesa">
            <input type="number" placeholder="ID del encargado" id="ID_encargado" name="ID_encargado" required>
            <input type="submit" value="Dar Alta">
        </form>
        <p>Por favor, asegúrese de llenar todos los campos correctamente.</p>
        <p><a href="Encargado.php">Volver al menu principal</p>
    </div>
</body>
</html>
