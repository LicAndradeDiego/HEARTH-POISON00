<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername,$username, $password,$bdname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM ventas";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTIÓN DE VENTAS</title>
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
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .contenedor {
            width: 100%;
            max-width: 1000px;
            background: #0f0f0f;
            border: 1px solid #1a1a1a;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
            margin-top: 20px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            font-weight: 300;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .subtitulo {
            text-align: center;
            color: #888;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 35px;
        }

        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
        }

        .tabla-estilo {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
        }

        .tabla-estilo th {
            background: #141414;
            color: #aaa;
            padding: 16px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
            border-bottom: 1px solid #2a2a2a;
            text-align: center;
        }

        .tabla-estilo td {
            padding: 16px;
            text-align: center;
            background: transparent;
            border-bottom: 1px solid #1a1a1a;
            color: #eee;
            font-size: 13px;
        }

        .tabla-estilo tr:hover td {
            background: #151515;
            transition: 0.3s ease;
        }

        /* Botones de acción */
        .btn {
            border: 1px solid transparent;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            margin: 2px;
            text-decoration: none;
            display: inline-block;
        }

        .editar {
            background: transparent;
            color: #fff;
            border-color: #333;
        }

        .editar:hover {
            background: #fff;
            color: #000;
            border-color: #fff;
        }

        .mostrar {
            background: transparent;
            color: #aaa;
            border-color: #222;
        }

        .mostrar:hover {
            background: #222;
            color: #fff;
        }

        .eliminar {
            background: #ff4d4d1a;
            color: #ff4d4d;
            border-color: #ff4d4d4d;
        }

        .eliminar:hover {
            background: #ff4d4d;
            color: #000;
        }

        .nuevo {
            padding: 14px 28px;
            background: #fff;
            color: #000;
            border-radius: 8px;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: bold;
            transition: 0.4s ease;
            text-decoration: none;
            display: inline-block;
        }

        .nuevo:hover {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }

        .boton-centro {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php include_once "../header.php"; ?>

<div class="contenedor">

    <h1>Gestión de Ventas</h1>
    <p class="subtitulo">Lista completa de ventas registradas</p>

    <div class="tabla-contenedor">
        <table class="tabla-estilo">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Costo Total</th>
                    <th>Estado</th>
                    <th>Método</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $resultado = $conn->query($sql);

            if ($resultado &&$resultado->num_rows > 0) {
                while($fila =$resultado->fetch_assoc()) {
                    $pedidos_id = htmlspecialchars($fila['pedidos_id']);

                    echo "<tr>";
                    echo "<td>" . $pedidos_id . "</td>";
                    echo "<td>Bs. " . htmlspecialchars($fila['costoTotal']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['metodo']) . "</td>";
                    echo "<td>";
                    echo "<a href='actualizarventa.php?pedidos_id=$pedidos_id' class='btn editar'>Editar</a>";
                    echo "<a href='mostrarventa.php?pedidos_id=$pedidos_id' class='btn mostrar'>Mostrar</a>";
                    echo "<a href='eliminarventa.php?pedidos_id=$pedidos_id' class='btn eliminar'>Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='color:#666;'>No hay ventas registradas</td></tr>";
            }
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>

    <div class="boton-centro">
        <a href="crearventa.php" class="nuevo">Nueva Venta</a>
    </div>

</div>
</body>
</html>