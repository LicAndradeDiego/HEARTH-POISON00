<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM pedidos";
?>

<style>

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Helvetica Neue', Arial, sans-serif;
}

body{
    background: #090909;
    color: #ffffff;
    overflow-x: hidden;
}

.contenedor{
    max-width: 1200px;
    margin: 120px auto 60px auto;
    padding: 40px;
    background: #0f0f0f;
    border: 1px solid #1a1a1a;
    border-radius: 20px;
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
    margin-bottom:40px;
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
    font-size:13px;
    color:#ccc;
    border-bottom:1px solid #1a1a1a;
}

.tabla-estilo tr:hover{
    background:#151515;
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

.eliminar{
    background:#1a1a1a;
    border:1px solid #333;
    color:#fff;
}

.eliminar:hover{
    background:#b30000;
    border-color:#b30000;
}

.mostrar{
    background:transparent;
    border:1px solid #444;
    color:#ccc;
}

.mostrar:hover{
    border-color:#fff;
    color:#fff;
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

<?php include '../header.php'; ?>

<div class="contenedor">

<h1>Gestión de Pedidos</h1>

<p class="subtitulo">
    Lista completa de pedidos registrados
</p>

<?php

echo "<table class='tabla-estilo'>";

echo "
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Nombre Vendedor</th>
    <th>Acciones</th>
</tr>
";

$resultado = $conn->query($sql);

if($resultado->num_rows > 0){

    while($fila = $resultado->fetch_assoc()){

        $id = $fila['id'];

        echo "
        <tr>

            <td>".$fila['id']."</td>
            <td>".$fila['nombre']."</td>
            <td>".$fila['fecha']."</td>
            <td>".$fila['estado']."</td>
            <td>".$fila['nombre_vendedor']."</td>

            <td>

                <a href='actualizarpedido.php?id=$id'>
                    <button class='editar'>Editar</button>
                </a>

                <a href='../carrito/miCarrito.php?idPedido=$id'>
                    <button class='mostrar'>Mostrar</button>
                </a>

                <a href='eliminarpedido.php?id=$id'>
                    <button class='eliminar'>Eliminar</button>
                </a>

            </td>

        </tr>
        ";
    }
}

echo "</table>";

$conn->close();

?>

<div class="boton-centro">

    <a href="crearpedido.php">
        <button class="nuevo">
            Nuevo Pedido
        </button>
    </a>

</div>

</div>