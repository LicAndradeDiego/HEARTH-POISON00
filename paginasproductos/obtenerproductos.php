<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "proyetocuba";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$sql = "SELECT 
            productos.codigo,
            productos.nombre,
            productos.precio,
            productos.descripcion,
            productos.stock,
            productos.costo
        FROM productos";

$resultado = $conn->query($sql);

$productos = array();

while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

echo json_encode($productos);

$conn->close();

?>