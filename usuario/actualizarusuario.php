<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$CI = $_GET['CI'] ?? '';

$nombre = "";
$direccion = "";
$celular = "";
$rol = "";
$estado = "";

if ($CI != "") {

    $sql = "SELECT * FROM usuario WHERE CI='$CI'";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $CI = $fila['CI'];
            $nombre = $fila['nombre'];
            $direccion = $fila['direccion'];
            $celular = $fila['celular'];
            $rol = $fila['rol'];
            $estado = $fila['estado'];
        }
    }
}
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
            position: relative;
            overflow: hidden;
        }
        video{
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: -2;
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
            width: 500px;
            background: rgba(20,20,20,0.90);
            padding: 40px;
            border-radius: 15px;
            border: 3px solid rgba(255, 75, 246, 0.83);
            box-shadow: 0 0 30px rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
            color:white;
        }

        h2{
            text-align:center;
            margin-bottom:30px;
            font-size:30px;
            font-weight:300;
            letter-spacing:3px;
            text-transform:uppercase;
            color:white;
        }

        form{
            display:flex;
            flex-direction:column;
        }

        label{
            color:#d0d0d0;
            margin-bottom:8px;
            font-size:14px;
            text-transform:uppercase;
            letter-spacing:1px;
        }

        input{
            width:100%;
            padding:14px;
            margin-bottom:20px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius:8px;
            color:white;
            outline:none;
            transition:all .3s ease;
        }

        input:focus{
            border-color:#ff4bf6;
            background: rgba(255,255,255,0.08);
            box-shadow:0 0 10px rgba(255,75,246,0.3);
        }

        input::placeholder{
            color:#aaa;
        }

        .boton{
            background: transparent;
            border:1px solid white;
            color:white;
            font-weight:bold;
            cursor:pointer;
            transition:.3s;
            text-transform:uppercase;
            letter-spacing:2px;
        }

        .boton:hover{
            background:white;
            color:black;
            transform:translateY(-3px);
        }

        .swal2-container{
            z-index:99999 !important;
        }

        @media (max-width: 600px){
            .contenedor{
                width:100%;
                padding:25px;
            }

            h2{
                font-size:24px;
            }
        }
    </style>
</head>

<body>

<?php include_once "../header.php"; ?>

<div class="capa"></div>

<div class="contenedor">

    <form action="registroeditar.php" method="post" id="ActualizarUsuario">

        <h2>Actualizar Usuario</h2>

        <input type="hidden" name="CI" id="CI" value="<?= $CI ?>">

        <label>Nombre(s):</label>
        <input type="text" name="Nombre" id="Nombre" value="<?= $nombre ?>">

        <label>Dirección:</label>
        <input type="text" name="Direccion" id="Direccion" value="<?= $direccion ?>">

        <label>Celular:</label>
        <input type="text" name="Celular" id="Celular" value="<?= $celular ?>">

        <label>Rol:</label>
        <input type="text" name="Rol" id="Rol" value="<?= $rol ?>">

        <label>Estado:</label>
        <input type="text" name="Estado" id="Estado" value="<?= $estado ?>">

        <input type="submit" value="Actualizar Usuario" class="boton">

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("ActualizarUsuario").addEventListener("submit", function(event) {
    event.preventDefault();

    var b = document.getElementById("Nombre");
    var c = document.getElementById("Direccion");
    var d = document.getElementById("Celular");
    var e = document.getElementById("Rol");
    var f = document.getElementById("Estado");

    var ex = /^[0-9]+$/;
    var expRegNombre = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
    var expRegMinuscula = /^[a-zñáéíóúü\s]+$/;

    function mostrarAlerta(mensaje, elemento) {
        Swal.fire({
            icon: 'error',
            title: '¡Oops!',
            text: mensaje,
            confirmButtonColor: '#d63384',
            confirmButtonText: 'Entendido'
        }).then(() => {
            elemento.focus();
        });
    }

    if (b.value.trim() == "") {
        mostrarAlerta("El campo Nombre no puede ir vacío", b);
        return;
    }
    if (!expRegNombre.test(b.value)) {
        mostrarAlerta("Introduce solo letras en el Nombre", b);
        return;
    }

 
    if (c.value.trim() == "") {
        mostrarAlerta("El campo Dirección no puede ir vacío", c);
        return;
    }

    if (d.value.trim() == "") {
        mostrarAlerta("El campo Número de Celular no puede ir vacío", d);
        return;
    }
    if (!ex.test(d.value)) {
        mostrarAlerta("Introduce solo números en el Celular", d);
        return;
    }

    if (e.value.trim() == "") {
        mostrarAlerta("El campo Rol no puede ir vacío", e);
        return;
    }
    if (!expRegMinuscula.test(e.value)) {
        mostrarAlerta("Introduce solo minúsculas en el Rol", e);
        return;
    }


    if (f.value.trim() == "") {
        mostrarAlerta("El campo Estado no puede ir vacío", f);
        return;
    }
    if (!expRegNombre.test(f.value)) {
        mostrarAlerta("Introduce solo letras en el Estado", f);
        return;
    }

    this.submit();
});
</script>

</body>
</html>