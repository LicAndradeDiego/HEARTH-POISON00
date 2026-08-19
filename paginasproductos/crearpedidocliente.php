<?php

session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>NUEVO PEDIDO</title>


    <link
        rel="stylesheet"
        href="../Usuarios/estiloscrear.css"
    >


    <style>

        select#estado {

            width: 100%;

            padding: 14px;

            margin-top: 12px;

            margin-bottom: 18px;

            border: none;

            border-radius: 14px;

            background: rgba(255,255,255,0.12);

            color: white;

            font-family: 'Poppins', sans-serif;

            font-size: 14px;

            outline: none;

            backdrop-filter: blur(4px);

            box-sizing: border-box;

            cursor: pointer;

        }


        select#estado option {

            background: #344E41;

            color: #DAD7CD;

        }


        select#estado:focus {

            background: rgba(255,255,255,0.18);

        }

    </style>

</head>


<body>


<?php include '../header.php'; ?>


<video autoplay muted loop>

    <source
        src="../imagenes/vdapplepie.mp4"
        type="video/mp4"
    >

</video>


<div class="capa"></div>


<div class="tra">


    <form
        action="registropedido.php"
        method="post"
        id="crearpedido"
    >


        <h2>Nuevo Pedido</h2>


        <!-- ==========================================
             NOMBRE
        =========================================== -->

        <label>Nombre:</label>

        <input
            type="text"
            placeholder="NOMBRE"
            name="nombre"
            id="nombre"
        >


        <!-- ==========================================
             FECHA
        =========================================== -->

        <label>Fecha:</label>

        <input
            type="date"
            name="fecha"
            id="fecha"
            value="<?php echo date('Y-m-d'); ?>"
            readonly
        >


        <!-- ==========================================
             ESTADO
        =========================================== -->

        <input
            type="hidden"
            name="estado"
            id="estado"
            value="Abierto"
        >


        <!-- ==========================================
             NOMBRE DEL VENDEDOR
        =========================================== -->

        <label>Nombre del vendedor:</label>

        <input
            type="text"
            placeholder="NOMBRE DEL VENDEDOR"
            name="nombre_vendedor"
            id="nombre_vendedor"
        >


        <!-- ==========================================
             BOTÓN
        =========================================== -->

        <input
            class="button"
            type="submit"
            value="Registrar"
        >


    </form>

</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

document
.getElementById("crearpedido")
.addEventListener(
    "submit",
    function(event) {

        event.preventDefault();


        // ==========================================
        // OBTENER CAMPOS
        // ==========================================

        var nombre =
            document.getElementById("nombre");


        var fecha =
            document.getElementById("fecha");


        var estado =
            document.getElementById("estado");


        var nombreVendedor =
            document.getElementById("nombre_vendedor");


        // ==========================================
        // EXPRESIONES REGULARES
        // ==========================================

        var expRegNombre =
            /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;


        // ==========================================
        // FUNCIÓN PARA MOSTRAR ALERTAS
        // ==========================================

        function mostrarAlerta(
            mensaje,
            elemento
        ) {

            Swal.fire({

                icon: 'error',

                title: '¡Oops!',

                text: mensaje,

                confirmButtonColor:
                    '#3085d6',

                confirmButtonText:
                    'Entendido'

            }).then(() => {

                elemento.focus();

            });

        }


        // ==========================================
        // VALIDAR NOMBRE
        // ==========================================

        if (
            nombre.value.trim() == ""
        ) {

            mostrarAlerta(
                "El campo Nombre no puede ir vacío",
                nombre
            );

            return;

        }


        if (
            !expRegNombre.test(
                nombre.value.trim()
            )
        ) {

            mostrarAlerta(
                "Introduce solo letras en el Nombre",
                nombre
            );

            return;

        }


        // ==========================================
        // VALIDAR FECHA
        // ==========================================

        if (
            fecha.value.trim() == ""
        ) {

            mostrarAlerta(
                "El campo Fecha no puede ir vacío",
                fecha
            );

            return;

        }


        // ==========================================
        // VALIDAR ESTADO
        // ==========================================

        if (
            estado.value.trim() == ""
        ) {

            mostrarAlerta(
                "El campo Estado no puede ir vacío",
                estado
            );

            return;

        }


        // ==========================================
        // VALIDAR VENDEDOR
        // ==========================================

        if (
            nombreVendedor.value.trim() == ""
        ) {

            mostrarAlerta(
                "El campo Nombre del vendedor no puede ir vacío",
                nombreVendedor
            );

            return;

        }


        if (
            !expRegNombre.test(
                nombreVendedor.value.trim()
            )
        ) {

            mostrarAlerta(
                "Introduce solo letras en el Nombre del vendedor",
                nombreVendedor
            );

            return;

        }


        // ==========================================
        // ENVIAR FORMULARIO
        // ==========================================

        this.submit();

    }
);

</script>


</body>

</html>