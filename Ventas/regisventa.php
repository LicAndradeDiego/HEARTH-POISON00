<?php
session_start();

$conn = new mysqli("localhost", "root", "", "proyetocuba");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$pedido_id_input = $_REQUEST['pedidos_id'] ?? $_REQUEST['pedido_id'] ?? null;

if (empty($pedido_id_input)) {
    header("Location: ../vendedor.php");
    exit();
}

$id_pedido = (int)$pedido_id_input;

// VERIFICAR EXISTENCIA DEL PEDIDO EN LA BASE DE DATOS
$stmtCheck = $conn->prepare("SELECT id FROM pedidos WHERE id = ?");
$stmtCheck->bind_param("i", $id_pedido);
$stmtCheck->execute();
$resCheck = $stmtCheck->get_result();

if (!$resCheck || $resCheck->num_rows === 0) {
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body style='background-color:#090909;'>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Pedido no encontrado',
                text: 'El pedido #" . htmlspecialchars($id_pedido) . " no existe en la base de datos.',
                confirmButtonColor: '#ffffff',
                confirmButtonText: '<span style=\"color:#000;\">Volver</span>',
                background: '#0f0f0f',
                color: '#fff'
            }).then(() => {
                window.location.href = 'crearventa.php';
            });
        });
    </script>
    </body>
    </html>";
    $stmtCheck->close();
    $conn->close();
    exit();
}
$stmtCheck->close();

$mostrar_modal = false;
$titulo_modal = "";
$mensaje_modal = "";

// PROCESAR BOTONES (ACEPTAR / RECHAZAR / REGISTRAR)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {

    $accion = $_POST['accion'];

    if ($accion === 'aceptar') {

        $conn->autocommit(FALSE);

        try {
            $stmtEstado = $conn->prepare("UPDATE pedidos SET estado = 'Aceptado' WHERE id = ?");
            $stmtEstado->bind_param("i", $id_pedido);
            $stmtEstado->execute();
            $stmtEstado->close();

            $productosAgotados = [];
            $costoTotalCalculado = 0.00;

            $stmtCarrito = $conn->prepare("
                SELECT 
                    c.productos_codigo,
                    c.cantidad,
                    c.costototal,
                    p.nombre
                FROM carrito c
                INNER JOIN productos p ON c.productos_codigo = p.codigo
                WHERE c.pedidos_id = ?
            ");
            $stmtCarrito->bind_param("i", $id_pedido);
            $stmtCarrito->execute();
            $resCarritoPost = $stmtCarrito->get_result();

            if ($resCarritoPost && $resCarritoPost->num_rows > 0) {

                $stmtUpdateStock = $conn->prepare("
                    UPDATE productos 
                    SET stock = GREATEST(0, stock - ?) 
                    WHERE codigo = ?
                ");

                $stmtCheckStock = $conn->prepare("
                    SELECT stock 
                    FROM productos 
                    WHERE codigo = ?
                ");

                while ($item = $resCarritoPost->fetch_assoc()) {
                    $codigo = $item['productos_codigo'];
                    $cant = (int)$item['cantidad'];
                    $nombreProd = $item['nombre'];
                    $costoTotalCalculado += (float)$item['costototal'];

                    $stmtUpdateStock->bind_param("ii", $cant, $codigo);
                    $stmtUpdateStock->execute();

                    $stmtCheckStock->bind_param("i", $codigo);
                    $stmtCheckStock->execute();
                    $resNuevoStock = $stmtCheckStock->get_result();

                    if ($resNuevoStock && $resNuevoStock->num_rows > 0) {
                        $nuevoStock = (int)$resNuevoStock->fetch_assoc()['stock'];
                        if ($nuevoStock === 0) {
                            $productosAgotados[] = $nombreProd;
                        }
                    }
                }

                $stmtUpdateStock->close();
                $stmtCheckStock->close();
            }
            $stmtCarrito->close();

            $costoFinal = isset($_POST['costoTotal']) ? (float)$_POST['costoTotal'] : $costoTotalCalculado;
            $metodoPago = $_POST['Metodo'] ?? 'Efectivo';

            // CORREGIDO: "ventas" en plural y nombres de variables adaptados
            $stmtVenta = $conn->prepare("
                INSERT INTO ventas (pedidos_id, costoTotal, estado, metodo)
                VALUES (?, ?, 'Aceptado', ?)
            ");
            $stmtVenta->bind_param("ids", $id_pedido, $costoFinal, $metodoPago);
            $stmtVenta->execute();
            $stmtVenta->close();

            $conn->commit();

            $mostrar_modal = true;
            $titulo_modal = "¡Pedido Guardado Exitosamente!";

            if (!empty($productosAgotados)) {
                $listaAgotados = htmlspecialchars(implode(", ", $productosAgotados));
                $mensaje_modal = "El pedido #" . sprintf('%03d', $id_pedido) . " fue procesado con éxito.<br><br><span style='color:#d9534f; font-weight:bold;'>Atención:</span> Se vendió el/los último(s) producto(s) en stock de: <strong>$listaAgotados</strong>. Su stock actual es 0.";
            } else {
                $mensaje_modal = "El pedido #" . sprintf('%03d', $id_pedido) . " ha sido aceptado y registrado en el sistema correctamente.";
            }

        } catch (Exception $e) {
            $conn->rollback();
            die("Ocurrió un error al procesar la venta: " . $e->getMessage());
        } finally {
            $conn->autocommit(TRUE);
        }

    } elseif ($accion === 'rechazar') {

        $stmtRechazar = $conn->prepare("UPDATE pedidos SET estado = 'Cancelado' WHERE id = ?");
        $stmtRechazar->bind_param("i", $id_pedido);
        $stmtRechazar->execute();
        $stmtRechazar->close();

        header("Location: ../vendedor.php");
        exit();
    }
}

// CONSULTA DE DATOS PARA VISTA
$stmtPedido = $conn->prepare("SELECT * FROM pedidos WHERE id = ?");
$stmtPedido->bind_param("i", $id_pedido);
$stmtPedido->execute();
$resPedido = $stmtPedido->get_result();
$pedido = $resPedido->fetch_assoc();
$stmtPedido->close();

$cliente_nombre = $pedido['nombre'] ?? $pedido['Nombre'] ?? 'Desconocido';
$cliente_telefono = $pedido['telefono'] ?? $pedido['Telefono'] ?? 'No registrado';
$cliente_direccion = $pedido['direccion'] ?? $pedido['Direccion'] ?? 'No registrada';
$pedido_estado = $pedido['estado'] ?? $pedido['Estado'] ?? 'En Proceso';
$pedido_fecha = $pedido['fecha'] ?? $pedido['Fecha'] ?? null;

$stmtCarritoView = $conn->prepare("
    SELECT 
        c.cantidad,
        c.costototal,
        p.nombre,
        p.precio,
        p.stock
    FROM carrito c
    INNER JOIN productos p ON c.productos_codigo = p.codigo
    WHERE c.pedidos_id = ?
");
$stmtCarritoView->bind_param("i", $id_pedido);
$stmtCarritoView->execute();
$resCarrito = $stmtCarritoView->get_result();

$total = 0.00;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atender Pedido #<?php echo sprintf('%03d', $id_pedido); ?> - Vakery's</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f4f6f4;
            color: #2D3A2F;
            padding: 20px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .main-container {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #7d8f78;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .header-pedido {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .header-pedido h1 {
            font-size: 28px;
            font-weight: 800;
            color: #1f2d25;
        }

        .badge-estado {
            background-color: #A2B38B;
            color: #1f2d25;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .btn-volver-link {
            display: inline-block;
            margin-bottom: 25px;
            font-weight: 600;
            color: #2D3A2F;
            font-size: 13px;
        }

        .card-cliente {
            border: 1px solid #7d8f78;
            border-radius: 18px;
            padding: 20px 25px;
            background-color: #fcfdfc;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .cliente-info h2 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 8px;
            color: #1f2d25;
        }

        .cliente-info p {
            font-size: 13px;
            color: #4a5a4d;
            margin-bottom: 4px;
        }

        .cliente-fecha {
            text-align: right;
            font-size: 12px;
            color: #4a5a4d;
            font-weight: 600;
        }

        .card-productos {
            border: 1px solid #7d8f78;
            border-radius: 18px;
            padding: 20px 25px;
            background-color: #ffffff;
        }

        .card-productos h3 {
            font-size: 14px;
            font-weight: 700;
            color: #1f2d25;
            margin-bottom: 15px;
        }

        .tabla-productos {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-productos th {
            background-color: #B4C49A;
            color: #1f2d25;
            padding: 10px 15px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
        }

        .tabla-productos td {
            padding: 14px 15px;
            font-size: 13px;
            color: #333333;
        }

        .tabla-productos tr:not(.total-row) td {
            border-bottom: 1px solid #eaeaea;
        }

        .tabla-productos td.empty-msg {
            text-align: center;
            padding: 25px;
            color: #666;
            font-size: 13px;
        }

        .total-row td {
            padding-top: 15px;
            font-size: 13px;
            color: #1f2d25;
        }

        .total-row .total-label {
            text-align: right;
            font-weight: 700;
        }

        .total-row .total-monto {
            font-weight: 800;
        }

        .acciones-form {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .btn-accion {
            padding: 8px 24px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
        }

        .btn-aceptar {
            background-color: #B4C49A;
            color: #1f2d25;
        }

        .btn-aceptar:hover {
            background-color: #9eb083;
        }

        .btn-rechazar {
            background-color: #D9534F;
            color: #ffffff;
        }

        .btn-rechazar:hover {
            background-color: #c9302c;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-contenedor {
            background-color: #ffffff;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-top: 6px solid #B4C49A;
        }

        .modal-icono {
            width: 50px;
            height: 50px;
            background-color: #B4C49A;
            color: #1f2d25;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin: 0 auto 15px auto;
        }

        .modal-titulo {
            font-size: 16px;
            color: #1f2d25;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .modal-mensaje {
            font-size: 13px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .modal-btn {
            display: block;
            width: 100%;
            background-color: #1f2d25;
            color: #ffffff;
            padding: 10px 0;
            border-radius: 6px;
            font-weight: bold;
            font-size: 13px;
        }
    </style>
</head>

<body>

<?php include_once "../header.php"; ?>

<?php if ($mostrar_modal): ?>
<div class="modal-overlay">
    <div class="modal-contenedor">
        <div class="modal-icono">&#10003;</div>
        <h2 class="modal-titulo"><?php echo htmlspecialchars($titulo_modal); ?></h2>
        <p class="modal-mensaje"><?php echo $mensaje_modal; ?></p>
        <a href="../vendedor.php" class="modal-btn">Continuar</a>
    </div>
</div>
<?php endif; ?>

<div class="main-container">
    <div class="header-pedido">
        <h1>Atender Pedido #<?php echo sprintf('%03d', $id_pedido); ?></h1>
        <span class="badge-estado"><?php echo htmlspecialchars($pedido_estado); ?></span>
    </div>

    <a href="../vendedor.php" class="btn-volver-link">&larr; Volver a lista de pedidos</a>

    <div class="card-cliente">
        <div class="cliente-info">
            <h2>Cliente: <?php echo htmlspecialchars($cliente_nombre); ?></h2>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($cliente_telefono); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($cliente_direccion); ?></p>
        </div>

        <div class="cliente-fecha">
            <p><strong>Fecha:</strong> <?php echo $pedido_fecha ? date('d M Y', strtotime($pedido_fecha)) : '--'; ?></p>
            <p><strong>Hora:</strong> <?php echo $pedido_fecha ? date('h:i A', strtotime($pedido_fecha)) : '--'; ?></p>
        </div>
    </div>

    <div class="card-productos">
        <h3>Productos Solicitados</h3>

        <table class="tabla-productos">
            <thead>
                <tr>
                    <th style="width: 30%;">Producto</th>
                    <th style="width: 20%;">Stock Actualizado</th>
                    <th style="width: 18%;">Precio Unitario</th>
                    <th style="width: 17%;">Cantidad Solicitada</th>
                    <th style="width: 15%;">Subtotal</th>
                </tr>
            </thead>

            <tbody>
            <?php
            if ($resCarrito && $resCarrito->num_rows > 0) {
                while ($prod = $resCarrito->fetch_assoc()) {
                    $subtotal = (float)$prod['costototal'];
                    $total += $subtotal;
                    $esUltimoStock = ($prod['stock'] <= $prod['cantidad']);
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                    <td style="color: <?php echo $esUltimoStock ? '#d9534f' : '#2e7d32'; ?>; font-weight: 600;">
                        <?php echo (int)$prod['stock']; ?> unids.
                        <?php if ($esUltimoStock): ?>
                            <br><small style='color:#d9534f;'>(Último(s) producto(s) en stock)</small>
                        <?php endif; ?>
                    </td>
                    <td>Bs. <?php echo number_format($prod['precio'], 2); ?></td>
                    <td><?php echo (int)$prod['cantidad']; ?></td>
                    <td>Bs. <?php echo number_format($subtotal, 2); ?></td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5" class="empty-msg">No hay productos asociados a este pedido.</td>
                </tr>
            <?php
            }
            ?>
                <tr class="total-row">
                    <td colspan="4" class="total-label">Total General:</td>
                    <td class="total-monto">Bs. <?php echo number_format($total, 2); ?></td>
                </tr>
            </tbody>
        </table>

        <form method="post" class="acciones-form">
            <input type="hidden" name="costoTotal" value="<?php echo $total; ?>">

            <button type="submit" name="accion" value="rechazar" class="btn-accion btn-rechazar">
                RECHAZAR
            </button>

            <button type="submit" name="accion" value="aceptar" class="btn-accion btn-aceptar">
                ACEPTAR
            </button>
        </form>
    </div>
</div>

<?php include_once "../footer.php"; ?>

</body>
</html>