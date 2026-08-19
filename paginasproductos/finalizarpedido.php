<?php

session_start();

require("conexion.php");

header("Content-Type: application/json; charset=utf-8");


// ==========================================
// VERIFICAR PEDIDO
// ==========================================

if (!isset($_SESSION["pedido"])) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No existe pedido"
    ]);

    exit;
}


$idPedido = intval($_SESSION["pedido"]);


try {


    // ==========================================
    // 1. OBTENER PRODUCTOS DEL PEDIDO
    // ==========================================

    $sqlCarrito = "
        SELECT
            productos_codigo,
            cantidad
        FROM carrito
        WHERE pedidos_id = ?
    ";


    $stmtCarrito =
        $conn->prepare($sqlCarrito);


    if (!$stmtCarrito) {

        throw new Exception(
            "Error al preparar carrito: " .
            $conn->error
        );

    }


    $stmtCarrito->bind_param(
        "i",
        $idPedido
    );


    $stmtCarrito->execute();


    $resultado =
        $stmtCarrito->get_result();


    // ==========================================
    // VERIFICAR QUE HAYA PRODUCTOS
    // ==========================================

    if ($resultado->num_rows == 0) {

        throw new Exception(
            "El pedido no tiene productos asociados."
        );

    }


    // ==========================================
    // 2. RESTAR STOCK
    // ==========================================

    while (
        $producto =
        $resultado->fetch_assoc()
    ) {


        $codigo =
            intval(
                $producto["productos_codigo"]
            );


        $cantidad =
            intval(
                $producto["cantidad"]
            );


        // ======================================
        // ACTUALIZAR STOCK
        // ======================================

        $sqlStock = "
            UPDATE productos
            SET stock = stock - ?
            WHERE codigo = ?
            AND stock >= ?
        ";


        $stmtStock =
            $conn->prepare($sqlStock);


        if (!$stmtStock) {

            throw new Exception(
                "Error al preparar stock: " .
                $conn->error
            );

        }


        $stmtStock->bind_param(
            "iii",
            $cantidad,
            $codigo,
            $cantidad
        );


        if (!$stmtStock->execute()) {

            throw new Exception(
                $stmtStock->error
            );

        }


        // ======================================
        // VERIFICAR STOCK
        // ======================================

        if (
            $stmtStock->affected_rows == 0
        ) {

            throw new Exception(
                "No hay suficiente stock para el producto: " .
                $codigo
            );

        }


        $stmtStock->close();

    }


    $stmtCarrito->close();


    // ==========================================
    // 3. FINALIZAR PEDIDO
    // ==========================================

    $sqlPedido = "
        UPDATE pedidos
        SET estado = 'Activo'
        WHERE id = ?
    ";


    $stmtPedido =
        $conn->prepare($sqlPedido);


    if (!$stmtPedido) {

        throw new Exception(
            "Error al preparar pedido: " .
            $conn->error
        );

    }


    $stmtPedido->bind_param(
        "i",
        $idPedido
    );


    if (!$stmtPedido->execute()) {

        throw new Exception(
            $stmtPedido->error
        );

    }


    $stmtPedido->close();


    // ==========================================
    // RESPUESTA EXITOSA
    // ==========================================

    echo json_encode([

        "ok" => true,

        "pedido" => $idPedido,

        "mensaje" =>
            "Pedido finalizado correctamente"

    ]);


} catch (Exception $e) {


    echo json_encode([

        "ok" => false,

        "mensaje" =>
            $e->getMessage()

    ]);

}


$conn->close();

?>