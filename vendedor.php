<?php
session_start();
$nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel de Vendedor | Hearth Poison</title>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:
    radial-gradient(circle at top right,#1a1113 0%,#050505 45%),
    #050505;
    color:#fff;
    font-family:'Inter',sans-serif;
}



main{
    max-width:1400px;
    margin:140px auto 120px;
    padding:0 50px;
}


.titulo{
    text-align:center;
    margin-bottom:70px;
}

.titulo span{
    color:#8d8d8d;
    letter-spacing:4px;
    text-transform:uppercase;
    font-size:.8rem;
}

.titulo h1{
    font-family:'Cormorant Garamond',serif;
    font-size:5rem;
    font-weight:500;
    margin-top:10px;
    letter-spacing:2px;
}

.titulo p{
    max-width:650px;
    margin:20px auto 0;
    color:#a5a5a5;
    line-height:1.8;
}



.panel{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:30px;
}



.card{
    background:
    linear-gradient(180deg,#111,#090909);

    border:1px solid rgba(255,255,255,.06);
    border-radius:30px;

    padding:35px;

    transition:.45s;
    position:relative;
    overflow:hidden;
}

.card::before{
    content:"";
    position:absolute;
    top:-50%;
    right:-50%;
    width:250px;
    height:250px;

    background:
    radial-gradient(circle,
    rgba(122,39,53,.15),
    transparent 70%);
}

.card:hover{
    transform:translateY(-10px);

    border-color:#7a2735;

    box-shadow:
    0 25px 60px rgba(0,0,0,.55),
    0 0 40px rgba(122,39,53,.15);
}



.icono{
    width:70px;
    height:70px;

    display:flex;
    justify-content:center;
    align-items:center;

    border-radius:20px;

    font-size:30px;

    background:
    linear-gradient(
    135deg,
    #7a2735,
    #331116
    );

    margin-bottom:25px;
}



.card h2{
    font-family:'Cormorant Garamond',serif;
    font-size:2.2rem;
    font-weight:500;
    margin-bottom:15px;
}

.card p{
    color:#a3a3a3;
    line-height:1.9;
    margin-bottom:30px;
}



.btn{
    display:inline-flex;
    align-items:center;
    gap:10px;

    text-decoration:none;
    color:white;

    padding:14px 26px;

    border-radius:14px;

    background:
    linear-gradient(
    135deg,
    #7a2735,
    #4d1922
    );

    transition:.3s;
}

.btn:hover{
    transform:translateY(-3px);

    box-shadow:
    0 12px 25px rgba(122,39,53,.35);
}






@media(max-width:900px){

    main{
        padding:0 20px;
        margin-top:120px;
    }

    .titulo h1{
        font-size:3.4rem;
    }

    .stats{
        grid-template-columns:1fr;
    }

}
.cerrar{
    position:fixed;
    top:30px;
    right:30px;
    z-index:9999;

    display:flex;
    align-items:center;
    gap:10px;

    text-decoration:none;
    color:#fff;

    padding:12px 20px;

    border-radius:14px;

    background:linear-gradient(
    135deg,
    #7a2735,
    #4d1922
    );

    transition:.3s;

    box-shadow:
    0 10px 25px rgba(122,39,53,.25);
}

.cerrar:hover{
    transform:translateY(-3px);

    box-shadow:
    0 15px 30px rgba(122,39,53,.4);
}

.cerrar img{
    width:20px;
    height:20px;
    object-fit:contain;
}

.cerrar span{
    font-size:.8rem;
    letter-spacing:1px;
    font-weight:500;
}

</style>
</head>

<body>

<?php include 'header.php'; ?>
<a href="usuario/cerrarsesion.php" class="cerrar">
    <img src="imagenes/cerrar.png" alt="">
    <span>Cerrar Sesión</span>
</a>
<main>

    <div class="titulo">
        <span>Panel de Vendedor</span>
        <h1>¡Bienvenido/a, <?php echo $nombre; ?>!</h1>

        <p>
            Gestiona ventas, pedidos e inventario desde una plataforma
            diseñada para mantener la experiencia premium de Hearth Poison.
        </p>
    </div>

    <div class="panel">

        <div class="card">

            <div class="icono"><img src="imagenes/ventas.png" alt=""></div>

            <h2>Ventas hoy</h2>

            <p>
                Registra nuevas ventas, genera facturas y administra
                la información de tus clientes.
            </p>

            <a href="pedidos/leerpedido.php" class="btn">
                Pedidos →
            </a>

        </div>

        <div class="card">

            <div class="icono"><img src="imagenes/inventario-disponible.png" alt=""></div>

            <h2>Inventario</h2>

            <p>
                Consulta existencias, disponibilidad de productos
                y alertas de reposición.
            </p>

            <a href="productos/leerproducto.php" class="btn">
                Ver stock →
            </a>

        </div>

        <div class="card">

            <div class="icono"><img src="imagenes/entrega-de-pedidos.png" alt=""></div>

            <h2>Pedidos</h2>

            <p>
                Supervisa pedidos pendientes, en preparación
                y entregas realizadas.
            </p>

            <a href="pedidos/crearpedido.php" class="btn">
                Nuevos Pedidos →
            </a>

        </div>

        <div class="card">

            <div class="icono"><img src="imagenes/analitica.png" alt=""></div>

            <h2>Reportes</h2>

            <p>
                Analiza ventas, ingresos y rendimiento
                comercial de manera rápida.
            </p>

            <a href="#" class="btn">
                Ver reportes →
            </a>

        </div>

    </div>

</main>

<?php include 'footer.php'; ?>

</body>
</html>

