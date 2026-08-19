<?php
session_start();
$nombre = isset($_SESSION['nombre']) ?$_SESSION['nombre'] : (isset($_SESSION['Nombre']) ?$_SESSION['Nombre'] : '');

$conexion = new mysqli("localhost", "root", "", "proyetocuba");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql_productos = "SELECT codigo, nombre, precio, stock FROM productos WHERE stock > 0";
$resultado_productos = $conexion->query($sql_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUEVO PEDIDO</title>
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

        .buttom {
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

        .buttom:hover {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }
    </style>    
</head>
<body>

<?php include '../header.php'; ?>

<div class="contenedor">
    <form action="registropedido.php" method="post" id="crearpedido">
        <h2>Nuevo Pedido</h2>

        <label for="Nombre">Nombre Cliente / Pedido:</label>
        <input type="text" placeholder="NOMBRE" name="Nombre" id="Nombre">

        <label for="Fecha">Fecha:</label>
        <input type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" readonly>

        <label for="Estado">Estado:</label>
        <select name="Estado" id="Estado">
            <option value="">SELECCIONAR ESTADO</option>
            <option value="Pendiente">Pendiente</option>
            <option value="En proceso">En proceso</option>
            <option value="Entregado">Entregado</option>
            <option value="Cancelado">Cancelado</option>
        </select>

        <label for="nombre_vendedor">Nombre Vendedor:</label>
        <input type="text" placeholder="NOMBRE DE VENDEDOR" name="nombre_vendedor" id="nombre_vendedor" value="<?php echo htmlspecialchars($nombre); ?>" readonly>

        <label for="Direccion">Dirección:</label>
        <input type="text" placeholder="DIRECCIÓN" name="Direccion" id="Direccion">

        <label for="Telefono">Teléfono:</label>
        <input type="number" placeholder="TELÉFONO" name="Telefono" id="Telefono">

        <input class="buttom" type="submit" value="Registrar">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("crearpedido").addEventListener("submit", function(event) {
        event.preventDefault();

        var b = document.getElementById("Nombre");
        var c = document.getElementById("Fecha");
        var d = document.getElementById("Estado");
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