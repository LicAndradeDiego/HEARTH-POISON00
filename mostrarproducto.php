<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error){
    die("Error de conexión: " . $conexion->connect_error);
}

if(isset($_GET['codigo'])){
    $codigo = $_GET['codigo'];

    $sql = "SELECT * FROM productos WHERE codigo='$codigo'";
    $resultado = $conexion->query($sql);
} else {
    die("No llegó el código del producto");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalle Producto</title>

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
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.principal{
    width: 420px;
    background:#0f0f0f;
    border:1px solid #1a1a1a;
    border-radius:18px;
    padding:35px;
    box-shadow:0 20px 60px rgba(0,0,0,0.6);
    animation: fadeIn 0.8s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

h2{
    text-align:center;
    font-weight:300;
    letter-spacing:5px;
    text-transform:uppercase;
    margin-bottom:25px;
    font-size:22px;
}

.info{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.campo{
    padding:10px 12px;
    border:1px solid #1f1f1f;
    border-radius:10px;
    background:#111;
    font-size:13px;
    letter-spacing:1px;
    color:#ccc;
}

.label{
    color:#777;
    text-transform:uppercase;
    font-size:10px;
    letter-spacing:2px;
}

.valor{
    color:#fff;
    margin-top:3px;
}

.boton{
    margin-top:25px;
}

.volver{
    display:block;
    width:100%;
    text-align:center;
    padding:14px;
    background:#fff;
    color:#000;
    text-decoration:none;
    font-size:11px;
    letter-spacing:3px;
    text-transform:uppercase;
    transition:0.4s ease;
    border:1px solid #fff;
    border-radius:8px;
}

.volver:hover{
    background:#000;
    color:#fff;
}
</style>
</head>

<body>

<div class="principal">
    <h2>Detalle Producto</h2>

    <div class="info">
        <?php
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            echo "
            <div class='campo'>
                <div class='label'>Código</div>
                <div class='valor'>{$fila['codigo']}</div>
            </div>

            <div class='campo'>
                <div class='label'>Nombre</div>
                <div class='valor'>{$fila['nombre']}</div>
            </div>

            <div class='campo'>
                <div class='label'>Precio</div>
                <div class='valor'>Bs {$fila['precio']}</div>
            </div>

            <div class='campo'>
                <div class='label'>Descripción</div>
                <div class='valor'>{$fila['descripcion']}</div>
            </div>

            <div class='campo'>
                <div class='label'>Stock</div>
                <div class='valor'>{$fila['stock']}</div>
            </div>

            <div class='campo'>
                <div class='label'>Costo</div>
                <div class='valor'>Bs {$fila['costo']}</div>
            </div>
            ";
        } else {
            echo "<p>No se encontró el producto.</p>";
        }
        ?>

        <div class="boton">
            <a href="leerproducto.php" class="volver">Volver</a>
        </div>
    </div>
</div>

</body>
</html>