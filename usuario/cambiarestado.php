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

    // CORREGIDO: Consulta a la tabla 'usuario'
    $stmt = $conexion->prepare("SELECT estado FROM usuario WHERE CI = ?");
    $stmt->bind_param("i", $CI);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        if (strtolower($fila['estado']) == "activo") {
            $update = $conexion->prepare("UPDATE usuario SET estado = 'bloqueado' WHERE CI = ?");
        } else {
            $update = $conexion->prepare("UPDATE usuario SET estado = 'activo' WHERE CI = ?");
        }
        $update->bind_param("i", $CI);
        $update->execute();
        $update->close();
    }
    $stmt->close();
}

$conexion->close();
header("Location: leerusuario.php");
exit();
?>