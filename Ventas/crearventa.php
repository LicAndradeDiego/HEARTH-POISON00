<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRAR VENTA</title>
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

        input {
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

        input::placeholder {
            color: #555;
        }

        input:focus {
            border-color: #fff;
        }

        .button {
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

        .button:hover {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }
    </style>
</head>
<body>

<?php include_once '../header.php'; ?>

<div class="contenedor">
    <form action="regisventa.php" method="post" id="CrearVenta">
        <h2>Registrar Venta</h2>

        <input type="hidden" name="accion" value="aceptar">

        <label for="pedidos_id">ID Pedido</label>
        <input type="number" placeholder="ID DEL PEDIDO" name="pedidos_id" id="pedidos_id">

        <label for="costoTotal">Costo Total</label>
        <input type="number" step="0.01" placeholder="COSTO TOTAL" name="costoTotal" id="costoTotal">

        <label for="Estado">Estado</label>
        <input type="text" placeholder="ESTADO" name="Estado" id="Estado" value="Aceptado">

        <label for="Metodo">Método de Pago</label>
        <input type="text" placeholder="MÉTODO DE PAGO" name="Metodo" id="Metodo" value="Efectivo">

        <input class="button" type="submit" value="Registrar Venta">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("CrearVenta").addEventListener("submit", function(event) {
        event.preventDefault();

        var a = document.getElementById("pedidos_id");
        var b = document.getElementById("costoTotal");
        var c = document.getElementById("Estado");
        var d = document.getElementById("Metodo");

        var exNum = /^[0-9]+$/;
        var expRegTexto = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;

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

        if (a.value.trim() == "") {
            mostrarAlerta("El campo ID Pedido no puede ir vacío", a);
            return;
        }
        if (!exNum.test(a.value)) {
            mostrarAlerta("Introduce solo números en el ID Pedido", a);
            return;
        }

        if (b.value.trim() == "") {
            mostrarAlerta("El campo Costo Total no puede ir vacío", b);
            return;
        }

        if (c.value.trim() == "") {
            mostrarAlerta("El campo Estado no puede ir vacío", c);
            return;
        }

        if (d.value.trim() == "") {
            mostrarAlerta("El campo Método no puede ir vacío", d);
            return;
        }

        this.submit();
    });
</script>
</body>
</html>