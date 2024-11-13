<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No eres Bienvenido</title>
    <style>
       
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            background-color: #f8f8f8; 
        }

        
        img {
            width: 600px; 
            max-width: 80%; 
            height: auto; 
            margin-bottom: 20px; 
        }

        
        p {
            margin: 5px 0;
            color: #333;
            font-size: 1.1em;
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
    <img src="Imagenes/error.gif" alt="Error">
    <p>Nombre de usuario o contraseña incorrectos, inténtalo de nuevo.</p>
    <p>Recuerda tener en cuenta las mayúsculas y las minúsculas.</p>
    <p><a href="Loggin.php">Volver al inicio</a></p>
</body>
</html>
