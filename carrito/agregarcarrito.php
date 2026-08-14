<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "proyetocuba";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $codigo   = $_POST["codigo"] ?? '';
    $idpedido = (int)($_POST["idpedido"] ?? 0);
    $cantidad = (int)($_POST["cantidad"] ?? 1);
    $precio   = (float)($_POST["precio"] ?? 0);

    if (empty($codigo) || $idpedido <= 0 || $cantidad <= 0) {
        header("Location: micarrito.php?idPedido=" . $idpedido);
        exit();
    }

    // 1. Consultar el stock disponible del producto
    $stmtStock = $conn->prepare("SELECT stock FROM productos WHERE codigo = ?");
    $stmtStock->bind_param("s", $codigo);
    $stmtStock->execute();
    $resStock = $stmtStock->get_result()->fetch_assoc();
    $stmtStock->close();

    $stockDisponible = $resStock ? (int)$resStock['stock'] : 0;

    // 2. Consultar si ya existe este producto en el carrito del pedido actual
    $stmtCart = $conn->prepare("SELECT cantidad FROM carrito WHERE productos_codigo = ? AND pedidos_id = ?");
    $stmtCart->bind_param("si", $codigo, $idpedido);
    $stmtCart->execute();
    $resCart = $stmtCart->get_result()->fetch_assoc();
    $stmtCart->close();

    $cantidadActualEnCarrito = $resCart ? (int)$resCart['cantidad'] : 0;
    $cantidadTotalSolicitada = $cantidadActualEnCarrito + $cantidad;

    // 3. Validar si excede el stock
    if ($cantidadTotalSolicitada > $stockDisponible) {
        header("Location: micarrito.php?idPedido=" . $idpedido . "&error=stock");
        exit();
    }

    // 4. Calcular subtotal e insertar/actualizar
    $subtotal = $cantidad * $precio;

    $stmtInsert = $conn->prepare("
        INSERT INTO carrito (productos_codigo, pedidos_id, cantidad, costototal) 
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            cantidad = cantidad + VALUES(cantidad),
            costototal = costototal + VALUES(costototal)
    ");
    
    $stmtInsert->bind_param("siid", $codigo, $idpedido, $cantidad, $subtotal);

    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: micarrito.php?idPedido=" . $idpedido . "&success=1");
        exit();
    } else {
        echo "Error crítico en el proceso del carrito: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: micarrito.php");
    exit();
}
?>