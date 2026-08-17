<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$id = $_GET['id'] ?? '';

$nombre = "";
$fecha = "";
$estado = "";
$nombre_vendedor = "";
$Direccion = "";
$Telefono = "";

if ($id != "") {
    $sql = "SELECT * FROM pedidos WHERE id='$id'";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $id = $fila['id'];
            $nombre = $fila['nombre'];
            $fecha = $fila['fecha'];
            $estado = $fila['estado'];
            $nombre_vendedor = $fila['nombre_vendedor'];
            $Direccion = $fila['direccion'] ?? $fila['Direccion'] ?? '';
            $Telefono = $fila['telefono'] ?? $fila['Telefono'] ?? '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Actualizar Pedido</title>
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
}

h2 {
    text-align: center;
    font-size: 24px;
    font-weight: 300;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    display: block;
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #aaa;
    margin-bottom: 6px;
}

input, select {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 18px;
    background: transparent;
    border: 1px solid #2a2a2a;
    border-radius: 8px;
    color: #fff;
    font-size: 13px;
    outline: none;
    transition: 0.3s ease;
}

select option {
    background-color: #0f0f0f;
    color: #fff;
}

input:focus, select:focus {
    border-color: #fff;
}

input[readonly] {
    color: #666;
    border-color: #1a1a1a;
    cursor: not-allowed;
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
    margin-top: 10px;
}

.boton:hover {
    background: #000;
    color: #fff;
    border: 1px solid #fff;
}
</style>
</head>
<body>

<?php include '../header.php'; ?>

<div class="contenedor">
    <form action="registroeditarpedido.php" method="post" id="ActualizarPedido">
        <h2>Actualizar Pedido</h2>

        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

        <label>Nombre(s):</label>
        <input type="text" name="Nombre" id="nombre" value="<?php echo $nombre; ?>">

        <label>Fecha:</label>
        <input type="date" name="Fecha" id="fecha" value="<?php echo $fecha; ?>" readonly>

        <label>Estado:</label>
        <select name="Estado" id="estado">
            <option value="">SELECCIONAR ESTADO</option>
            <option value="Pendiente" <?php if ($estado == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="En proceso" <?php if ($estado == 'En proceso') echo 'selected'; ?>>En proceso</option>
            <option value="Entregado" <?php if ($estado == 'Entregado' || $estado == 'Completado') echo 'selected'; ?>>Entregado</option>
            <option value="Cancelado" <?php if ($estado == 'Cancelado') echo 'selected'; ?>>Cancelado</option>
        </select>

        <label>Nombre del Vendedor:</label>
        <input type="text" name="nombre_vendedor" id="nombre_vendedor" value="<?php echo $nombre_vendedor; ?>" readonly>

        <label>Dirección:</label>
        <input type="text" name="Direccion" id="Direccion" value="<?php echo $Direccion; ?>">

        <label>Teléfono:</label>
        <input type="number" name="Telefono" id="Telefono" value="<?php echo $Telefono; ?>">

        <input type="submit" value="Actualizar Pedido" class="boton">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("ActualizarPedido").addEventListener("submit", function(event) {
    event.preventDefault();

    var b = document.getElementById("nombre");
    var c = document.getElementById("fecha");
    var d = document.getElementById("estado");
    var e = document.getElementById("Direccion");
    var f = document.getElementById("Telefono");

    var expRegNombre = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;

    function mostrarAlerta(mensaje, elemento) {
        Swal.fire({
            icon: 'error',
            title: '¡Oops!',
            text: mensaje,
            confirmButtonColor: '#ffffff',
            confirmButtonText: '<span style="color:#000;">Entendido</span>',
            background: '#0f0f0f',
            color: '#fff'
        }).then(function() {
            elemento.focus();
        });
    }

    if (b.value.trim() == "") {
        mostrarAlerta("El campo Nombre no puede ir vacío", b);
        return;
    }
    if (!expRegNombre.test(b.value.trim())) {
        mostrarAlerta("Introduce solo letras en el Nombre", b);
        return;
    }
    if (c.value.trim() == "") {
        mostrarAlerta("El campo Fecha no puede ir vacío", c);
        return;
    }
    if (d.value.trim() == "") {
        mostrarAlerta("El campo Estado no puede ir vacío", d);
        return;
    }
    if (e.value.trim() == "") {
        mostrarAlerta("El campo Dirección no puede ir vacío", e);
        return;
    }
    if (f.value.trim() == "") {
        mostrarAlerta("El campo Teléfono no puede ir vacío", f);
        return;
    }

    this.submit();
});
</script>
</body>
</html>