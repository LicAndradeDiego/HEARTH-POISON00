<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acqua Di Gio | HEARTH POISON</title>
    <!-- Ruta corregida para el CSS -->
    <link rel="stylesheet" href="../../estilocproc.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">  
</head>
<body>
    <!-- Subimos 2 niveles para encontrar header.php en la raíz -->
    <?php include '../../header.php'; ?>

    <section class="principal">
        <section class="imagen">
           <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?q=80&w=600&auto=format&fit=crop" alt="Acqua Di Gio">
        </section>
        
        <section class="informacion">
            <p class="categoria">Perfume de mujer</p>
            <h1>Acqua Di Gio</h1>
            <h2>Giorgio Armani</h2>
            <p class="desc">Descubre la frescura y elegancia de Acqua Di Gio, una fragancia icónica inspirada en la fuerza del mar 
                y la libertad de la naturaleza. Sus notas cítricas y acuáticas se combinan con delicados matices aromáticos y
                amaderados, creando un aroma fresco, sofisticado y versátil. Perfecto para el uso diario, este perfume transmite
                una sensación de limpieza, energía y confianza que perdura durante todo el día.</p>
            <p class="det">
                Familia olfativa: Aromática Acuática<br>
                Aroma: Fresco, cítrico y elegante<br>
                Ideal para: Uso diario, oficina, reuniones y ocasiones especiales<br>
                Duración: Larga duración
            </p>
            <p class="precio">
                Bs. 550
            </p>

            <!-- Redirección corregida subiendo 1 nivel hacia la carpeta 'productos' -->
            <button type="button" onclick="window.location.href='../paginaproductos.php'">Volver al catálogo</button>
        </section>
    </section>

    <!-- Subimos 2 niveles para encontrar footer.php en la raíz -->
    <?php include '../../footer.php'; ?>
</body>
</html>