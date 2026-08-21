<?php
// Ocultar errores HTML para evitar romper el formato JSON en JS
ini_set('display_errors', 0);
error_reporting(0);

session_start();
header("Content-Type: application/json");

// Incluir la conexión desde la carpeta paginasproductos
$rutaConexion = __DIR__ . "/../paginasproductos/conexion.php";

if (!file_exists($rutaConexion)) {
    echo json_encode(["ok" => false, "mensaje" => "No se encontró conexion.php"]);
    exit;
}

require_once($rutaConexion);

if (!isset($_SESSION["pedidos"])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No existe pedido activo"
    ]);
    exit;
}

$idPedido = $_SESSION["pedidos"];

// Actualizamos el estado del pedido a Pendiente
$sql = "UPDATE pedidos SET estado='Pendiente' WHERE id='$idPedido'";

if ($conn->query($sql)) {
    
    echo json_encode([
        "ok" => true,
        "pedidos" => $idPedido
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error BD: " . $conn->error
    ]);

}

$conn->close();
?>