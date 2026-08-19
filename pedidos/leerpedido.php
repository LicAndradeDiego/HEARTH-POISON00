<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM pedidos";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestión de Pedidos</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Helvetica Neue', Arial, sans-serif;
}

body {
    background: #090909;
    color: #ffffff;
    overflow-x: hidden;
}

.contenedor {
    max-width: 1400px;
    margin: 120px auto 60px auto;
    padding: 40px;
    background: #0f0f0f;
    border: 1px solid #1a1a1a;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.6);
}

h1 {
    text-align: center;
    font-size: 34px;
    font-weight: 300;
    letter-spacing: 6px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.subtitulo {
    text-align: center;
    color: #777;
    font-size: 13px;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 40px;
}

.tabla-contenedor {
    width: 100%;
    overflow-x: auto;
}

.tabla-estilo {
    width: 100%;
    min-width: 1000px;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 12px;
    background: #111;
    border: 1px solid #1a1a1a;
}

.tabla-estilo th {
    padding: 18px;
    font-size: 12px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #fff;
    border-bottom: 1px solid #1f1f1f;
    font-weight: 400;
}

.tabla-estilo td {
    padding: 16px;
    text-align: center;
    font-size: 13px;
    color: #ccc;
    border-bottom: 1px solid #1a1a1a;
}

.tabla-estilo tr:hover {
    background: #151515;
}

button {
    border: none;
    padding: 8px 14px;
    border-radius: 6px;
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    cursor: pointer;
    transition: .3s ease;
    margin: 2px;
}

.editar {
    background: transparent;
    border: 1px solid #666;
    color: #fff;
}

.editar:hover {
    background: #fff;
    color: #000;
}

.eliminar {
    background: #1a1a1a;
    border: 1px solid #333;
    color: #fff;
}

.eliminar:hover {
    background: #b30000;
    border-color: #b30000;
}

.mostrar {
    background: transparent;
    border: 1px solid #444;
    color: #ccc;
}

.mostrar:hover {
    border-color: #fff;
    color: #fff;
}

.nuevo {
    margin-top: 30px;
    padding: 14px 28px;
    background: #fff;
    color: #000;
    font-size: 12px;
    letter-spacing: 3px;
    text-transform: uppercase;
    border-radius: 8px;
    font-weight: bold;
}

.nuevo:hover {
    background: #000;
    color: #fff;
    border: 1px solid #fff;
}

.boton-centro {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

a {
    text-decoration: none;
}

.estado {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.estado-pendiente {
    background: #332b00;
    color: #ffd700;
    border: 1px solid #665600;
}

.estado-proceso {
    background: #001f3f;
    color: #00aaff;
    border: 1px solid #003366;
}

.estado-completado, .estado-entregado {
    background: #0a290a;
    color: #4dff4d;
    border: 1px solid #145214;
}

.estado-cancelado {
    background: #2b0000;
    color: #ff4d4d;
    border: 1px solid #550000;
}

@media (max-width: 800px) {
    .contenedor {
        margin: 100px 15px 40px 15px;
        padding: 20px;
    }

    h1 {
        font-size: 25px;
        letter-spacing: 3px;
    }

    .subtitulo {
        font-size: 11px;
    }
}
</style>
</head>
<body>

<?php include '../header.php'; ?>

<div class="contenedor">
    <h1>Gestión de Pedidos</h1>
    <p class="subtitulo">Lista completa de pedidos registrados</p>

    <div class="tabla-contenedor">
        <table class='tabla-estilo'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Nombre Vendedor</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>

        <?php
        $resultado = $conn->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila['id'];
                $estadoClase = '';

                if ($fila['estado'] == 'Pendiente') {
                    $estadoClase = 'estado-pendiente';
                } elseif ($fila['estado'] == 'En proceso') {
                    $estadoClase = 'estado-proceso';
                } elseif ($fila['estado'] == 'Completado' || $fila['estado'] == 'Entregado') {
                    $estadoClase = 'estado-completado';
                } elseif ($fila['estado'] == 'Cancelado') {
                    $estadoClase = 'estado-cancelado';
                }

                echo "
                <tr>
                    <td>".$fila['id']."</td>
                    <td>".htmlspecialchars($fila['nombre'])."</td>
                    <td>".htmlspecialchars($fila['fecha'])."</td>
                    <td>
                        <span class='estado $estadoClase'>
                            ".htmlspecialchars($fila['estado'])."
                        </span>
                    </td>
                    <td>".htmlspecialchars($fila['nombre_vendedor'])."</td>
                    <td>".htmlspecialchars($fila['Direccion'])."</td>
                    <td>".htmlspecialchars($fila['Telefono'])."</td>
                    <td>
                        <a href='actualizarpedido.php?id=$id'>
                            <button class='editar'>Editar</button>
                        </a>
                        <a href='mostrarpedido.php?id=$id'>
                            <button class='mostrar'>Mostrar</button>
                        </a>
                        <a href='eliminarpedido.php?id=$id' onclick=\"return confirm('¿Estás seguro de eliminar este pedido?');\">
                            <button class='eliminar'>Eliminar</button>
                        </a>
                        <a href='mostrardetalle.php?id=$id'>
                            <button class='mostrar'>Detalle</button>
                        </a>
                    </td>
                </tr>";
            }
        } else {
            echo "
            <tr>
                <td colspan='8' style='padding:30px; color:#777;'>
                    No hay pedidos registrados.
                </td>
            </tr>";
        }
        $conn->close();
        ?>
        </table>
    </div>

    <div class="boton-centro">
        <a href="crearpedido.php">
            <button class="nuevo">Nuevo Pedido</button>
        </a>
    </div>
</div>

</body>
</html>