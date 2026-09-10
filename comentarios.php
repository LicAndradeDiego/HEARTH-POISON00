<?php
session_start();
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Comentarios | Hearth Poison</title><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body{margin:0;background:#080808;color:#fff;font-family:Arial,sans-serif}.box{max-width:650px;margin:150px auto 70px;background:#111;padding:35px;border-radius:18px;border:1px solid #292929}
h1{text-align:center;font-weight:300;letter-spacing:4px;text-transform:uppercase}label{display:block;margin:18px 0 7px;color:#aaa;font-size:12px;text-transform:uppercase;letter-spacing:1px}
input,textarea{width:100%;padding:12px;box-sizing:border-box;background:#090909;color:#fff;border:1px solid #333;border-radius:8px}textarea{min-height:150px;resize:vertical}
button,.ver{display:inline-block;margin-top:22px;padding:12px 20px;border:0;border-radius:8px;background:#fff;color:#000;font-weight:700;text-decoration:none;cursor:pointer}.ver{margin-left:8px;background:#292929;color:#fff}
</style></head><body>
<?php include 'header.php'; ?>
<div class="box"><h1>Comentarios y sugerencias</h1>
<p style="color:#999;text-align:center">Tu opinión nos ayuda a mejorar la experiencia de Hearth Poison.</p>
<form action="comentarios/comentarios.php" method="post" data-validar>
<label for="nom">Nombre</label><input id="nom" name="nom" maxlength="60" required>
<label for="asu">Asunto</label><input id="asu" name="asu" maxlength="100" required>
<label for="com">Comentario</label><textarea id="com" name="com" maxlength="1000" required></textarea>
<button type="submit">Enviar comentario</button><a class="ver" href="comentarios/vercomentarios.php">Ver comentarios</a>
</form></div>
<script src="validacion.js"></script></body></html>