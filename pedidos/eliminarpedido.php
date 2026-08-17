<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id == '' || !is_numeric($id)) {
    die("ID de pedido no válido.");
}

$id = (int)$id;

// 1. Eliminar productos asignados al carrito
$conexion->query("DELETE FROM carrito WHERE pedidos_id = $id");

// 2. Eliminar pedido principal
$sql = "DELETE FROM pedidos WHERE id = $id";
$eliminado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eliminar Pedido</title>
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
    margin-bottom: 25px;
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
    <?php if ($eliminado === TRUE): ?>
        <h1>✓ Pedido Eliminado</h1>
        <p>El pedido fue eliminado correctamente de la base de datos.</p>
    <?php else: ?>
        <h1 style="color: #ff4d4d;">✕ Error</h1>
        <p>No se pudo eliminar el pedido indicado.</p>
    <?php endif; ?>

    <a class="boton" href="leerpedido.php">Volver a Pedidos</a>
</div>

</body>
</html>