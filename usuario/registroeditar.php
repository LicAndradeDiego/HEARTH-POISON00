<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $bdname = "proyetocuba";

    $conexion = new mysqli($servername, $username, $password, $bdname);

    if ($conexion->connect_error){
        die("Conexion fallida: ". $conexion->connect_error);
    }
    $codigo=$_POST['codigo'];
    $nombre=$_POST['nombre'];
    $precio=$_POST['precio'];
    $descripcion=$_POST['descripcion'];
    $stock=$_POST['stock'];
    $costo=$_POST['costo'];

    $sql = "UPDATE productos SET codigo = '$codigo', nombre = '$nombre', precio = '$precio', descripcion = '$descripcion', stock = '$stock', costo = '$costo' WHERE codigo = $codigo";
    if($conexion -> query($sql) == TRUE ){
        echo "El producto se actualizo: ";
        
    }
    ?>