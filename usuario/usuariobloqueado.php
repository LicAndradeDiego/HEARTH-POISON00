<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USUARIO BLOQUEADO</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 0;
        }

        .contenedor {
            width: 450px;
            background: #0f0f0f;
            border: 1px solid #1a1a1a;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
            text-align: center;
        }

        h2 {
            font-size: 20px;
            font-weight: 300;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: #ff4d4d; /* Un tono rojo sutil para denotar bloqueo */
        }

        p {
            font-size: 13px;
            color: #aaa;
            letter-spacing: 1px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .acciones {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .buttom {
            width: 100%;
            padding: 14px;
            background: #fff;
            color: #000;
            border: none;
            border-radius: 8px;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            transition: 0.4s ease;
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
        }

        .buttom:hover {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }

        .buttom-secundario {
            background: transparent;
            color: #fff;
            border: 1px solid #2a2a2a;
        }

        .buttom-secundario:hover {
            background: #fff;
            color: #000;
            border-color: #fff;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Su cuenta está bloqueada</h2>
    <p>No tiene acceso al sistema. Por favor, póngase en contacto con el administrador para restablecer su acceso.</p>

    <div class="acciones">
        <a href="login.php" class="buttom">Iniciar Sesión</a>
        <a href="crearusuario.php" class="buttom buttom-secundario">Crear Cuenta</a>
    </div>
</div>

</body>
</html>