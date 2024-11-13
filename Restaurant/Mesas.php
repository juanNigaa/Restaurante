<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas</title>
</head>
<body>

<h1>Selecciona una Mesa</h1>

<!-- Formulario para la Mesa 1 -->
 <h2>Mesa1</h2>
<form action="Camarero.php" method="POST">
    <input type="hidden" name="mesa" value="1">
    <button type="submit">
        <img src="Imagenes/mesa.jpg" id="mesa1" alt="Mesa 1">
    </button>
</form>
<h2>Mesa2</h2>
<!-- Formulario para la Mesa 2 -->
<form action="Camarero.php" method="POST">
    <input type="hidden" name="mesa" value="2">
    <button type="submit">
        <img src="Imagenes/mesa.jpg" id="mesa2" alt="Mesa 2">
    </button>
</form>
<h2>Mesa3</h2>
<!-- Formulario para la Mesa 3 -->
<form action="Camarero.php" method="POST">
    <input type="hidden" name="mesa" value="3">
    <button type="submit">
        <img src="Imagenes/mesa.jpg" id="mesa3" alt="Mesa 3">
    </button>
</form>
<h2>Mesa4</h2>
<!-- Formulario para la Mesa 4 -->
<form action="Camarero.php" method="POST">
    <input type="hidden" name="mesa" value="4">
    <button type="submit">
        <img src="Imagenes/mesa.jpg" id="mesa4" alt="Mesa 4">
    </button>
</form>
<p><a href="Loggin.php">Volver al loggin</a> </p>  
</body>
</html>
