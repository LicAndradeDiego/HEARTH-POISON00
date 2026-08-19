<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "proyetocuba";


$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);


if ($conn->connect_error) {

    die(
        "Error de conexión: " .
        $conn->connect_error
    );

}


$conn->set_charset("utf8");


// ==========================================
// OBTENER CÓDIGO DEL PRODUCTO
// ==========================================

$codigo =
    isset($_GET["codigo"])
    ? intval($_GET["codigo"])
    : 0;


if ($codigo == 0) {

    echo json_encode([
        "error" =>
            "No se recibió el código del producto"
    ]);

    exit;

}


// ==========================================
// BUSCAR PRODUCTO
// ==========================================

$sql = "
    SELECT
        codigo,
        nombre,
        precio,
        descripcion,
        stock,
        costo
    FROM productos
    WHERE codigo = ?
";


$stmt =
    $conn->prepare($sql);


if (!$stmt) {

    echo json_encode([
        "error" =>
            "Error al preparar la consulta: " .
            $conn->error
    ]);

    exit;

}


$stmt->bind_param(
    "i",
    $codigo
);


$stmt->execute();


$resultado =
    $stmt->get_result();


// ==========================================
// PRODUCTO NO ENCONTRADO
// ==========================================

if ($resultado->num_rows == 0) {

    echo json_encode([
        "error" =>
            "Producto no encontrado"
    ]);

    $stmt->close();

    $conn->close();

    exit;

}


// ==========================================
// OBTENER PRODUCTO
// ==========================================

$producto =
    $resultado->fetch_assoc();


$stmt->close();


// ==========================================
// DEVOLVER JSON
// ==========================================

echo json_encode(
    $producto,
    JSON_UNESCAPED_UNICODE
);


$conn->close();

?>