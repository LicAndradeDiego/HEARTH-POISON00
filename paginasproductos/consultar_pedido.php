<?php

require("conexion.php");

header("Content-Type: application/json; charset=utf-8");


$id = $_POST["id"] ?? "";


if ($id == "") {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se recibió el número de pedido"
    ]);

    exit;
}


$id = intval($id);


// ==========================================
// BUSCAR PEDIDO
// ==========================================

$sql = "
    SELECT
        id,
        nombre,
        fecha,
        estado,
        nombre_vendedor
    FROM pedidos
    WHERE id = ?
";


$stmt = $conn->prepare($sql);


if (!$stmt) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al preparar la consulta: " . $conn->error
    ]);

    exit;
}


$stmt->bind_param(
    "i",
    $id
);


$stmt->execute();


$resultado = $stmt->get_result();


// ==========================================
// PEDIDO ENCONTRADO
// ==========================================

if ($resultado->num_rows > 0) {

    $pedido = $resultado->fetch_assoc();


    echo json_encode([

        "ok" => true,

        "pedido" => $pedido

    ]);

}


// ==========================================
// PEDIDO NO ENCONTRADO
// ==========================================

else {

    echo json_encode([

        "ok" => false,

        "mensaje" => "Pedido no encontrado"

    ]);

}


$stmt->close();

$conn->close();

?>