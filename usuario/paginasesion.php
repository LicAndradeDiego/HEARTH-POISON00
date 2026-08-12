<?php
session_start();
$nombre = $_SESSION['nombre'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            min-height:100vh;
            overflow:hidden;
            position:relative;
            background:#0a0a0a;
        }

        .capa{
            position: fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background: rgba(0,0,0,0.60);
            z-index:-1;
        }

        .login-wrapper{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:30px;
        }

        .login-box{
            width:100%;
            max-width:450px;
            background: rgba(20,20,20,0.90);
            border: 3px solid rgba(255, 75, 246, 0.83);
            border-radius: 15px;
            padding: 45px 35px;
            text-align:center;
            color:white;
            box-shadow:0 0 30px rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
        }

        .login-box h2{
            font-size: 26px;
            font-weight: 300;
            letter-spacing: 3px;
            margin-bottom: 30px;
            text-transform: uppercase;
            color: white;
        }

        .input-group{
            margin-bottom:20px;
            text-align:left;
        }

        .input-group label{
            display:block;
            color:#d0d0d0;
            margin-bottom:8px;
            letter-spacing:1px;
            text-transform:uppercase;
            font-size:13px;
        }

        .input-group input{
            width:100%;
            padding:14px;
            background: rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.15);
            color:white;
            font-size:14px;
            outline:none;
            transition:all .3s ease;
        }

        .input-group input:focus{
            border-color:white;
            background: rgba(255,255,255,0.08);
        }

        .input-group input::placeholder{
            color:#888;
        }

        .btn-block{
            width:100%;
            padding:14px;
            background: transparent;
            border:1px solid white;
            color:white;
            text-transform:uppercase;
            letter-spacing:2px;
            cursor:pointer;
            transition:all .3s ease;
            font-size:14px;
            margin-top:10px;
        }

        .btn-block:hover{
            background:white;
            color:black;
        }

        .btn-secondary{
            display:inline-block;
            margin-top:20px;
            color:#d0d0d0;
            text-decoration:none;
            font-size:12px;
            letter-spacing:1px;
            text-transform:uppercase;
            transition:0.3s;
        }

        .btn-secondary:hover{
            color:#ffb3f7;
        }

        @media (max-width: 600px){
            .login-box{
                padding:30px 20px;
            }

            .login-box h2{
                font-size:22px;
            }
        }
    </style>
</head>
<body>

    <?php include '../header.php'; ?>

    <div class="capa"></div>

    <div class="login-wrapper">
        <div class="login-box">
            <h2>Bienvenido</h2>

            <form action="val.php" method="POST">
                
                <div class="input-group">
                    <label>Nombre</label>
                    <input type="text" name="Nombre" id="nombre" placeholder="NOMBRE(S)" required>
                </div>

                <div class="input-group">
                    <label>CI</label>
                    <input type="number" name="CI" id="CI" placeholder="CARNET DE IDENTIDAD" required>
                </div>

                <button type="submit" class="btn-block">Iniciar Sesión</button>

                <a href="crearusuario.php" class="btn-secondary">Crear Usuario</a>
            </form>
        </div>
    </div>

</body>
</html>