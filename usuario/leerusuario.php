<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "proyetocuba";

$conn = new mysqli($servername, $username, $password, $bdname);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuario";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            min-height: 100vh;
            background: #0a0a0a;
            padding: 120px 40px 40px 40px;
            position: relative;
            overflow-x: auto;
        }

       

        .capa{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.60);
            z-index: -1;
        }

        .contenedor{
            width: 95%;
            max-width: 1300px;
            margin: auto;
            background: rgba(20,20,20,0.90);
            padding: 35px;
            border-radius: 15px;
            border: 3px solid rgba(255, 75, 246, 0.83);
            box-shadow: 0 0 30px rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
        }

        h1{
            text-align:center;
            color:white;
            font-weight:300;
            letter-spacing:4px;
            text-transform:uppercase;
            margin-bottom:10px;
        }

        .subtitulo{
            text-align:center;
            color:#d0d0d0;
            margin-bottom:30px;
            font-size:14px;
            letter-spacing:1px;
        }

        .tabla-responsive{
            overflow-x:auto;
            border-radius: 12px;
        }

        .tabla-estilo{
            width:100%;
            border-collapse: collapse;
            min-width: 950px;
            overflow: hidden;
            border-radius: 12px;
        }

        .tabla-estilo th{
            background: rgba(255, 75, 246, 0.83);
            color: white;
            padding: 15px;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .tabla-estilo td{
            padding: 14px;
            text-align: center;
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            color: white;
        }

        .tabla-estilo tr:hover td{
            background: rgba(255,255,255,0.10);
            transition: 0.3s;
        }

        button{
            border:none;
            padding:10px 15px;
            border-radius:8px;
            font-weight:500;
            cursor:pointer;
            transition:0.3s;
            margin:2px;
        }

        .editar{
            background:#ff4bf6;
            color:white;
        }

        .editar:hover{
            background:#e13ad8;
            transform:scale(1.05);
        }

        .mostrar{
            background:transparent;
            color:white;
            border:1px solid white;
        }

        .mostrar:hover{
            background:white;
            color:black;
            transform:scale(1.05);
        }

        .nuevo{
            margin-top:25px;
            background:transparent;
            border:1px solid white;
            color:white;
            font-size:15px;
            padding:12px 22px;
            letter-spacing:2px;
            text-transform:uppercase;
        }

        .nuevo:hover{
            background:white;
            color:black;
            transform:scale(1.05);
        }

        .boton-centro{
            display:flex;
            justify-content:center;
            margin-top:25px;
        }

        .sin-registros{
            text-align:center;
            color:white;
            padding:20px;
        }

        @media (max-width: 768px){
            body{
                padding: 100px 15px 20px 15px;
            }

            .contenedor{
                padding: 20px;
            }

            h1{
                font-size: 26px;
                letter-spacing: 2px;
            }

            .subtitulo{
                font-size: 13px;
            }

            button{
                padding:8px 12px;
                font-size:12px;
            }

            .nuevo{
                width:100%;
            }
        }
    </style>
</head>
<body>

<?php include '../header.php'; ?>
<div class="capa"></div>

<div class="contenedor">
    <h1>Gestión de Usuarios</h1>
    <p class="subtitulo">Lista completa de usuarios registrados</p>

    <div class="tabla-responsive">
        <table class="tabla-estilo">
            <tr>
                <th>CI</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Celular</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>

            <?php
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0){
                while($fila = $resultado->fetch_assoc()){
                    $CI = $fila['CI'];
                    echo "<tr>
                            <td>".$fila['CI']."</td>
                            <td>".$fila['nombre']."</td>
                            <td>".$fila['direccion']."</td>
                            <td>".$fila['celular']."</td>
                            <td>".$fila['rol']."</td>
                            <td>".$fila['estado']."</td>
                            <td>
                                <a href='actualizarusuario.php?CI=$CI'>
                                    <button class='editar'>Editar</button>
                                </a>

                                <a href='mostrarusuario.php?CI=$CI'>
                                    <button class='mostrar'>Mostrar</button>
                                </a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr>
                        <td colspan='7' class='sin-registros'>No hay usuarios registrados</td>
                      </tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>

    <div class="boton-centro">
        <a href="crearusuario.php">
            <button class="nuevo">Nuevo usuario</button>
        </a>
    </div>
</div>

</body>
</html>