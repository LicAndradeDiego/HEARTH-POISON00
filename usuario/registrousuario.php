<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conexion = new mysqli($servername, $username, $password, $bdname);

if ($conexion->connect_error) {
    die("Hubo un error en la conexión: " . $conexion->connect_error);
}

$resultado = false;
$tipo = "error";
$titulo = "Error";
$mensaje = "No se pudo registrar el usuario.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ci = $_POST['CI'];
    $nombre = $_POST['Nombre'];
    $direccion = $_POST['Direccion'];
    $celular = $_POST['Numero'];
    $rol = $_POST['Rol'];
    $estado = $_POST['Estado'];

    $verificar = $conexion->prepare("SELECT CI FROM usuario WHERE CI = ?");
    $verificar->bind_param("i", $ci);
    $verificar->execute();
    $consulta = $verificar->get_result();

    if ($consulta->num_rows > 0) {
        $resultado = false;
        $tipo = "error";
        $titulo = "CI duplicado";
        $mensaje = "Ya existe un usuario con ese Carnet de Identidad.";
    } else {
        $sql = $conexion->prepare("INSERT INTO usuario (CI, nombre, direccion, celular, rol, estado) VALUES (?, ?, ?, ?, ?, ?)");
        $sql->bind_param("isssss", $ci, $nombre, $direccion, $celular, $rol, $estado);

        if ($sql->execute()) {
            $resultado = true;
            $tipo = "exito";
            $titulo = "Usuario registrado";
            $mensaje = "El nuevo usuario fue creado con éxito.";
        } else {
            $resultado = false;
            $tipo = "error";
            $titulo = "Error";
            $mensaje = "No se pudo registrar el usuario en la BD.";
        }

        $sql->close();
    }

    $verificar->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>

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
    echo "<h1 class='exito'>$titulo</h1>";
    echo "<p>$mensaje</p>";
}else{
    echo "<h1 class='error'>$titulo</h1>";
    echo "<p>$mensaje</p>";
}
?>

    <a class="boton" href="leerusuario.php">Volver</a>

</div>

</body>
</html>