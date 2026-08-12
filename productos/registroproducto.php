<?php

$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if($conn->connect_error){
    die("Conexión fallida: " . $conn->connect_error);
}
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

$sql = "INSERT INTO productos (codigo, nombre, descripcion, precio, costo, stock)
        VALUES ('$codigo', '$nombre', '$descripcion', '$precio', '$costo', '$stock')";

if($conn->query($sql) === TRUE){
    echo "<script>
            alert('Producto registrado correctamente');
            window.location='leerproducto.php';
          </script>";
} else {
    echo "Error al registrar producto: " . $conn->error;
}

$conn->close();

?>