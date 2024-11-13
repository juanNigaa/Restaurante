<?php
include('Conexion.php'); 
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$contraseña = $_POST['contra'];
$rol = $_POST['rol'];
$DNI=$_POST['DNI'];
$Foto=$_POST['Foto'];



$consulta = "INSERT INTO usuarios (Nombre, Usuario, Contrasena, ID_rol, DNI, Foto_DNI) VALUES ('$nombre', '$usuario', '$contraseña', '$rol','$DNI','$Foto')";

if (mysqli_query($conn, $consulta)) {

    header("Location: Loggin.php");
    exit(); 
} else {
    echo "Error: " . mysqli_error($conn);
}

// Cierra la conexión
mysqli_close($conn);
?>
