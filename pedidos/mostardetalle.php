<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error) {
    die("Conexion fallida: " . $conexion->connect_error);
}

if (!isset($_GET['id'])) {
    header("Location: leerpedido.php");
    exit();
}

$id = $_GET['id'];

// BUSCAR PEDIDO
$sql = "SELECT * FROM pedidos WHERE id='$id'";
$resultado = $conexion->query($sql);

// CALCULAR TOTAL DEL CARRITO
$sqlTotal = "SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id='$id'";
$resultadoTotal = $conexion->query($sqlTotal);
$res = $resultadoTotal->fetch_assoc();
$total = $res['total'] ?? 0;

// GENERAR QR
$textoQR = "Pedido ID: $id | Total: Bs. $total";
$urlQR = "https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=" . urlencode($textoQR);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle del Pedido</title>
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
    padding: 40px 0;
}

.contenedor {
    width: 480px;
    background: #0f0f0f;
    border: 1px solid #1a1a1a;
    padding: 40px;
    border-radius: 18px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.6);
}

h1 {
    text-align: center;
    font-size: 24px;
    font-weight: 300;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 25px;
}

.info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info p {
    background: #141414;
    border: 1px solid #1a1a1a;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    color: #ccc;
    display: flex;
    justify-content: space-between;
}

span {
    font-weight: bold;
    color: #aaa;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 1px;
}

.qr-contenedor {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #141414;
    border: 1px solid #1a1a1a;
    padding: 20px;
    border-radius: 12px;
    margin-top: 15px;
    text-align: center;
}

.qr-contenedor img {
    width: 150px;
    height: 150px;
    border-radius: 8px;
    background: white;
    padding: 5px;
}

.qr-contenedor p {
    background: transparent;
    padding: 0;
    border: none;
    margin-top: 10px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #777;
}

.boton {
    display: block;
    width: 100%;
    padding: 14px;
    background: #fff;
    color: #000;
    text-align: center;
    text-decoration: none;
    border-radius: 8px;
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
    font-weight: bold;
    transition: 0.4s ease;
    margin-top: 25px;
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
    <h1>Información del Pedido</h1>

    <div class="info">
    <?php
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        echo "<p><span>ID Pedido:</span> #" . htmlspecialchars($fila['id']) . "</p>";
        echo "<p><span>Cliente:</span> " . htmlspecialchars($fila['nombre']) . "</p>";
        echo "<p><span>Fecha:</span> " . htmlspecialchars($fila['fecha']) . "</p>";
        echo "<p><span>Estado:</span> " . htmlspecialchars($fila['estado']) . "</p>";
        echo "<p><span>Vendedor:</span> " . htmlspecialchars($fila['nombre_vendedor']) . "</p>";
        echo "<p><span>Dirección:</span> " . htmlspecialchars($fila['Direccion']) . "</p>";
        echo "<p><span>Teléfono:</span> " . htmlspecialchars($fila['Telefono']) . "</p>";
        echo "<p><span>Total A Pagar:</span> Bs. " . number_format($total, 2) . "</p>";
    } else {
        echo "<p>No se encontró el pedido.</p>";
    }
    ?>

        <div class="qr-contenedor">
            <img src="<?php echo $urlQR; ?>" alt="Código QR del Pedido">
            <p>Escanear código QR para verificar</p>
        </div>
    </div>

    <a class="boton" href="leerpedido.php">Volver a Pedidos</a>
</div>

</body>
</html>