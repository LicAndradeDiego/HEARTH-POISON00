<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if($conexion->connect_error){
    die("Hubo un error en la conexión");
}

$mensaje = "";
$tipo = "";

if(isset($_GET['codigo'])){
    $codigo = $_GET['codigo'];

    $sql = "DELETE FROM productos WHERE codigo='$codigo'";

    if ($conexion->query($sql) === TRUE) {
        $mensaje = "Producto eliminado correctamente.";
        $tipo = "exito";
    } else {
        $mensaje = "Error al eliminar: " . $conexion->error;
        $tipo = "error";
    }
} else {
    $mensaje = "No se recibió el código del producto.";
    $tipo = "error";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Eliminar Producto</title>

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

.notificacion{
    width:420px;
    background:#0f0f0f;
    border:1px solid #1a1a1a;
    border-radius:18px;
    padding:40px 35px;
    box-shadow:0 20px 60px rgba(0,0,0,0.6);
    text-align:center;
    animation: fadeIn 0.8s ease;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.titulo{
    font-size:24px;
    font-weight:300;
    letter-spacing:5px;
    text-transform:uppercase;
    margin-bottom:20px;
}

.mensaje{
    font-size:14px;
    color:#ccc;
    line-height:1.6;
    margin-bottom:30px;
}

.exito{
    color:white;
}

.error{
    color:white;
}

.boton{
    display:inline-block;
    width:100%;
    text-align:center;
    padding:14px;
    background:#fff;
    color:#000;
    text-decoration:none;
    font-size:11px;
    letter-spacing:3px;
    text-transform:uppercase;
    border:1px solid #fff;
    border-radius:8px;
    transition:0.4s ease;
}

.boton:hover{
    background:#000;
    color:#fff;
}
</style>
</head>
<body>

<div class="notificacion">
    <h2 class="titulo">Eliminar Producto</h2>

    <p class="mensaje <?php echo $tipo; ?>">
        <?php echo $mensaje; ?>
    </p>

    <a href="leerproducto.php" class="boton">Volver a productos</a>
</div>

</body>
</html>