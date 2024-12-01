<?php
include ("conexion.php");
$usuario = $_POST['Usuario'];
$consulta = "UPDATE usuarios SET Estado = 'Suspendido' WHERE ID_usuario = '$usuario'";
mysqli_query($conn, $consulta);
header("LOCATION:Encargado.php");
?>
