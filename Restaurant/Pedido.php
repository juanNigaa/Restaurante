<?php
include('Conexion.php'); 
$Comida = $_POST['nombre'];
$Precio = $_POST['usuario'];
$Cantidad = $_POST['contra'];
$Imagen = $_POST['rol'];
$Camarero=$_POST['DNI'];
$Numeromesa=$_POST['Foto'];



$consulta = "INSERT INTO pedidos (ID_Pedido, ID_comida, Precio, Cantidad, Imagen, ID_usuario,Numeromesa,Notas) VALUES ('$nombre', '$usuario', '$contraseña', '$rol','$DNI','$Foto')";

if (mysqli_query($conn, $consulta)) {

    header("Location: Loggin.php");
    exit(); 
} else {
    echo "Error: " . mysqli_error($conn);
}

// Cierra la conexión
mysqli_close($conn);
?>
