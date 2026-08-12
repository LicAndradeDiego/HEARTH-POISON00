<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error){
    die("Conexion fallida: " . $conexion->connect_error);
}

$usuario = null;

if(isset($_GET['CI'])){
    $CI = $_GET['CI'];

    $sql = "SELECT * FROM usuario WHERE CI='$CI'";
    $resultado = $conexion->query($sql);

    if($resultado && $resultado->num_rows > 0){
        $usuario = $resultado->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Usuario</title>

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
            width:550px;
            max-width:100%;
            background: rgba(20,20,20,0.90);
            padding:45px;
            border-radius:15px;
            color:white;
            border: 3px solid rgba(255, 75, 246, 0.83);
            box-shadow:0 0 30px rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
        }

        h1{
            text-align:center;
            margin-bottom:35px;
            font-size:30px;
            font-weight:300;
            letter-spacing:3px;
            text-transform:uppercase;
            color:white;
        }

        .dato{
            background: rgba(255,255,255,0.06);
            padding:15px 20px;
            border-radius:10px;
            margin-bottom:15px;
            font-size:16px;
            color:white;
            border:1px solid rgba(255,255,255,0.08);
        }

        .dato span{
            font-weight:bold;
            color:#ff9bf9;
        }

        .boton-centro{
            display:flex;
            justify-content:center;
            margin-top:30px;
        }

        .boton{
            display:inline-block;
            background:transparent;
            border:1px solid white;
            color:white;
            text-decoration:none;
            padding:14px 30px;
            border-radius:8px;
            font-size:15px;
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
            text-align:center;
            font-size:20px;
            color:#ff7aa8;
        }

        @media (max-width: 600px){
            .contenedor{
                padding:25px;
            }

            h1{
                font-size:24px;
            }

            .dato{
                font-size:14px;
                padding:12px 15px;
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
if($usuario){

    echo "<h1>Datos del Usuario</h1>";

    echo "<div class='dato'><span>CI:</span> " . $usuario['CI'] . "</div>";
    echo "<div class='dato'><span>Nombre:</span> " . $usuario['nombre'] . "</div>";
    echo "<div class='dato'><span>Dirección:</span> " . $usuario['direccion'] . "</div>";
    echo "<div class='dato'><span>Celular:</span> " . $usuario['celular'] . "</div>";
    echo "<div class='dato'><span>Rol:</span> " . $usuario['rol'] . "</div>";
    echo "<div class='dato'><span>Estado:</span> " . $usuario['estado'] . "</div>";

}else{
    echo "<h1 class='error'>Usuario no encontrado</h1>";
}

$conexion->close();
?>

    <div class="boton-centro">
        <a class="boton" href="crearusuario.php">Volver</a>
    </div>

</div>

</body>
</html>