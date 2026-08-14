<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername,$username, $password,$bdname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$pedidos_id =$_GET['pedidos_id'] ?? '';

$costoTotal = "";
$estado = "";
$metodo = "";

if ($pedidos_id != "") {
    $sql = "SELECT * FROM ventas WHERE pedidos_id='$pedidos_id'";
    $resultado = $conn->query($sql);

    if ($resultado &&$resultado->num_rows > 0) {
        $fila =$resultado->fetch_assoc();
        $pedidos_id =$fila['pedidos_id'];
        $costoTotal =$fila['costoTotal'];
        $estado =$fila['estado'];
        $metodo =$fila['metodo'];
    }
}
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
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: 300;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #fff;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #888;
        }

        input {
            padding: 12px 16px;
            border: 1px solid #222;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            outline: none;
            background: #141414;
            color: #fff;
            transition: 0.3s ease;
        }

        input:focus {
            border-color: #555;
            background: #181818;
        }

        .boton {
            background: #fff;
            color: #000;
            border: 1px solid #fff;
            padding: 12px;
            border-radius: 8px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 10px;
        }

        .boton:hover {
            background: #000;
            color: #fff;
        }
    </style>
</head>
<body>

<?php include_once "../header.php"; ?>

<div class="contenedor">

<form action="actualizarventa_proc.php" method="post" id="ActualizarVenta">

    <h2>Actualizar Venta</h2>

    <input type="hidden" name="pedidos_id" id="pedidos_id" value="<?=htmlspecialchars($pedidos_id)?>">

    <label for="costoTotal">Costo Total:</label>
    <input type="number" step="0.01" name="costoTotal" id="costoTotal" value="<?=htmlspecialchars($costoTotal)?>">

    <label for="estado">Estado:</label>
    <input type="text" name="estado" id="estado" value="<?=htmlspecialchars($estado)?>">

    <label for="metodo">Método de Pago:</label>
    <input type="text" name="metodo" id="metodo" value="<?=htmlspecialchars($metodo)?>">

    <input type="submit" value="Actualizar Venta" class="boton">

</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("ActualizarVenta").addEventListener("submit", function(event) {
        event.preventDefault();
        
        var b = document.getElementById("costoTotal");
        var c = document.getElementById("estado");
        var d = document.getElementById("metodo");
        
        function mostrarAlerta(mensaje, elemento) {
            Swal.fire({
                icon: 'error',
                title: 'Atención',
                text: mensaje,
                background: '#141414',
                color: '#fff',
                confirmButtonColor: '#333',
                confirmButtonText: 'Entendido'
            }).then(() => {
                elemento.focus(); 
            });
        }

        if (b.value.trim() === "") {
            mostrarAlerta("El campo Costo Total no puede ir vacío", b);
            return;
        }

        if (c.value.trim() === "") {
            mostrarAlerta("El campo Estado no puede ir vacío", c);
            return;
        }

        if (d.value.trim() === "") {
            mostrarAlerta("El campo Método no puede ir vacío", d);
            return;
        }

        this.submit();
    });
</script>

</div>
</body>
</html>