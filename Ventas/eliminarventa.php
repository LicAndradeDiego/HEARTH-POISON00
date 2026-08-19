<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername,$username, $password,$bdname);

if($conexion->connect_error){
    die("Error de conexión: " . $conexion->connect_error);
}

$pedidos_id = $_GET['pedidos_id'] ?? '';$resultado = false;

if($pedidos_id != ""){
    $sql = "DELETE FROM ventas WHERE pedidos_id = '$pedidos_id'";
    $resultado = $conexion->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELIMINAR VENTA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background: #090909;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 0;
        }

        .contenedor {
            width: 450px;
            background: #0f0f0f;
            border: 1px solid #1a1a1a;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
            text-align: center;
        }

        h1 {
            font-size: 20px;
            font-weight: 300;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        p {
            font-size: 13px;
            color: #aaa;
            letter-spacing: 1px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .exito {
            color: #4dff88;
        }

        .error {
            color: #ff4d4d;
        }

        .boton {
            width: 100%;
            padding: 14px;
            background: #fff;
            color: #000;
            border: none;
            border-radius: 8px;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            transition: 0.4s ease;
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
        }

        .boton:hover {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }
    </style>
</head>
<body>

<?php include_once '../header.php'; ?>

<div class="contenedor">
<?php
if($resultado){
    echo "<h1 class='exito'>✓ Venta Eliminada</h1>";
    echo "<p>El registro de la venta fue eliminado correctamente del sistema.</p>";
} else {
    echo "<h1 class='error'>✕ Error</h1>";
    echo "<p>No se pudo eliminar el registro de la venta.</p>";
    if($conexion->error){
        echo "<p class='error'>" . htmlspecialchars($conexion->error) . "</p>";
    }
}

$conexion->close();
?>

<a class="boton" href="leerventa.php">Volver</a>
</div>

</body>
</html>