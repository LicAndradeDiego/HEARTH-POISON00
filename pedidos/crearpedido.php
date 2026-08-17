    <?php
session_start();
$nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NUEVO PEDIDO</title>
   
   <style>


*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Helvetica Neue', Arial, sans-serif;
}

body{
    background: #090909;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}


.contenedor{
    width: 420px;
    background: #0f0f0f;
    border: 1px solid #1a1a1a;
    padding: 40px;
    border-radius: 18px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.6);
}

h2{
    text-align: center;
    font-size: 26px;
    font-weight: 300;
    letter-spacing: 5px;
    text-transform: uppercase;
    margin-bottom: 30px;
}

label{
    display: block;
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #aaa;
    margin-bottom: 6px;
}


input{
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

input:focus{
    border-color: #fff;
}


.error{
    color: #ff4d4d;
    font-size: 11px;
    letter-spacing: 1px;
    margin-top: -12px;
    margin-bottom: 10px;
    display: none;
}


button{
    width: 100%;
    padding: 14px;
    background: #fff;
    color: #000;
    border: none;
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
    cursor: pointer;
    transition: 0.4s ease;
    margin-top: 10px;
}

button:hover{
    background: #000;
    color: #fff;
    border: 1px solid #fff;
}

</style>   
</head>
<body>
 <?php include '../header.php'; ?>


<div class="capa"></div>

<div class="tra">

<form action="registropedido.php" method="post" id="crearpedido">

<h2>Nuevo Pedido</h2>


<input type="hidden" placeholder="id" name="id" id="id" >
<label>Nombre:</label>
<input type="text" placeholder="NOMBRE" name="Nombre" id="Nombre" >
<label>Fecha:</label>
<input type="date" placeholder="FECHA" name="Fecha" id="Fecha" value="<?php echo date ('Y-m-d'); ?>"readonly>
<label>Estado:</label>
<select name="Estado" id="Estado">
    <option value="Pendiente">Pendiente</option>
    <option value="En proceso">En proceso</option>
    <option value="Entregado">Entregado</option>
</select>
<label>Nombre Vendedor:</label>
<input type="text" placeholder="NOMBRE DE VENDEDOR" name="nombre_vendedor" id="nombre_vendedor" value="<?php echo $nombre; ?>"readonly>
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
        
        var ex = /^[0-9]*$/;
        var expRegNombre = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
        var expRegMinuscula=/^[a-zÑñÁáÉéÍíÓóÚúÜü\s]+$/;

       
        function mostrarAlerta(mensaje, elemento) {
            Swal.fire({
                icon: 'error',
                title: '¡Oops!',
                text: mensaje,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
            }).then(() => {
                elemento.focus(); 
            });
        }
       
        if (b.value.trim() == "") {
            mostrarAlerta("El campo Nombre no puede ir vacío", b);
            return;
        }
        if (!expRegNombre.exec(b.value)) {
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
        if (!expRegNombre.exec(d.value)) {
            mostrarAlerta("Introduce solo letras en el Estado", d);
            return;
        }

       
        this.submit();
    });
</script>
</body>
</html>
