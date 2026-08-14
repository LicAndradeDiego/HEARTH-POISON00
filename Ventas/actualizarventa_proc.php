<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername,$username, $password,$bdname);

if ($conexion->connect_error){
    die("Conexión fallida: " . $conexion->connect_error);
}

$pedidos_id =$_POST['pedidos_id'] ?? '';
$costoTotal =$_POST['costoTotal'] ?? '';
$estado =$_POST['estado'] ?? '';
$metodo =$_POST['metodo'] ?? '';

$sql = "UPDATE ventas SET 
    costoTotal='$costoTotal',
    estado='$estado',
    metodo='$metodo'
    WHERE pedidos_id='$pedidos_id'";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Venta</title>
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
            padding: 30px;
        }

        .contenedor {
            background: #0f0f0f;
            border: 1px solid #1a1a1a;
            width: 100%;
            max-width: 480px;
            padding: 40px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        }

        h1 {
            font-size: 22px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        p {
            font-size: 14px;
            color: #888;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .boton {
            display: inline-block;
            background: #fff;
            color: #000;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .boton:hover {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }

        .error {
            color: #ff4d4d;
        }

        .exito {
            color: #4dff88;
        }
    </style>
</head>
<body>

<?php include_once '../header.php'; ?>

<div class="contenedor">
<?php
if ($resultado) {
    echo "<h1 class='exito'>✓ Venta Actualizada</h1>";
    echo "<p>Los datos fueron actualizados correctamente en el sistema.</p>";
} else {
    echo "<h1 class='error'>✕ Error</h1>";
    echo "<p>No se pudo actualizar la venta.</p>";
    echo "<p class='error'>" . htmlspecialchars($conexion->error) . "</p>";
}

$conexion->close();
?>

    <a class="boton" href="leerventa.php">Volver</a>
</div>

</body>
</html>