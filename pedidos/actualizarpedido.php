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

$Nombre = "";
$Fecha = "";
$Estado = "";
$NombreVendedor = "";

if ($id != "") {

    $sql = "SELECT * FROM Pedidos WHERE id='$id'";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $id = $fila['id'];
            $Nombre = $fila['Nombre'];
            $Fecha = $fila['Fecha'];
            $Estado = $fila['Estado'];
            $nombre_vendedor = $fila['nombre_vendedor'];
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


</head>

<body>

<?php include_once "../header.php"; ?>

<div class="contenedor">

<form action="registroeditarpedido.php" method="post" id="ActualizarPedido">

    <h2>Actualizar Pedido</h2>

    <input type="hidden" name="id" id="id" value="<?=$id?>">

    <label>Nombre(s):</label>
    <input type="text" name="Nombre" id="Nombre" value="<?=$Nombre?>">

    <label>Fecha:</label>
    <input type="date" name="Fecha" id="Fecha" value="<?=$Fecha?>">

  <label>Estado:</label>
<select name="Estado" id="Estado">
    <option value="Pendiente" <?= ($Estado=='Pendiente')?'selected':'' ?>>Pendiente</option>
    <option value="En proceso" <?= ($Estado=='En proceso')?'selected':'' ?>>En proceso</option>
    <option value="Entregado" <?= ($Estado=='Entregado')?'selected':'' ?>>Entregado</option>
</select>

    <input type="hidden" name="nombre_vendedor" id="nombre_vendedor" value="<?=$nombre_vendedor?>">
   
    <input type="submit" value="Actualizar Pedido" class="boton">

</form>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.getElementById("ActualizarPedido").addEventListener("submit", function(event) {
        
        event.preventDefault();
    
        var b = document.getElementById("Nombre");
        var c = document.getElementById("Fecha");
        var d = document.getElementById("Estado");
    
        
        var ex = /^[0-9]*$/;
        var expRegNombre = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;

       
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

        this.submit();
    });
</script>

</div>
</body>
</html>
