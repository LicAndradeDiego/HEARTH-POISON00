<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername,$username, $password,$bdname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM ventas ORDER BY pedidos_id DESC";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HISTORIAL DE VENTAS</title>
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
            max-width: 900px;
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

        .boton-centro {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .boton {
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

        .boton:hover {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }
    </style>
</head>
<body>

<?php include_once "../header.php"; ?>

<div class="contenedor">
    <h1>Historial de Ventas</h1>
    <p class="subtitulo">Registro histórico de transacciones</p>

    <div class="tabla-contenedor">
        <table class="tabla-estilo">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Costo Total</th>
                    <th>Estado</th>
                    <th>Método</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $resultado = $conn->query($sql);

            if ($resultado && $resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fila['pedidos_id']) . "</td>";
                    echo "<td>Bs. " . htmlspecialchars($fila['costoTotal']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['metodo']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='color:#666;'>No hay registros en el historial</td></tr>";
            }
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>

    <div class="boton-centro">
        <a href="leerventa.php" class="boton">Volver a Gestión de Ventas</a>
    </div>
</div>

</body>
</html>