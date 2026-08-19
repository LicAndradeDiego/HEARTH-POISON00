<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = isset($_POST['Nombre']) ? $_POST['Nombre'] : '';
$fecha = isset($_POST['Fecha']) ? $_POST['Fecha'] : '';
$estado = isset($_POST['Estado']) ? $_POST['Estado'] : '';
$nombre_vendedor = isset($_POST['nombre_vendedor']) ? $_POST['nombre_vendedor'] : '';
$Direccion = isset($_POST['Direccion']) ? $_POST['Direccion'] : '';
$Telefono = !empty($_POST['Telefono']) ? intval($_POST['Telefono']) : "NULL";

$productos_codigo = !empty($_POST['productos_codigo']) ? intval($_POST['productos_codigo']) : null;
$cantidad = !empty($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
$costototal = !empty($_POST['costototal']) ? intval($_POST['costototal']) : 0;

// Consulta limpia usando minúsculas para los nombres de las columnas
$sqlPedido = "INSERT INTO pedidos (nombre, fecha, estado, nombre_vendedor, Direccion, Telefono)
              VALUES ('$nombre', '$fecha', '$estado', '$nombre_vendedor', '$Direccion', $Telefono)";

if ($conn->query($sqlPedido) === TRUE) {
    $idPedido = $conn->insert_id;

    // Insertar en Carrito si aplica
    if ($productos_codigo && $cantidad > 0) {
        $sqlCarrito = "INSERT INTO carrito (productos_codigo, pedidos_id, cantidad, costototal) 
                       VALUES ($productos_codigo, $idPedido, $cantidad, $costototal)";
        $conn->query($sqlCarrito);
    }
} else {
    $error = $conn->error;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Pedido</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Helvetica Neue', Arial, sans-serif;
}

body {
    background: #090909;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 30px;
}

.contenedor {
    background: #0f0f0f;
    border: 1px solid #1a1a1a;
    width: 450px;
    padding: 40px;
    border-radius: 18px;
    text-align: center;
    color: white;
    box-shadow: 0 20px 60px rgba(0,0,0,0.6);
}

h1 {
    font-size: 24px;
    font-weight: 300;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

p {
    font-size: 14px;
    margin-bottom: 20px;
    color: #ccc;
}

.boton {
    display: inline-block;
    width: 100%;
    background: #fff;
    color: #000;
    text-decoration: none;
    padding: 14px;
    border-radius: 8px;
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
    font-weight: bold;
    transition: 0.4s ease;
    margin-top: 10px;
}

.boton:hover {
    background: #000;
    color: #fff;
    border: 1px solid #fff;
}
</style>
</head>
<body>

<?php include '../header.php'; ?>

<div class="contenedor">
<?php if (isset($idPedido) && $idPedido > 0): ?>
    <h1>✓ Pedido Registrado</h1>
    <p>El nuevo pedido fue creado con éxito.</p>
    <p>Número de pedido: <strong>#<?php echo $idPedido; ?></strong></p>
<?php else: ?>
    <h1 style="color: #ff4d4d;">✕ Error</h1>
    <p>El pedido no fue creado.</p>
    <p><?php echo isset($error) ? $error : 'Error desconocido'; ?></p>
<?php endif; ?>

<a class="boton" href="leerpedido.php">Volver a Pedidos</a>
</div>

</body>
</html>