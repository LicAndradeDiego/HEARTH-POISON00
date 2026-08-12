<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if($conn->connect_error){
    die("Conexion fallida: ".$conn->connect_error);
}

$Nombre = $_POST['Nombre'];
$Fecha = $_POST['Fecha'];
$Estado = $_POST['Estado'];
$nombre_vendedor = $_POST['nombre_vendedor'];

$sql = "INSERT INTO pedidos
(nombre, fecha, estado, nombre_vendedor)
VALUES
('$Nombre','$Fecha','$Estado','$nombre_vendedor')";

if($conn->query($sql)){
    
    $idPedido = $conn->insert_id;
    
    header("Location: ../carrito/miCarrito.php?idPedido=".$idPedido);
    exit();

}else{
    echo "Error: ".$conn->error;
}

$conn->close();
?>