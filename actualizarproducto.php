<?php     
$servername  = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

/* ACTUALIZAR */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $costo = $_POST['costo'];
    $stock = $_POST['stock'];

    $sql = "UPDATE productos 
            SET nombre='$nombre',
                descripcion='$descripcion',
                precio='$precio',
                costo='$costo',
                stock='$stock'
            WHERE codigo='$codigo'";

    if($conn->query($sql) === TRUE){
        echo "<script>alert('Producto actualizado correctamente'); window.location='leerproducto.php';</script>";
        exit();
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}

/* MOSTRAR DATOS EN EL FORMULARIO */
$codigo = $_GET['codigo'];

$sql = "SELECT * FROM productos WHERE codigo='$codigo'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $codigo = $fila['codigo'];
    $nombre = $fila['nombre'];
    $precio = $fila['precio'];
    $descripcion = $fila['descripcion'];
    $stock = $fila['stock'];
    $costo = $fila['costo'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

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
}

button:hover{
    background: #000;
    color: #fff;
    border: 1px solid #fff;
}
</style>
</head>

<body>
<div class="contenedor">

<h2>Editar Producto</h2>

<form id="formulario" method="POST">

<label>Código</label>
<input type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?>" readonly>
<div class="error" id="errorCodigo">Ingrese el código</div>

<label>Nombre</label>
<input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
<div class="error" id="errorNombre">Ingrese el nombre</div>

<label>Descripción</label>
<input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>">
<div class="error" id="errorDescripcion">Ingrese la descripción</div>

<label>Precio</label>
<input type="number" name="precio" id="precio" value="<?php echo $precio; ?>">
<div class="error" id="errorPrecio">Ingrese el precio</div>

<label>Costo</label>
<input type="number" name="costo" id="costo" value="<?php echo $costo; ?>">
<div class="error" id="errorCosto">Ingrese el costo</div>

<label>Stock</label>
<input type="number" name="stock" id="stock" value="<?php echo $stock; ?>">
<div class="error" id="errorStock">Ingrese el stock</div>

<button type="submit">Actualizar Producto</button>

</form>

</div>

<script>
$(document).ready(function(){

$("#formulario").submit(function(e){

    var validar = true;
    $(".error").hide();

    if($("#codigo").val() === ""){
        $("#errorCodigo").show();
        validar = false;
    }

    if($("#nombre").val() === ""){
        $("#errorNombre").show();
        validar = false;
    }

    if($("#descripcion").val() === ""){
        $("#errorDescripcion").show();
        validar = false;
    }

    if($("#precio").val() === ""){
        $("#errorPrecio").show();
        validar = false;
    }

    if($("#costo").val() === ""){
        $("#errorCosto").show();
        validar = false;
    }

    if($("#stock").val() === ""){
        $("#errorStock").show();
        validar = false;
    }

    if(!validar){
        e.preventDefault();
    }
});

});
</script>

</body>
</html>