<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="urielgood.css">
</head>
<body>
       <?php include 'header.php'; ?>
    <form action="uno.php" method="post">
        <label for="">Nombre</label>
        <input type="text" name="nom">
        <label for="">Asunto</label>
        <input type="text" name="asu">
        <label for="">Comentarios</label>
        <textarea  name="com" id=""></textarea>
        <input type="submit" value="Enviar">
        <input type="reset" value="Borrar">
    </form>
    <?php include 'footer.php'; ?>
</body>
</html>