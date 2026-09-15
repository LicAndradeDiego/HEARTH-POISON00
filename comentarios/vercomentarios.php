<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Comentarios | HEARTH POISON</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #111;
            color: white;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .contenedor {
            width: 90%;
            max-width: 800px;
            margin: auto;
        }

        h1 {
            text-align: center;
            color: #e63946;
            margin-bottom: 30px;
        }

        .comentario {
            background: #222;
            border: 1px solid #444;
            border-left: 5px solid #e63946;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        }

        .dato {
            margin-bottom: 12px;
        }

        .dato strong {
            color: #e63946;
        }

        .texto {
            color: #ddd;
            line-height: 1.6;
        }

        .volver {
            display: block;
            width: fit-content;
            margin: 30px auto;
            padding: 12px 25px;
            background: #e63946;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .volver:hover {
            background: #b71c2a;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Comentarios</h1>

    <?php

    $arch = fopen("comentario.txt", "r");

    while (!feof($arch)) {

        $nombre = fgets($arch);
        $asunto = fgets($arch);
        $comentario = fgets($arch);

        if ($nombre !== false && $asunto !== false && $comentario !== false) {

            // Quitamos las etiquetas
            $nombre = str_replace("NOMBRE:", "", $nombre);
            $asunto = str_replace("ASUNTO:", "", $asunto);
            $comentario = str_replace("COMENTARIO:", "", $comentario);

            // Quitamos espacios y saltos de línea
            $nombre = trim($nombre);
            $asunto = trim($asunto);
            $comentario = trim($comentario);

            ?>

            <div class="comentario">

                <div class="dato">
                    <strong>Nombre:</strong>
                    <?php echo htmlspecialchars($nombre); ?>
                </div>

                <div class="dato">
                    <strong>Asunto:</strong>
                    <?php echo htmlspecialchars($asunto); ?>
                </div>

                <div class="dato">
                    <strong>Comentario:</strong>
                    <div class="texto">
                        <?php echo nl2br(htmlspecialchars($comentario)); ?>
                    </div>
                </div>

            </div>

            <?php
        }
    }

    fclose($arch);

    ?>

    <a href="../comentarios.php" class="volver">← Volver</a>

</div>

</body>
</html>