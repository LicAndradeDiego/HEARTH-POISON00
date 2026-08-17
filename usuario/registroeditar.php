<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error){
    die("Conexion fallida: " . $conexion->connect_error);
}

$CI = $_POST['CI'];
$Nombre = $_POST['Nombre'];
$Direccion = $_POST['Direccion'];
$Celular = $_POST['Celular'];
$Rol = $_POST['Rol'];
$Estado = $_POST['Estado'];

$sql = "UPDATE usuario SET 
    nombre='$Nombre',
    direccion='$Direccion',
    celular='$Celular',
    rol='$Rol',
    estado='$Estado'
    WHERE CI='$CI'";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:30px;
            background:#0a0a0a;
            position:relative;
            overflow:hidden;
        }

        .capa{
            position: fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background: rgba(0,0,0,0.60);
            z-index:-1;
        }

        .contenedor{
            width:500px;
            max-width:100%;
            background: rgba(20,20,20,0.90);
            padding:50px 40px;
            border-radius:15px;
            text-align:center;
            color:white;
            border: 3px solid rgba(255, 75, 246, 0.83);
            box-shadow:0 0 30px rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
        }

        h1{
            font-size:30px;
            margin-bottom:18px;
            font-weight:300;
            letter-spacing:2px;
            text-transform:uppercase;
            color:white;
        }

        p{
            font-size:16px;
            margin-bottom:30px;
            color:#d0d0d0;
            line-height:1.5;
        }

        .boton{
            display:inline-block;
            background:transparent;
            border:1px solid white;
            color:white;
            text-decoration:none;
            padding:14px 30px;
            border-radius:8px;
            font-weight:bold;
            letter-spacing:1px;
            text-transform:uppercase;
            transition:.3s;
        }

        .boton:hover{
            background:white;
            color:black;
            transform:translateY(-3px);
        }

        .error{
            color:#ff7aa8;
        }

        .exito{
            color:#ffffff;
        }

        .detalle-error{
            margin-top:10px;
            color:#ffb6c1;
            font-size:14px;
        }

        @media (max-width: 600px){
            .contenedor{
                padding:30px 20px;
            }

            h1{
                font-size:24px;
            }

            p{
                font-size:14px;
            }

            .boton{
                width:100%;
                text-align:center;
            }
        }
    </style>
</head>

<body>

<?php include '../header.php'; ?>

<div class="capa"></div>

<div class="contenedor">

<?php
if($resultado){

    echo "<h1 class='exito'>Usuario actualizado</h1>";
    echo "<p>Los datos fueron actualizados correctamente.</p>";

}else{

    echo "<h1 class='error'>Error</h1>";
    echo "<p>No se pudo actualizar el usuario.</p>";
    echo "<p class='detalle-error'>" . $conexion->error . "</p>";
}

$conexion->close();
?>

    <a class="boton" href="mostrarusuarios.php">Volver</a>

</div>

</body>
</html>