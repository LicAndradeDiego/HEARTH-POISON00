<?php
require_once __DIR__ . '/usuario/auth_admin.php';
$conn = new mysqli("localhost","root","","proyetocuba");
if ($conn->connect_error) die("Error de conexión: ".$conn->connect_error);

// Ventas reales: ventas aceptadas, vinculadas con la fecha del pedido.
$ventasDia = $conn->query("
    SELECT COALESCE(SUM(v.costoTotal),0) total
    FROM ventas v INNER JOIN pedidos p ON p.id=v.pedidos_id
    WHERE DATE(p.fecha)=CURDATE() AND LOWER(v.estado)='aceptado'
")->fetch_assoc()['total'];

$ventasSemana = $conn->query("
    SELECT COALESCE(SUM(v.costoTotal),0) total
    FROM ventas v INNER JOIN pedidos p ON p.id=v.pedidos_id
    WHERE YEARWEEK(p.fecha,1)=YEARWEEK(CURDATE(),1) AND LOWER(v.estado)='aceptado'
")->fetch_assoc()['total'];

$ventasMes = $conn->query("
    SELECT COALESCE(SUM(v.costoTotal),0) total
    FROM ventas v INNER JOIN pedidos p ON p.id=v.pedidos_id
    WHERE YEAR(p.fecha)=YEAR(CURDATE()) AND MONTH(p.fecha)=MONTH(CURDATE()) AND LOWER(v.estado)='aceptado'
")->fetch_assoc()['total'];

$ventasAnio = $conn->query("
    SELECT COALESCE(SUM(v.costoTotal),0) total
    FROM ventas v INNER JOIN pedidos p ON p.id=v.pedidos_id
    WHERE YEAR(p.fecha)=YEAR(CURDATE()) AND LOWER(v.estado)='aceptado'
")->fetch_assoc()['total'];

$masVendido = $conn->query("
    SELECT pr.nombre, SUM(c.cantidad) cantidad
    FROM carrito c
    INNER JOIN productos pr ON pr.codigo=c.productos_codigo
    INNER JOIN pedidos p ON p.id=c.pedidos_id
    INNER JOIN ventas v ON v.pedidos_id=p.id
    WHERE YEAR(p.fecha)=YEAR(CURDATE()) AND MONTH(p.fecha)=MONTH(CURDATE())
      AND LOWER(v.estado)='aceptado'
    GROUP BY pr.codigo, pr.nombre
    ORDER BY cantidad DESC
    LIMIT 1
")->fetch_assoc();

$clienteFrecuente = $conn->query("
    SELECT p.nombre cliente, COUNT(*) pedidos
    FROM pedidos p
    INNER JOIN ventas v ON v.pedidos_id=p.id
    WHERE LOWER(v.estado)='aceptado'
    GROUP BY p.nombre
    ORDER BY pedidos DESC, p.nombre ASC
    LIMIT 1
")->fetch_assoc();

$stockBajo = $conn->query("SELECT codigo,nombre,stock FROM productos WHERE stock <= 5 ORDER BY stock ASC, nombre ASC");

$chart = [];
$r = $conn->query("
    SELECT DATE(p.fecha) fecha, COALESCE(SUM(v.costoTotal),0) total
    FROM ventas v INNER JOIN pedidos p ON p.id=v.pedidos_id
    WHERE p.fecha >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND LOWER(v.estado)='aceptado'
    GROUP BY DATE(p.fecha) ORDER BY fecha
");
while($row=$r->fetch_assoc()) $chart[]=$row;
$conn->close();
?>
<!doctype html><html lang="es"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Reportes | Hearth Poison</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
*{box-sizing:border-box}body{margin:0;background:#070707;color:#fff;font-family:Inter,Arial,sans-serif}
main{max-width:1300px;margin:130px auto 80px;padding:0 30px}.head{text-align:center;margin-bottom:40px}
.head h1{font-size:42px;font-weight:300;letter-spacing:5px;text-transform:uppercase}.head p{color:#888}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:18px}
.card{background:#111;border:1px solid #242424;border-radius:18px;padding:24px}.label{font-size:11px;color:#888;text-transform:uppercase;letter-spacing:2px}.value{font-size:28px;margin-top:10px}.sub{font-size:13px;color:#aaa;margin-top:8px}
.panel{background:#101010;border:1px solid #242424;border-radius:18px;padding:25px;margin-top:22px}.panel h2{font-size:18px;font-weight:400;letter-spacing:2px}
.chart-wrap{height:330px}.low{color:#ff6262;font-weight:700}.ok{color:#77d977}.btn{display:inline-block;margin-top:20px;padding:12px 20px;background:#fff;color:#000;border-radius:9px;text-decoration:none;font-weight:700}
table{width:100%;border-collapse:collapse}th,td{padding:12px;border-bottom:1px solid #222;text-align:left}th{color:#888;font-size:11px;text-transform:uppercase;letter-spacing:1px}
</style></head><body>
<?php include 'header.php'; ?>
<main>
<div class="head"><h1>Reportes</h1><p>Indicadores construidos únicamente con las ventas registradas.</p></div>
<div class="grid">
<div class="card"><div class="label">Ventas de hoy</div><div class="value">Bs. <?=number_format($ventasDia,2)?></div></div>
<div class="card"><div class="label">Ventas de la semana</div><div class="value">Bs. <?=number_format($ventasSemana,2)?></div></div>
<div class="card"><div class="label">Ventas del mes</div><div class="value">Bs. <?=number_format($ventasMes,2)?></div></div>
<div class="card"><div class="label">Ventas del año</div><div class="value">Bs. <?=number_format($ventasAnio,2)?></div></div>
<div class="card"><div class="label">Más vendido este mes</div><div class="value"><?=htmlspecialchars($masVendido['nombre']??'Sin ventas')?></div><div class="sub"><?=isset($masVendido['cantidad'])?(int)$masVendido['cantidad'].' unidades':'-'?></div></div>
<div class="card"><div class="label">Cliente más frecuente</div><div class="value"><?=htmlspecialchars($clienteFrecuente['cliente']??'Sin datos')?></div><div class="sub"><?=isset($clienteFrecuente['pedidos'])?(int)$clienteFrecuente['pedidos'].' pedidos':'-'?></div></div>
</div>
<div class="panel"><h2>Ingresos de los últimos 7 días</h2><div class="chart-wrap"><canvas id="ventasChart"></canvas></div></div>
<div class="panel"><h2>Productos con bajo stock</h2>
<?php if($stockBajo && $stockBajo->num_rows): ?><table><tr><th>Código</th><th>Producto</th><th>Stock</th></tr>
<?php while($p=$stockBajo->fetch_assoc()): ?><tr><td><?=$p['codigo']?></td><td><?=htmlspecialchars($p['nombre'])?></td><td class="low"><?=$p['stock']?> unidades</td></tr><?php endwhile; ?></table>
<?php else: ?><p class="ok">No hay productos con stock bajo.</p><?php endif; ?>
<a class="btn" href="productos/leerproducto.php">Gestionar inventario</a></div>
</main>
<script>
const datos=<?=json_encode($chart,JSON_UNESCAPED_UNICODE)?>;
new Chart(document.getElementById('ventasChart'),{type:'line',data:{labels:datos.map(x=>x.fecha),datasets:[{label:'Ingresos (Bs.)',data:datos.map(x=>Number(x.total)),tension:.35,fill:true}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{labels:{color:'#fff'}}},scales:{x:{ticks:{color:'#aaa'},grid:{color:'#222'}},y:{ticks:{color:'#aaa'},grid:{color:'#222'}}}}});
</script>
</body></html>
