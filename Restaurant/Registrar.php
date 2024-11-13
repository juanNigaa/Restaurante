<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        /* Centrado del contenido en la página */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        /* Estilo para la sección del formulario */
        section {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Estilo del título */
        h2 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
        }

        /* Estilo para los campos de entrada */
        input[type="text"],
        input[type="password"],
        select,
        input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        /* Estilo para el botón de envío */
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Estilo para el enlace */
        p {
            margin-top: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <section>
        <form action="Registro.php" method="POST">
            <h2>Registro</h2>
            <input type="text" placeholder="Nombre" id="nombre" name="nombre">
            <input type="text" placeholder="Usuario" id="usuario" name="usuario"> 
            <input type="password" placeholder="Contraseña" id="contra" name="contra"> 
            <select id="rol" name="rol">
                <option value="1">Encargado</option>
                <option value="2">Camarero</option>
            </select>
            <input type="text" name="DNI" placeholder="DNI">
            <input type="file" name="Foto">
            <input type="submit" value="Registrar">
        </form>
        <p><a href="Encargado.php">Volver al Menú</a></p>  
    </section>
</body>
</html>
