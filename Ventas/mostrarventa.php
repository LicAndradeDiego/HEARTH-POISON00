<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$venta = null;

if (isset($_GET['pedidos_id'])) {
    $pedidos_id = $conexion->real_escape_string($_GET['pedidos_id']);
    $sql = "SELECT * FROM ventas WHERE pedidos_id='$pedidos_id'";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $venta = $resultado->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mostrar Venta</title>
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
    width: 100%;
    max-width: 500px;
    padding: 40px;
    border-radius: 18px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.6);
}

h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 20px;
    font-weight: 300;
    letter-spacing: 3px;
    text-transform: uppercase;
}

.dato {
    background: #141414;
    border: 1px solid #222;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 12px;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
}

.dato span {
    font-weight: bold;
    color: #888;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 1px;
}

.boton-centro {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.boton {
    display: inline-block;
    background: #fff;
    color: #000;
    text-decoration: none;
    padding: 12px 28px;
    border-radius: 8px;
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: bold;
    transition: 0.3s ease;
}

.boton:hover {
    background: #000;
    color: #fff;
    border: 1px solid #fff;
}

.error {
    text-align: center;
    font-size: 18px;
    color: #ff4d4d;
}
</style>
</head>
<body>

<?php include_once '../header.php'; ?>

<div class="contenedor">
<?php
if ($venta) {
    echo "<h1>Datos de la Venta</h1>";
    echo "<div class='dato'><span>ID Pedido</span> " . htmlspecialchars($venta['pedidos_id']) . "</div>";
    echo "<div class='dato'><span>Costo Total</span> Bs. " . htmlspecialchars($venta['costoTotal']) . "</div>";
    echo "<div class='dato'><span>Estado</span> " . htmlspecialchars($venta['estado']) . "</div>";
    echo "<div class='dato'><span>Método de Pago</span> " . htmlspecialchars($venta['metodo']) . "</div>";
} else {
    echo "<h1 class='error'>Venta no encontrada</h1>";
}

$conexion->close();
?>

<div class="boton-centro">
    <a class="boton" href="leerventa.php">Volver</a>
</div>

</div>

</body>
</html>