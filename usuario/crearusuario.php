<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .capa{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.55);
            z-index: -1;
        }

        .contenedor{
            width: 420px;
            background: rgba(20,20,20,0.90);
            padding: 35px;
            border-radius: 12px;
            border: 3px solid rgba(255, 75, 246, 0.83);
            box-shadow: 0 0 30px rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
        }

        h2{
            text-align: center;
            color: white;
            font-weight: 300;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        label{
            display: block;
            color: #d0d0d0;
            margin-bottom: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 13px;
        }

        input{
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            color: white;
            outline: none;
            transition: all .3s ease;
        }

        input:focus{
            border-color: #ff4bf6;
            background: rgba(255,255,255,0.08);
            box-shadow: 0 0 10px rgba(255,75,246,0.3);
        }

        input::placeholder{
            color: #aaa;
        }

        .button{
            width: 100%;
            padding: 14px;
            background: transparent;
            border: 1px solid white;
            border-radius: 8px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all .3s ease;
            font-weight: bold;
        }

        .button:hover{
            background: white;
            color: black;
        }
    </style>
</head>
<body>

    <?php include '../header.php'; ?>

    <div class="capa"></div>

    <div class="contenedor">
        <form action="registrousuario.php" method="post" id="CrearUsuario">
            <h2>Bienvenido</h2>

            <label for="CI">Carnet de Identidad</label>
            <input type="text" placeholder="CARNET IDENTIDAD" name="CI" id="CI">

            <label for="Nombre">Nombre</label>
            <input type="text" placeholder="NOMBRE(s)" name="Nombre" id="Nombre">

            <label for="Direccion">Dirección</label>
            <input type="text" placeholder="DIRECCIÓN" name="Direccion" id="Direccion">

            <label for="Numero">Número de Celular</label>
            <input type="text" placeholder="NÚMERO DE CELULAR" name="Numero" id="Numero">

            <label for="Rol">Rol</label>
            <input type="text" placeholder="ROL" name="Rol" id="Rol">

            <label for="Estado">Estado</label>
            <input type="text" placeholder="ESTADO" name="Estado" id="Estado">

            <input class="button" type="submit" value="Registrar">
        </form>
    </div>

    <script>
        document.getElementById("CrearUsuario").addEventListener("submit", function(event) {
            event.preventDefault();

            var a = document.getElementById("CI");
            var b = document.getElementById("Nombre");
            var c = document.getElementById("Direccion");
            var d = document.getElementById("Numero");
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

            if (a.value.trim() == "") {
                mostrarAlerta("El campo Carnet de Identidad no puede ir vacío", a);
                return;
            }
            if (!ex.test(a.value)) {
                mostrarAlerta("Introduce solo números en el Carnet de Identidad", a);
                return;
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