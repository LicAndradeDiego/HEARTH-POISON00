<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if($conexion->connect_error){
    die("Conexion fallida: ".$conexion->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consulta de datos del pedido
$sql = "SELECT * FROM pedidos WHERE id='$id'";
$resultado = $conexion->query($sql);

// Consulta de productos asignados al carrito de este pedido
$sqlCarrito = "SELECT c.*, p.nombre AS producto_nombre, p.precio 
               FROM carrito c 
               INNER JOIN productos p ON c.productos_codigo = p.codigo 
               WHERE c.pedidos_id='$id'";
$resultadoCarrito = $conexion->query($sqlCarrito);

// Suma total del carrito
$sqlTotal = "SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id='$id'";
$resultadoTotal = $conexion->query($sqlTotal);
$res = $resultadoTotal->fetch_assoc();
$total = $res['total'] ?? 0;
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

h1, h2 {
    text-align: center;
    font-size: 24px;
    font-weight: 300;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 25px;
}

h2 {
    font-size: 14px;
    margin-top: 25px;
    border-bottom: 1px solid #1a1a1a;
    padding-bottom: 10px;
}

.info p {
    font-size: 13px;
    margin-bottom: 12px;
    color: #ccc;
    display: flex;
    justify-content: space-between;
}

.info span {
    font-weight: bold;
    color: #aaa;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 1px;
}

.tabla-detalles {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    font-size: 13px;
}

.tabla-detalles th, .tabla-detalles td {
    padding: 10px 8px;
    text-align: left;
    border-bottom: 1px solid #1a1a1a;
}

.tabla-detalles th {
    color: #aaa;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.total-destacado {
    font-size: 14px;
    color: #fff;
    font-weight: bold;
    margin-top: 20px;
    text-align: right;
    letter-spacing: 1px;
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
    if($resultado && $resultado->num_rows > 0){
        $fila = $resultado->fetch_assoc();
        echo "<p><span>ID Pedido:</span> #".$fila['id']."</p>";
        echo "<p><span>Nombre Cliente:</span> ".htmlspecialchars($fila['nombre'])."</p>";
        echo "<p><span>Fecha:</span> ".htmlspecialchars($fila['fecha'])."</p>";
        echo "<p><span>Estado:</span> ".htmlspecialchars($fila['estado'])."</p>";
        echo "<p><span>Vendedor:</span> ".htmlspecialchars($fila['nombre_vendedor'])."</p>";
        echo "<p><span>Dirección:</span> ".htmlspecialchars($fila['Direccion'])."</p>";
        echo "<p><span>Teléfono:</span> ".htmlspecialchars($fila['Telefono'])."</p>";
    } else {
        echo "<p>No se encontró el pedido solicitado.</p>";
    }
    ?>
    </div>

    <?php if($resultadoCarrito && $resultadoCarrito->num_rows > 0): ?>
        <h2>Detalle del Carrito</h2>
        <table class="tabla-detalles">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = $resultadoCarrito->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['producto_nombre']); ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td>Bs. <?php echo number_format($item['costototal'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="total-destacado">
            TOTAL PEDIDO: Bs. <?php echo number_format($total, 2); ?>
        </div>
    <?php endif; ?>

    <a class="boton" href="leerpedido.php">Volver a Pedidos</a>
</div>

</body>
</html>