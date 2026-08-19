<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "proyetocuba";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$codigo = $_POST["codigo"];
$idpedido = $_POST["idpedido"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];
$total = $precio * $cantidad;

$sql = "INSERT INTO carrito (productos_codigo, pedidos_id, cantidad, costototal) 
        VALUES ('$codigo', '$idpedido', '$cantidad', '$total')
        ON DUPLICATE KEY UPDATE 
            cantidad = cantidad + VALUES(cantidad),
            costototal = costototal + VALUES(costototal)";

if($conn->query($sql)){
    header("Location: miCarrito.php?idPedido=" . $idpedido);
    exit();
} else {
    echo "Error crítico en el proceso del carrito de compras: " . $conn->error;
}

$conn->close();
?>