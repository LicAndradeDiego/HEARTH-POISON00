<?php
session_start();

$conexion = new mysqli("localhost","root","","proyetocuba");

$nombre = $_SESSION['nombre'];

$sql = "
SELECT *
FROM pedidos
WHERE nombre_vendedor='$nombre'
ORDER BY fecha DESC
";

$resultado = $conexion->query($sql);
?>

<?php include '../header.php'; ?>

<h1>Mis Ventas</h1>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Fecha</th>
    <th>Estado</th>
</tr>

<?php while($fila = $resultado->fetch_assoc()){ ?>
<tr>
    <td><?= $fila['id'] ?></td>
    <td><?= $fila['nombre'] ?></td>
    <td><?= $fila['fecha'] ?></td>
    <td><?= $fila['estado'] ?></td>
</tr>
<?php } ?>

</table>