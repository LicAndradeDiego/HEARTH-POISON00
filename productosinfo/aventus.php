<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilocproc.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">  
</head>
<body>
     <?php include '../header.php'; ?>
    <section class="principal" >
        <section class="imagen">
             <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?q=80&w=600&auto=format&fit=crop" alt="Creed Aventus">

        </section>
        <section class="informacion">
            <p class="categoria">Perfume de varón</p>
            <h1>Aventus Heritage<h1>
            <h2>Creed</h2>
            <p class="desc">Aventus Heritage es una fragancia sofisticada y poderosa que combina frescura, elegancia y carácter en una composición equilibrada y atemporal. Sus notas frutales, amaderadas y aromáticas crean un aroma distintivo que transmite confianza, éxito y refinamiento, dejando una estela moderna y memorable.</p>
            <p class="det">
               Familia olfativa: Frutal · Amaderada · Aromática
Sensación: Elegante, fresca y segura
Ideal para: Uso diario, reuniones, eventos y ocasiones especiales
Duración: Excelente, con una presencia refinada y duradera.
            </p>
            <p class="precio">
                Bs.2100
            </p>
            <a href="../pedidos/crearpedido.php">
                <button>Añadir al carrito</button>
            </a>
        </section>
    </section>
    <?php include '../footer.php'; ?>
</body>
</html>