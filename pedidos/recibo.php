<?php
// Ocultar avisos en pantalla para mantener limpia la interfaz del recibo
ini_set('display_errors', 0);
error_reporting(0);

session_start();
require("../paginasproductos/conexion.php");

if (!isset($_SESSION["pedidos"])) {
    echo "No existe pedido activo";
    exit;
}

$id = $_SESSION["pedidos"];

$sql = "SELECT id, nombre, fecha, estado, nombre_vendedor, Direccion, Telefono 
        FROM pedidos 
        WHERE id = '$id'";

$resultado = $conn->query($sql);
$pedido = $resultado ? $resultado->fetch_assoc() : null;

if (!$pedido) {
    echo "El pedido solicitado no existe";
    exit;
}

$metodo_pago = isset($_SESSION["Metodo"]) ? $_SESSION["Metodo"] : "No especificado";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pedido</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            padding: 40px 20px;
            background: #090909;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            width: 100%;
            max-width: 500px;
            text-align: center;
            font-size: 22px;
            font-weight: 300;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .recibo-card {
            width: 100%;
            max-width: 500px;
            background: #0f0f0f;
            border: 1px solid #1a1a1a;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        }

        .titulo-recibo {
            text-align: center;
            background: #1a1a1a;
            color: #fff;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .info-grupo {
            margin-bottom: 15px;
        }

        p.dato {
            background: transparent;
            padding: 8px 0;
            font-size: 13px;
            color: #ccc;
            border-bottom: 1px solid #1a1a1a;
            display: flex;
            justify-content: space-between;
        }

        p.dato span {
            color: #fff;
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 1px dashed #333;
            margin: 20px 0;
        }

        h3 {
            text-align: center;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 15px;
        }

        .producto-item {
            background: #141414;
            border: 1px solid #222;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .producto-item strong {
            display: block;
            color: #fff;
            margin-bottom: 4px;
        }

        .total-box {
            margin-top: 20px;
            padding: 15px;
            text-align: center;
            background: #fff;
            color: #000;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .qr-recibo {
            background: #141414;
            border: 1px solid #222;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            border-radius: 12px;
        }

        .qr-recibo img {
            width: 180px;
            height: 180px;
            padding: 8px;
            background: white;
            border-radius: 8px;
            margin: 10px 0;
        }

        .qr-recibo p {
            color: #888;
            font-size: 11px;
        }

        .acciones {
            display: flex;
            gap: 10px;
            width: 100%;
            max-width: 500px;
            margin-top: 15px;
        }

        button {
            flex: 1;
            padding: 14px;
            border-radius: 8px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            border: none;
        }

        .btn-imprimir {
            background: #fff;
            color: #000;
        }

        .btn-imprimir:hover {
            background: #ccc;
        }

        .btn-volver {
            background: transparent;
            border: 1px solid #333;
            color: #fff;
        }

        .btn-volver:hover {
            border-color: #fff;
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
                padding: 0;
            }
            .recibo-card {
                border: none;
                box-shadow: none;
                background: white;
                color: black;
                width: 100%;
            }
            .titulo-recibo, .producto-item, .qr-recibo {
                background: #f5f5f5 !important;
                color: black !important;
                border: 1px solid #ccc;
            }
            p.dato {
                color: #333 !important;
                border-bottom: 1px solid #ccc;
            }
            p.dato span {
                color: black !important;
            }
            .total-box {
                background: #000 !important;
                color: #fff !important;
            }
            .acciones {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<h1>HEARTH POISON</h1>

<div class="recibo-card">
    <div class="titulo-recibo">Recibo de Pedido</div>

    <div class="info-grupo">
        <p class="dato">Número de Pedido: <span>#<?php echo htmlspecialchars($pedido["id"] ?? ''); ?></span></p>
        <p class="dato">Cliente: <span><?php echo htmlspecialchars($pedido["nombre"] ?? 'Cliente'); ?></span></p>
        <p class="dato">Teléfono: <span><?php echo htmlspecialchars($pedido["Telefono"] ?? 'No registrado'); ?></span></p>
        <p class="dato">Dirección: <span><?php echo htmlspecialchars($pedido["Direccion"] ?? 'No registrada'); ?></span></p>
        <p class="dato">Vendedor: <span><?php echo htmlspecialchars($pedido["nombre_vendedor"] ?? 'Online'); ?></span></p>
        <p class="dato">Método de pago: <span><?php echo htmlspecialchars($metodo_pago); ?></span></p>
        <p class="dato">Estado: <span><?php echo htmlspecialchars($pedido["estado"] ?? 'Pendiente'); ?></span></p>
    </div>

    <hr>

    <h3>Productos Detallados</h3>

    <?php
    // CONSULTA CORREGIDA: Incluimos c.cantidad y c.costototal de la tabla carrito
    $sqlproductos = "SELECT p.nombre, p.precio, c.cantidad, c.costototal 
                    FROM carrito c 
                    INNER JOIN productos p ON c.productos_codigo = p.codigo 
                    WHERE c.pedidos_id = '$id'";

    $resultadoProductos = $conn->query($sqlproductos);
    $total = 0;

    $datosQR = "RECIBO DE PEDIDO #" . ($pedido["id"] ?? '') . "\n" .
               "Cliente: " . ($pedido["nombre"] ?? 'Cliente') . "\n" .
               "--------------------------\n";

    if ($resultadoProductos && $resultadoProductos->num_rows > 0) {
        while ($producto = $resultadoProductos->fetch_assoc()) {
            $cant = $producto["cantidad"] ?? 1;
            $precioUnit = $producto["precio"] ?? 0;
            $subtotal = $producto["costototal"] ?? ($cant * $precioUnit);
            $total += $subtotal;

            echo "
            <div class='producto-item'>
                <strong>" . htmlspecialchars($producto["nombre"]) . "</strong>
                <span>Cantidad: " . htmlspecialchars($cant) . "</span> | 
                <span>Subtotal: Bs. " . htmlspecialchars($subtotal) . "</span>
            </div>";

            $datosQR .= $producto["nombre"] . " x" . $cant . " = Bs. " . $subtotal . "\n";
        }
    } else {
        echo "<p style='text-align:center; color:#666;'>Sin productos registrados.</p>";
    }

    $datosQR .= "--------------------------\nTOTAL: Bs. " . $total;
    $qr = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($datosQR);
    ?>

    <div class="total-box">
        Total: Bs. <?php echo $total; ?>
    </div>

    <div class="qr-recibo">
        <h3>Código de Verificación</h3>
        <img src="<?php echo $qr; ?>" alt="Código QR del recibo">
        <p>Escanea este código para validar la información del pedido.</p>
    </div>
</div>

<div class="acciones">
    <button class="btn-imprimir" onclick="window.print()">Imprimir</button>
    <button class="btn-volver" id="volverProductos">Volver a Productos</button>
</div>

<script>
document.getElementById("volverProductos").addEventListener("click", () => {
    window.location.href = "../paginaproductos.php";
});
</script>

</body>
</html>