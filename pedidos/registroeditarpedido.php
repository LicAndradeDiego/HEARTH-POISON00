<?php

$conexion = new mysqli("localhost", "root", "", "proyetocuba");

if ($conexion->connect_error) {
    die("Conexion fallida: " . $conexion->connect_error);
}

$id = $_POST['id'];
$Nombre = $_POST['Nombre'];
$Fecha = $_POST['Fecha'];
$Estado = $_POST['Estado'];
$nombre_vendedor = $_POST['nombre_vendedor'];

// Obtener estado anterior del pedido
$consulta = $conexion->query("SELECT estado FROM pedidos WHERE id = $id");
$anterior = $consulta->fetch_assoc();
$estadoAnterior = $anterior['estado'];

// Actualizar pedido
$sql = "UPDATE pedidos SET
            nombre = '$Nombre',
            fecha = '$Fecha',
            estado = '$Estado',
            nombre_vendedor = '$nombre_vendedor'
        WHERE id = '$id'";

if ($conexion->query($sql)) {

    // Si el pedido pasa a Entregado por primera vez
    if ($Estado == 'Entregado' && $estadoAnterior != 'Entregado') {

        $detalle = $conexion->query("
            SELECT productos_codigo, cantidad
            FROM carrito
            WHERE pedidos_id = $id
        ");

        while ($item = $detalle->fetch_assoc()) {

            $codigo = $item['productos_codigo'];
            $cantidad = $item['cantidad'];

            $conexion->query("
                UPDATE productos
                SET stock = stock - $cantidad
                WHERE codigo = $codigo
            ");
        }
    }

    header("Location: leerpedido.php");
    exit();

} else {

    echo "Error: " . $conexion->error;

}

?>