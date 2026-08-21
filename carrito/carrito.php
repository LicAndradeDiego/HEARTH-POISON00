<?php
// Desactivar salida de errores HTML para no romper la respuesta JSON
ini_set('display_errors', 0);
error_reporting(0);

session_start();
header("Content-Type: application/json");

// Incluir la conexión correctamente
$rutaConexion = __DIR__ . '/../paginasproductos/conexion.php';

if (!file_exists($rutaConexion)) {
    echo json_encode(["ok" => false, "mensaje" => "No se encontró el archivo conexion.php"]);
    exit;
}

require_once($rutaConexion);

// Autocrear pedido si no existe una sesión activa
if (!isset($_SESSION["pedidos"])) {
    $fecha = date("Y-m-d");
    $sqlNuevoPedido = "INSERT INTO pedidos (fecha) VALUES ('$fecha')";
    if ($conn->query($sqlNuevoPedido)) {
        $_SESSION["pedidos"] = $conn->insert_id;
    } else {
        echo json_encode(["ok" => false, "mensaje" => "Error al crear pedido en sesión: " . $conn->error]);
        exit;
    }
}

$idPedido = $_SESSION["pedidos"];
$accion = $_POST["accion"] ?? '';

switch ($accion) {

    case "agregar":
        $codigo = $_POST["codigo"] ?? '';

        if (empty($codigo)) {
            echo json_encode(["ok" => false, "mensaje" => "Código de producto no recibido"]);
            exit;
        }

        // Buscar el producto en la tabla productos
        $sqlProducto = "SELECT * FROM productos WHERE codigo='$codigo'";
        $resProducto = $conn->query($sqlProducto);

        if (!$resProducto || $resProducto->num_rows === 0) {
            echo json_encode(["ok" => false, "mensaje" => "Producto no encontrado con el código: " . $codigo]);
            exit;
        }

        $producto = $resProducto->fetch_assoc();
        $precio = $producto["precio"] ?? $producto["Precio"] ?? 0;

        // Comprobar si ya existe en el carrito de este pedido
        $sqlExiste = "SELECT * FROM carrito WHERE pedidos_id='$idPedido' AND productos_codigo='$codigo'";
        $resExiste = $conn->query($sqlExiste);

        if ($resExiste && $resExiste->num_rows > 0) {
            $fila = $resExiste->fetch_assoc();
            $nuevaCant = $fila["cantidad"] + 1;
            $nuevoSubtotal = $nuevaCant * $precio;
            $sql = "UPDATE carrito SET cantidad='$nuevaCant', costototal='$nuevoSubtotal' WHERE pedidos_id='$idPedido' AND productos_codigo='$codigo'";
        } else {
            $sql = "INSERT INTO carrito (pedidos_id, productos_codigo, cantidad, costototal) VALUES ('$idPedido', '$codigo', 1, '$precio')";
        }

        if ($conn->query($sql)) {
            echo json_encode(["ok" => true, "mensaje" => "Producto agregado con éxito"]);
        } else {
            echo json_encode(["ok" => false, "mensaje" => "Error en BD: " . $conn->error]);
        }
        break;

    case "mostrar":
        $sql = "SELECT 
                    c.productos_codigo AS Productos_Codigo,
                    c.cantidad AS Cantidad,
                    c.costototal AS CostoTotal,
                    p.nombre AS Nombre,
                    p.precio AS Precio
                FROM carrito c
                INNER JOIN productos p ON c.productos_codigo = p.codigo
                WHERE c.pedidos_id='$idPedido'";

        $res = $conn->query($sql);
        $items = [];

        if ($res) {
            while ($fila = $res->fetch_assoc()) {
                $items[] = $fila;
            }
        }

        echo json_encode($items);
        break;

    case "vaciar":
        $sql = "DELETE FROM carrito WHERE pedidos_id='$idPedido'";

        if ($conn->query($sql)) {
            echo json_encode(["ok" => true, "mensaje" => "Carrito vaciado"]);
        } else {
            echo json_encode(["ok" => false, "mensaje" => "Error al vaciar: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["ok" => false, "mensaje" => "Acción no válida"]);
        break;
}

$conn->close();