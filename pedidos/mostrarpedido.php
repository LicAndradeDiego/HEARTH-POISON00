<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if($conexion->connect_error){
    die("Conexion fallida: ".$conexion->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT * FROM pedidos WHERE id='$id'";

$resultado = $conexion->query($sql);

$sqlTotal = "SELECT SUM(CostoTotal) AS total FROM carrito WHERE pedidos_id='$id'";
$resultadoTotal = $conexion->query($sqlTotal);
$res = $resultadoTotal->fetch_assoc();
$total = $res['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pedido</title>



</head>
<body>
<?php include '../header.php'; ?>
<div class="contenedor">

<h1>Información del Pedido</h1>

<div class="info">

<?php
if($resultado->num_rows > 0){

    while($fila = $resultado->fetch_assoc()){

        echo "<p><span>id:</span> ".$fila['id']."</p>";
        echo "<p><span>Nombre:</span> ".$fila['nombre']."</p>";
        echo "<p><span>Fecha:</span> ".$fila['fecha']."</p>";
        echo "<p><span>Estado:</span> ".$fila['estado']."</p>";
        echo "<p><span>Nombre del Vendedor:</span> ".$fila['nombre_vendedor']."</p>";

    }

}else{
    echo "<p>No se encontró el pedido.</p>";
}
?>

</div>

<a class="boton" href="leerpedido.php">Volver a Pedidos</a>

</div>

</body>
</html>

