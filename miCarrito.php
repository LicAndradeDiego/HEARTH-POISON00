<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "proyetocuba";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

session_start();

$id_pedido = $_GET['idPedido'] ?? 0;
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);

$sqlTotal = "SELECT SUM(CostoTotal) AS total FROM carrito WHERE pedidos_id='$id_pedido'";
$resultadoTotal = $conn->query($sqlTotal);
$res = $resultadoTotal->fetch_assoc();
$total = $res['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrito</title>
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Helvetica Neue', Arial, sans-serif;
}

body{
    background:#090909;
    color:#fff;
}

.contenedor{
    max-width:1200px;
    margin:120px auto 60px auto;
    padding:40px;
    background:#0f0f0f;
    border:1px solid #1a1a1a;
    border-radius:20px;
}

h1{
    text-align:center;
    font-size:34px;
    font-weight:300;
    letter-spacing:6px;
    text-transform:uppercase;
    margin-bottom:10px;
}

.subtitulo{
    text-align:center;
    color:#777;
    font-size:13px;
    letter-spacing:2px;
    text-transform:uppercase;
    margin-bottom:25px;
}

.total{
    text-align:center;
    margin-bottom:30px;
    font-weight:300;
    letter-spacing:2px;
}

.tabla-estilo{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:12px;
    background:#111;
    border:1px solid #1a1a1a;
}

.tabla-estilo th{
    padding:18px;
    font-size:12px;
    letter-spacing:3px;
    text-transform:uppercase;
    color:#fff;
    border-bottom:1px solid #1f1f1f;
    font-weight:400;
}

.tabla-estilo td{
    padding:16px;
    text-align:center;
    color:#ccc;
    border-bottom:1px solid #1a1a1a;
}

.tabla-estilo tr:hover{
    background:#151515;
}

.form-agregar{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
}

.form-agregar input[type="number"]{
    width:70px;
    padding:8px;
    background:#151515;
    border:1px solid #333;
    color:white;
    border-radius:6px;
    text-align:center;
}

button{
    border:none;
    padding:8px 14px;
    border-radius:6px;
    font-size:11px;
    letter-spacing:2px;
    text-transform:uppercase;
    cursor:pointer;
    transition:.3s ease;
}

.editar{
    background:transparent;
    border:1px solid #666;
    color:#fff;
}

.editar:hover{
    background:#fff;
    color:#000;
}

.nuevo{
    margin-top:30px;
    padding:14px 28px;
    background:#fff;
    color:#000;
    font-size:12px;
    letter-spacing:3px;
    text-transform:uppercase;
}

.nuevo:hover{
    background:#000;
    color:#fff;
    border:1px solid #fff;
}

.boton-centro{
    display:flex;
    justify-content:center;
    margin-top:30px;
}

a{
    text-decoration:none;
}

</style>

</head>
<body>
<?php include_once "../header.php"; ?>
<div class="contenedor">

    <h1>Carrito</h1>
    <p class="subtitulo">Gestión de productos para pedidos</p>

    <h3 class="total">Total: Bs. <?php echo $total; ?></h3>

    <table class="tabla-estilo">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
      
            <th>Agregar al carrito</th>
        </tr>

        <?php while($fila = $resultado->fetch_assoc()){ ?>

        <tr>
            <td><?php echo $fila["codigo"]; ?></td>
            <td><?php echo $fila["nombre"]; ?></td>
            <td><?php echo $fila["descripcion"]; ?></td>
            <td>Bs. <?php echo $fila["precio"]; ?></td>



            <td>
                <form action="agregarcarrito.php" method="post" class="form-agregar">

                    <input type="hidden" name="codigo" value="<?php echo $fila['codigo']; ?>">
                    <input type="hidden" name="idpedido" value="<?php echo $id_pedido; ?>">
                    <input type="hidden" name="precio" value="<?php echo $fila['precio']; ?>">

                    <input
                        type="number"
                        name="cantidad"
                        value="1"
                        min="1"
                        required
                    >

                    <button type="submit" class="editar">
                        Agregar
                    </button>

                </form>
            </td>
        </tr>

        <?php } ?>
    </table>

    <div class="boton-centro">
        <a href="../pedidos/crearpedido.php">
            <button class="nuevo">
                Generar Nuevo Pedido
            </button>
        </a>
    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>