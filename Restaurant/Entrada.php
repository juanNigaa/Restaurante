<?php
include('Conexion.php'); 
session_start(); 

// Verificación de sesión para asegurar seguridad


// Datos del formulario 
$usuario = $_POST['Usuario'];
$contrasena = $_POST['Contrasena'];

// Validación en la base de datos
$validar = mysqli_query($conn, "SELECT * FROM usuarios WHERE Usuario='$usuario' AND Contrasena='$contrasena'");

if (mysqli_num_rows($validar) > 0) {
    $fila = mysqli_fetch_assoc($validar);  
    $_SESSION['usuario_id'] = $fila['ID_usuario'];
    $_SESSION['usuario_nombre'] = $fila['Nombre'];
    $_SESSION['usuario_rol'] = $fila['ID_rol']; 

    // Redirige según el rol del usuario
    if ($fila['ID_rol'] == 1) {
        header("Location: encargado.php"); 
    } elseif ($fila['ID_rol'] == 2) {
        header("Location: Mesas.php"); 
    } else {
        header("Location: usuario.php"); 
    }

    exit(); 
} else {
    header("Fail.php"); 
}
?>
