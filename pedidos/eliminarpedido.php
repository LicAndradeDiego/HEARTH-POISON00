<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if($conexion->connect_error){
    die("Conexión fallida: " . $conexion->connect_error);
}

$id = ($_GET['id']);

$conexion->query("DELETE FROM carrito WHERE pedidos_id=$id");

$sql = "DELETE FROM Pedidos WHERE id=$id";
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eliminar Pedido</title>



</head>
<body>

<?php include '../header.php'; ?>

<div class="contenedor">

<?php
if($conexion->query($sql) === TRUE){
    
    echo "<p>El pedido fue eliminado correctamente.</p>";
}else{
    
    echo "<p>No se pudo eliminar el pedido.</p>";
}
?>

<a class="boton" href="leerpedido.php">Volver a Pedidos</a>

</div>

</body>
</html>