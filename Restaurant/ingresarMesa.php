<?php
include('Conexion.php'); 


$NumeroMesa = $_POST['Nmesa']; 
$ID_usuario = $_POST['ID_encargado']; 


if (!empty($NumeroMesa) && !empty($ID_usuario)) {
   a
    $consulta = "INSERT INTO mesas (Numero_mesa, Estado, Numero_comensales, ID_usuario) 
                 VALUES ('$NumeroMesa', 'Libre', 4, '$ID_usuario')";

    
    if (mysqli_query($conn, $consulta)) {
        header("Location: Encargado.php"); 
        exit();
    } else {
        echo "Error al insertar la mesa: " . mysqli_error($conn);
    }
} else {
    echo "Por favor, complete todos los campos requeridos.";
}


mysqli_close($conn);
?>
