<?php

session_start();

require("conexion.php");

header("Content-Type: application/json; charset=utf-8");


// ==========================================
// VERIFICAR CONEXIÓN
// ==========================================

if ($conn->connect_error) {

    echo json_encode(array(
        "ok" => false,
        "mensaje" => "Error de conexión: " . $conn->connect_error
    ));

    exit;
}


// ==========================================
// OBTENER ID DEL PEDIDO
// ==========================================

if (
    isset($_POST["idPedidos"]) &&
    $_POST["idPedidos"] != ""
) {

    $idPedido = intval($_POST["idPedidos"]);

    $_SESSION["pedido"] = $idPedido;

}

elseif (
    isset($_SESSION["pedido"])
) {

    $idPedido = intval($_SESSION["pedido"]);

}

else {

    echo json_encode(array(
        "ok" => false,
        "mensaje" => "No existe un pedido activo"
    ));

    exit;
}


// ==========================================
// OBTENER ACCIÓN
// ==========================================

$accion =
    isset($_POST["accion"])
    ? $_POST["accion"]
    : "";


// ==========================================
// AGREGAR PRODUCTO
// ==========================================

if ($accion == "agregar") {


    $codigo =
        isset($_POST["codigo"])
        ? $_POST["codigo"]
        : "";


    $cantidadNueva =
        isset($_POST["cantidad"])
        ? intval($_POST["cantidad"])
        : 1;


    // Verificar código

    if ($codigo == "") {

        echo json_encode(array(
            "ok" => false,
            "mensaje" => "No se recibió el código del producto"
        ));

        exit;
    }


    // Verificar cantidad

    if ($cantidadNueva < 1) {

        $cantidadNueva = 1;

    }


    // ======================================
    // BUSCAR PRODUCTO
    // ======================================

    $sql = "
        SELECT precio, stock
        FROM productos
        WHERE codigo = ?
    ";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        echo json_encode(array(
            "ok" => false,
            "mensaje" =>
                "Error al preparar producto: " .
                $conn->error
        ));

        exit;

    }


    $stmt->bind_param(
        "i",
        $codigo
    );


    $stmt->execute();

    $stmt->store_result();


    // Producto no encontrado

    if ($stmt->num_rows == 0) {

        echo json_encode(array(
            "ok" => false,
            "mensaje" => "Producto no encontrado"
        ));

        $stmt->close();

        exit;

    }


    // Obtener precio y stock

    $stmt->bind_result(
        $precio,
        $stock
    );


    $stmt->fetch();

    $stmt->close();


    $precio = intval($precio);

    $stock = intval($stock);


    // ======================================
    // VERIFICAR STOCK
    // ======================================

    if ($cantidadNueva > $stock) {

        echo json_encode(array(
            "ok" => false,
            "mensaje" => "No hay suficiente stock"
        ));

        exit;

    }


    // ======================================
    // BUSCAR SI EL PRODUCTO YA ESTÁ
    // EN EL CARRITO
    // ======================================

    $sql = "
        SELECT cantidad
        FROM carrito
        WHERE productos_codigo = ?
        AND pedidos_id = ?
    ";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        echo json_encode(array(
            "ok" => false,
            "mensaje" =>
                "Error al preparar carrito: " .
                $conn->error
        ));

        exit;

    }


    $stmt->bind_param(
        "ii",
        $codigo,
        $idPedido
    );


    $stmt->execute();

    $stmt->store_result();


    // ======================================
    // PRODUCTO YA EXISTE
    // ======================================

    if ($stmt->num_rows > 0) {


        $stmt->bind_result(
            $cantidadActual
        );


        $stmt->fetch();

        $stmt->close();


        // Sumar cantidad

        $cantidadTotal =
            intval($cantidadActual) +
            $cantidadNueva;


        // ==================================
        // COMPROBAR STOCK TOTAL
        // ==================================

        if ($cantidadTotal > $stock) {

            echo json_encode(array(
                "ok" => false,
                "mensaje" => "No hay suficiente stock"
            ));

            exit;

        }


        // ==================================
        // CALCULAR COSTO TOTAL
        // ==================================

        $costoTotal =
            $cantidadTotal * $precio;


        // ==================================
        // ACTUALIZAR CARRITO
        // ==================================

        $sql = "
            UPDATE carrito
            SET
                cantidad = ?,
                costototal = ?
            WHERE productos_codigo = ?
            AND pedidos_id = ?
        ";


        $stmt = $conn->prepare($sql);


        if (!$stmt) {

            echo json_encode(array(
                "ok" => false,
                "mensaje" => $conn->error
            ));

            exit;

        }


        $stmt->bind_param(
            "iiii",
            $cantidadTotal,
            $costoTotal,
            $codigo,
            $idPedido
        );


        if ($stmt->execute()) {

            echo json_encode(array(
                "ok" => true,
                "mensaje" =>
                    "Producto actualizado correctamente"
            ));

        }

        else {

            echo json_encode(array(
                "ok" => false,
                "mensaje" => $stmt->error
            ));

        }


        $stmt->close();

    }


    // ======================================
    // PRODUCTO NUEVO
    // ======================================

    else {


        $stmt->close();


        // Calcular costo total

        $costoTotal =
            $cantidadNueva * $precio;


        // ==================================
        // INSERTAR PRODUCTO
        // ==================================

        $sql = "
            INSERT INTO carrito
            (
                productos_codigo,
                pedidos_id,
                cantidad,
                costototal
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ";


        $stmt = $conn->prepare($sql);


        if (!$stmt) {

            echo json_encode(array(
                "ok" => false,
                "mensaje" => $conn->error
            ));

            exit;

        }


        $stmt->bind_param(
            "iiii",
            $codigo,
            $idPedido,
            $cantidadNueva,
            $costoTotal
        );


        if ($stmt->execute()) {

            echo json_encode(array(
                "ok" => true,
                "mensaje" =>
                    "Producto agregado correctamente"
            ));

        }

        else {

            echo json_encode(array(
                "ok" => false,
                "mensaje" => $stmt->error
            ));

        }


        $stmt->close();

    }

}


// ==========================================
// MOSTRAR CARRITO
// ==========================================

elseif ($accion == "mostrar") {


    $sql = "
        SELECT

            c.productos_codigo,

            c.cantidad,

            c.costototal,

            p.nombre,

            p.precio

        FROM carrito c

        INNER JOIN productos p
            ON c.productos_codigo = p.codigo

        WHERE c.pedidos_id = ?
    ";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        echo json_encode(array(
            "ok" => false,
            "mensaje" =>
                "Error al preparar consulta: " .
                $conn->error
        ));

        exit;

    }


    $stmt->bind_param(
        "i",
        $idPedido
    );


    $stmt->execute();


    $stmt->bind_result(

        $codigoProducto,

        $cantidad,

        $costoTotal,

        $nombreProducto,

        $precioProducto

    );


    $carrito = array();


    while ($stmt->fetch()) {

        $carrito[] = array(

            "productos_codigo" =>
                $codigoProducto,

            "cantidad" =>
                $cantidad,

            "costototal" =>
                $costoTotal,

            "nombre" =>
                $nombreProducto,

            "precio" =>
                $precioProducto

        );

    }


    echo json_encode(
        $carrito
    );


    $stmt->close();

}


// ==========================================
// VACIAR CARRITO
// ==========================================

elseif ($accion == "vaciar") {


    $sql = "
        DELETE FROM carrito
        WHERE pedidos_id = ?
    ";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        echo json_encode(array(
            "ok" => false,
            "mensaje" => $conn->error
        ));

        exit;

    }


    $stmt->bind_param(
        "i",
        $idPedido
    );


    if ($stmt->execute()) {

        echo json_encode(array(
            "ok" => true,
            "mensaje" =>
                "Carrito vaciado correctamente"
        ));

    }

    else {

        echo json_encode(array(
            "ok" => false,
            "mensaje" => $stmt->error
        ));

    }


    $stmt->close();

}


// ==========================================
// ACCIÓN NO RECONOCIDA
// ==========================================

else {

    echo json_encode(array(
        "ok" => false,
        "mensaje" => "Acción no válida"
    ));

}


$conn->close();

?>