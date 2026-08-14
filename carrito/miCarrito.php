<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "proyetocuba";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id_pedido = isset($_GET['idPedido']) ? (int)$_GET['idPedido'] : 0;

$sql = "SELECT codigo, nombre, descripcion, stock, precio FROM productos";
$resultado = $conn->query($sql);

$total = 0.00;
if ($id_pedido > 0) {
    $stmtTotal = $conn->prepare("SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id = ?");
    $stmtTotal->bind_param("i", $id_pedido);
    $stmtTotal->execute();
    $resTotal = $stmtTotal->get_result()->fetch_assoc();
    $total = $resTotal['total'] ?? 0.00;
    $stmtTotal->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #E5E7EB; /* Gris claro de fondo */
            padding: 35px;
            margin-top: 75px;
            color: #374151;
        }

        .contenedor {
            background: #FFFFFF;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #D1D5DB;
        }

        h1 {
            text-align: center;
            color: #1F2937; /* Gris oscuro */
            font-size: 38px;
            margin-bottom: 5px;
        }

        .subtitulo {
            text-align: center;
            color: #6B7280; /* Gris medio */
            margin-bottom: 30px;
            font-size: 15px;
        }

        .total {
            text-align: center;
            color: #111827;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .tabla-estilo {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid #E5E7EB;
        }

        .tabla-estilo th {
            background: #4B5563; /* Gris plomo */
            color: #FFFFFF;
            padding: 15px;
            font-size: 14px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .tabla-estilo td {
            padding: 14px;
            text-align: center;
            background: #F9FAFB;
            border-bottom: 1px solid #E5E7EB;
            color: #374151;
        }

        .tabla-estilo tr:hover td {
            background: #F3F4F6; /* Hover gris suave */
            transition: 0.2s;
        }

        button {
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 2px;
        }

        .editar {
            background: #6B7280; /* Botón gris neutro */
            color: #FFFFFF;
        }

        .editar:hover {
            background: #4B5563;
            transform: translateY(-1px);
        }

        .nuevo {
            margin-top: 25px;
            background: #374151; /* Botones inferiores gris oscuro */
            color: #FFFFFF;
            font-size: 15px;
            padding: 12px 22px;
            border-radius: 8px;
        }

        .nuevo:hover {
            background: #1F2937;
            transform: translateY(-1px);
        }

        .boton-centro {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        input[type="number"] {
            width: 70px;
            padding: 8px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            background: #F9FAFB;
            color: #1F2937;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #6B7280;
        }

        .form-agregar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php include '../header.php'; ?>

<div class="contenedor">

    <h1>Carrito</h1>
    <p class="subtitulo">Gestión de productos para el pedido #<?php echo sprintf('%03d', $id_pedido); ?></p>

    <h3 class="total">Total: Bs. <?php echo number_format($total, 2); ?></h3>

    <table class="tabla-estilo">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Agregar al carrito</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($resultado && $resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()) { 
            ?>
            <tr>
                <td><?php echo htmlspecialchars($fila["codigo"]); ?></td>
                <td><?php echo htmlspecialchars($fila["nombre"]); ?></td>
                <td><?php echo htmlspecialchars($fila["descripcion"] ?? ''); ?></td>
                <td>
                    <?php
                    $stock = (int)$fila["stock"];
                    if ($stock <= 5) {
                        echo "<span style='color:#EF4444; font-weight:bold;'>".$stock."</span>";
                    } else {
                        echo $stock;
                    }
                    ?>
                </td>
                <td>Bs. <?php echo number_format($fila["precio"], 2); ?></td>
                <td>
                    <?php if ($stock > 0): ?>
                    <form action="agregarcarrito.php" method="post" class="form-agregar">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($fila['codigo']); ?>">
                        <input type="hidden" name="idpedido" value="<?php echo $id_pedido; ?>">
                        <input type="hidden" name="precio" value="<?php echo $fila['precio']; ?>">

                        <input 
                            type="number" 
                            name="cantidad" 
                            value="1" 
                            min="1" 
                            max="<?php echo $stock; ?>"
                            required
                        >

                        <button type="submit" class="editar">
                            Agregar
                        </button>
                    </form>
                    <?php else: ?>
                        <span style="color: #9CA3AF; font-weight: bold; font-size: 13px;">Agotado</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php 
                } 
            } else {
            ?>
            <tr>
                <td colspan="6">No hay productos registrados en el sistema.</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="boton-centro">
        <a href="../Pedidos/crearpedido.php">
            <button class="nuevo">
                Generar Nuevo Pedido
            </button>
        </a>

        <a href="../Pedidos/leerpedido.php">
            <button class="nuevo">
                Ver Todos Los Pedidos
            </button>
        </a>
    </div>

</div>

<?php if (isset($_GET["error"]) && $_GET["error"] == "stock"): ?>
<script>
Swal.fire({
    icon: "error",
    title: "Stock insuficiente",
    text: "La cantidad solicitada supera el stock disponible.",
    confirmButtonColor: "#4B5563"
});
</script>
<?php endif; ?>

<?php if (isset($_GET["success"])): ?>
<script>
Swal.fire({
    icon: "success",
    title: "Producto agregado",
    text: "Se agregó correctamente al carrito.",
    timer: 1500,
    showConfirmButton: false
});
</script>
<?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>