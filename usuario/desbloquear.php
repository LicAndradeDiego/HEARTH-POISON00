<?php
include_once "validacion.php";

$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (isset($_GET['CI'])) {
    $CI = $_GET['CI'];
    
    // CORREGIDO: Tabla 'usuario' y columna 'estado'
    $stmt = $conexion->prepare("UPDATE usuario SET estado = 'activo' WHERE CI = ?");
    $stmt->bind_param("i", $CI);
    $stmt->execute();
    $stmt->close();
}

$conexion->close();

header("Location: leerusuario.php");
exit();
?>