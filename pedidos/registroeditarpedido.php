<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error) {
    die("Conexion fallida: " . $conexion->connect_error);
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$Nombre = $_POST['Nombre'] ?? ($_POST['nombre'] ?? '');
$Fecha = $_POST['Fecha'] ?? ($_POST['fecha'] ?? '');
$Estado = $_POST['Estado'] ?? ($_POST['estado'] ?? '');
$nombre_vendedor = $_POST['nombre_vendedor'] ?? ($_POST['NombreVendedor'] ?? '');
$Direccion = $_POST['Direccion'] ?? '';
$Telefono = !empty($_POST['Telefono']) ? intval($_POST['Telefono']) : "NULL";

// 1. Estado anterior
$consulta = $conexion->query("SELECT estado FROM pedidos WHERE id = $id");
$anterior = $consulta ? $consulta->fetch_assoc() : null;
$estadoAnterior = $anterior['estado'] ?? '';

// 2. Actualizar pedido
$sql = "UPDATE pedidos SET 
            nombre = '$Nombre',
            fecha = '$Fecha',
            estado = '$Estado',
            nombre_vendedor = '$nombre_vendedor',
            Direccion = '$Direccion',
            Telefono = $Telefono
        WHERE id = $id";

$actualizado = $conexion->query($sql);

// 3. Descontar stock si pasa a 'Entregado' por primera vez
if ($actualizado && $Estado == 'Entregado' && $estadoAnterior != 'Entregado') {
    $detalle = $conexion->query("
        SELECT productos_codigo, cantidad 
        FROM carrito 
        WHERE pedidos_id = $id
    ");

    if ($detalle) {
        while ($item = $detalle->fetch_assoc()) {
            $codigo = $item['productos_codigo'];
            $cantidad = $item['cantidad'];

            $conexion->query("
                UPDATE productos 
                SET stock = stock - $cantidad 
                WHERE codigo = $codigo
            ");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Actualizar Pedido</title>
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
<?php
if($actualizado === TRUE){
    echo "<h1>✓ Pedido Actualizado</h1>";
    echo "<p>El pedido se actualizó con éxito.</p>";
}else{
    echo "<h1 style='color: #ff4d4d;'>✕ Error</h1>";
    echo "<p>No se pudo actualizar el pedido.</p>";
}
?>
<a class="boton" href="leerpedido.php">Volver a Pedidos</a>
</div>

</body>
</html>