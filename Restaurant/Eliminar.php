
<?php
include ("conexion.php");
$usuario=$_POST['Usuario'];
$consulta = ("DELETE from usuarios WHERE ID_usuario='$usuario'");
mysqli_query($conn,$consulta);
header ("LOCATION:Encargado.php");
?>