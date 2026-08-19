<?php

// ==========================================
// CONEXIÓN A LA BASE DE DATOS
// ==========================================

$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";


$conn = new mysqli(
    $servername,
    $username,
    $password,
    $bdname
);


if ($conn->connect_error) {

    die(
        "Conexion fallida: " .
        $conn->connect_error
    );

}


$conn->set_charset("utf8");


// ==========================================
// RECIBIR ID DEL PEDIDO
// ==========================================

$id = isset($_POST["id"])
    ? intval($_POST["id"])
    : 0;


// ==========================================
// VERIFICAR ID
// ==========================================

if ($id <= 0) {

    echo json_encode([

        "ok" => false,

        "mensaje" =>
            "No se recibió un número de pedido válido"

    ]);

    exit;

}


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

        "mensaje" =>
            "Error al preparar la consulta: " .
            $conn->error

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
// DEVOLVER PEDIDO
// ==========================================

if ($resultado->num_rows > 0) {


    $pedido =
        $resultado->fetch_assoc();


    echo json_encode([

        "ok" => true,

        "pedido" => $pedido

    ]);


} else {


    echo json_encode([

        "ok" => false,

        "mensaje" =>
            "Pedido no encontrado"

    ]);

}


// ==========================================
// CERRAR
// ==========================================

$stmt->close();

$conn->close();

?>