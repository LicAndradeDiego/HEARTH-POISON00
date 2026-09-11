<?php
session_start();

// Verificación de sesión y nombre
$nombre = $_SESSION['nombre'] ?? $_SESSION['Nombre'] ?? 'Vendedor';

// Conexión unificada a la base de datos proyetocuba
$conn = new mysqli("localhost", "root", "", "proyetocuba");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 1. Contar pedidos pendientes (excluyendo Aceptado y Cancelado)
$resTotalPedidos = $conn->query("SELECT COUNT(*) AS total FROM pedidos WHERE estado IS NULL OR estado NOT IN ('Aceptado', 'Cancelado')");
$totalPedidosHoy = ($resTotalPedidos) ? $resTotalPedidos->fetch_assoc()['total'] : 0;

// 2. Sumar el Stock total disponible en productos
$resStockTotal = $conn->query("SELECT SUM(stock) AS total_stock FROM productos");
$stockTotal = ($resStockTotal) ? $resStockTotal->fetch_assoc()['total_stock'] : 0;

// 3. Consultar pedidos pendientes o activos con resumen de carrito
$sqlPedidos = "SELECT p.*, 
               GROUP_CONCAT(CONCAT(pr.nombre, ' x', c.cantidad) SEPARATOR '<br>') AS resumen_productos,
               SUM(c.costototal) AS total_calculado
               FROM pedidos p
               LEFT JOIN carrito c ON p.id = c.pedidos_id
               LEFT JOIN productos pr ON c.productos_codigo = pr.codigo
               WHERE p.estado IS NULL OR p.estado NOT IN ('Aceptado', 'Cancelado')
               GROUP BY p.id
               ORDER BY p.id DESC";

$resPedidos = $conn->query($sqlPedidos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Vendedor | Hearth Poison</title>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: radial-gradient(circle at top right, #1a1a1a 0%, #050505 45%), #050505;
            color: #fff;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        main {
            max-width: 1400px;
            margin: 100px auto 60px;
            padding: 0 50px;
        }

        .titulo {
            text-align: center;
            margin-bottom: 60px;
        }

        .titulo span {
            color: #8d8d8d;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .titulo h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4.5rem;
            font-weight: 500;
            margin-top: 10px;
            letter-spacing: 2px;
        }

        .titulo p {
            max-width: 650px;
            margin: 20px auto 0;
            color: #a5a5a5;
            line-height: 1.8;
        }

        /* PANEL DE TARJETAS PRINCIPALES */
        .panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 80px;
        }

        .card {
            background: linear-gradient(180deg, #161616, #0d0d0d);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 35px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05), transparent 70%);
        }

        .card:hover {
            transform: translateY(-8px);
            border-color: rgba(255, 255, 255, 0.25);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
        }

        .icono {
            width: 65px;
            height: 65px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 16px;
            font-size: 28px;
            background: linear-gradient(135deg, #374151, #1f2937);
            margin-bottom: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .icono img {
            width: 32px;
            height: 32px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .card h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 500;
            margin-bottom: 12px;
            color: #f3f4f6;
        }

        .card p {
            color: #9ca3af;
            line-height: 1.7;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4b5563, #374151);
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: fit-content;
        }

        .btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #6b7280, #4b5563);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        /* BOTÓN CERRAR SESIÓN FLOTANTE */
        .cerrar {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #fff;
            padding: 12px 20px;
            border-radius: 14px;
            background: linear-gradient(135deg, #374151, #1f2937);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: .3s;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .cerrar:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #4b5563, #374151);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.7);
        }

        .cerrar img {
            width: 18px;
            height: 18px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .cerrar span {
            font-size: .8rem;
            letter-spacing: 1px;
            font-weight: 500;
        }

        /* =========================================================
           SECCIÓN DE PEDIDOS Y TARJETAS DE ATENCIÓN (ESTILO OSCURO Y GRISÁCEO)
           ========================================================= */
        .b {
            max-width: 1400px;
            margin: 0 auto 120px;
            padding: 0 50px;
        }

        .ba {
            background: linear-gradient(180deg, #121212, #080808);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
        }

        .bb {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 35px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .bb h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            font-weight: 500;
            color: #f3f4f6;
            letter-spacing: 1px;
        }

        .bb-img {
            width: 38px;
            height: 38px;
            object-fit: contain;
            filter: brightness(0) invert(0.8);
        }

        /* TARJETA DE CADA PEDIDO */
        .bf {
            background: #18181b;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .bf:hover {
            border-color: rgba(255, 255, 255, 0.18);
            background: #1f1f23;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .bg {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .bc h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            color: #f3f4f6;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .bc p {
            color: #9ca3af;
            font-size: 0.95rem;
        }

        .bd {
            text-align: right;
        }

        .bd h3 {
            font-size: 1.4rem;
            color: #e5e7eb;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .bd p {
            color: #6b7280;
            font-size: 0.82rem;
            line-height: 1.3;
        }

        .be {
            background: #111113;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.03);
            margin-bottom: 20px;
        }

        .be p {
            color: #d1d5db;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .be strong {
            color: #9ca3af;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }

        /* BOTÓN ATENDER PEDIDO */
        .btn-atender {
            display: block;
            width: 100%;
            text-align: center;
            background: linear-gradient(135deg, #4b5563, #374151);
            color: #ffffff;
            padding: 14px 0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-atender:hover {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        /* BOTÓN VER TODOS LOS PEDIDOS AL FINAL */
        .b-boton {
            margin-top: 30px;
            background: #1f2937;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 18px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .b-boton h1 {
            font-size: 1rem;
            color: #e5e7eb;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .b-boton:hover {
            background: #374151;
            transform: translateY(-2px);
        }

        @media(max-width: 900px) {
            main, .b {
                padding: 0 20px;
            }
            .titulo h1 {
                font-size: 3.2rem;
            }
            .ba {
                padding: 25px;
            }
        }
    </style>
</head>

<body>

<?php include 'header.php'; ?>

<a href="usuario/cerrarsesion.php" class="cerrar">
    <img src="imagenes/cerrar.png" alt="Salir">
    <span>Cerrar Sesión</span>
</a>

<main>
    <div class="titulo">
        <span>Panel de Vendedor</span>
        <h1>¡Bienvenido/a, <?php echo htmlspecialchars($nombre); ?>!</h1>
        <p>
            Gestiona ventas, pedidos e inventario desde una plataforma
            diseñada para mantener la experiencia premium de Hearth Poison.
        </p>
    </div>

    <div class="panel">
        <div class="card">
            <div>
                <div class="icono"><img src="imagenes/ventas.png" alt="Stock"></div>
                <h2>Stock</h2>
                <p>Consulta el inventario total disponible actualmente en el sistema (<strong><?php echo $stockTotal ? $stockTotal : 0; ?></strong> unidades).</p>
            </div>
            <a href="productos/leerproducto.php" class="btn">Ver stock &rarr;</a>
        </div>

        <div class="card">
            <div>
                <div class="icono"><img src="imagenes/entrega-de-pedidos.png" alt="Ingresar"></div>
                <h2>Ingresar Pedido</h2>
                <p>Crea manualmente un nuevo pedido directo para un cliente en caja o venta telefónica.</p>
            </div>
            <a href="pedidos/crearpedido.php" class="btn">Crear Pedido &rarr;</a>
        </div>

        <div class="card">
            <div>
                <div class="icono"><img src="imagenes/inventario-disponible.png" alt="Historial"></div>
                <h2>Historial Pedidos</h2>
                <p>Revisa el historial completo de todos los pedidos ingresados y procesados.</p>
            </div>
            <a href="pedidos/leerpedido.php" class="btn">Ver Pedidos &rarr;</a>
        </div>

        <div class="card">
            <div>
                <div class="icono"><img src="imagenes/ventas.png" alt="Ventas"></div>
                <h2>Historial Ventas</h2>
                <p>Consulta los ingresos finalizados, registros de ventas y reportes de cobranza.</p>
            </div>
            <a href="Ventas/leerventa.php" class="btn">Ver Ventas &rarr;</a>
        </div>
    </div>
</main>

<div class="b">
    <div class="ba">
        <div class="bb">
            <h1>Pedidos Pendientes (<?php echo $totalPedidosHoy; ?>)</h1>
            <img class="bb-img" src="imagenes/bolsa-de-la-compra.png" alt="Ícono Pedidos">
        </div>

        <?php if ($resPedidos && $resPedidos->num_rows > 0) { ?>
            <?php while ($ped = $resPedidos->fetch_assoc()) { ?>
                <div class="bf">
                    <div class="bg">
                        <div class="bc">
                            <h2>Pedido #<?php echo sprintf('%03d', $ped['id']); ?></h2>
                            <p><?php echo htmlspecialchars($ped['Nombre']); ?></p>
                        </div>
                        <div class="bd">
                            <h3>Bs <?php echo number_format($ped['total_calculado'] ? $ped['total_calculado'] : 0, 2); ?></h3>
                            <p><?php echo date('d M Y', strtotime($ped['Fecha'])); ?></p>
                            <p><?php echo date('h:i A', strtotime($ped['Fecha'])); ?></p>
                        </div>
                    </div>

                    <div class="be">
                        <p><strong>Productos asociados:</strong><br>
                        <?php echo $ped['resumen_productos'] ? $ped['resumen_productos'] : "Sin productos asignados"; ?>
                        </p>
                    </div>

                    <a href="Ventas/regisventa.php?pedido_id=<?php echo $ped['id']; ?>" class="btn-atender">
                        Atender Pedido
                    </a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="bf" style="text-align: center; padding: 40px; color: #9ca3af;">
                <p>No hay pedidos pendientes por atender en este momento.</p>
            </div>
        <?php } ?>

        <a href="pedidos/leerpedido.php">
            <div class="b-boton">
                <h1>Ver Todos los Pedidos</h1>
            </div>
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>