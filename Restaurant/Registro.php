<?php
include('Conexion.php'); 

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$contraseña = $_POST['contra'];
$rol = $_POST['rol'];
$DNI = $_POST['DNI'];
$Foto = ''; // Inicializamos vacío

// Procesar la imagen subida
if (isset($_FILES['Foto']) && $_FILES['Foto']['error'] == 0) {
    $directorioSubida = 'Imagenes/'; // Ruta relativa desde el directorio del proyecto
    $nombreArchivo = uniqid() . "_" . basename($_FILES['Foto']['name']); // Generar un nombre único
    $rutaCompleta = $directorioSubida . $nombreArchivo;

    // Verificar si el directorio existe, si no, crearlo
    if (!is_dir($directorioSubida)) {
        mkdir($directorioSubida, 0777, true);
    }

    // Mover el archivo a la carpeta destino
    if (move_uploaded_file($_FILES['Foto']['tmp_name'], $rutaCompleta)) {
        $Foto = $rutaCompleta; // Guardamos la ruta relativa en la base de datos
    } else {
        echo "Error al subir la imagen. Verifica los permisos de la carpeta.";
        exit();
    }
}

// Insertar datos en la base de datos
$consulta = "INSERT INTO usuarios (Nombre, Usuario, Contrasena, ID_rol, DNI, Foto_DNI,Estado) 
             VALUES ('$nombre', '$usuario', '$contraseña', '$rol', '$DNI', '$Foto','Activo')";

if (mysqli_query($conn, $consulta)) {
    // Redirigir a la página de inicio de sesión
    header("Location: Loggin.php");
    exit(); 
} else {
    // Mostrar error si ocurre
    echo "Error: " . mysqli_error($conn);
}

// Cerrar conexión
mysqli_close($conn);
?>
