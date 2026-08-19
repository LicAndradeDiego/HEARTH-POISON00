<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        header {
    background: rgba(10, 10, 10, 0.95);
    backdrop-filter: blur(10px);
    padding: 20px 50px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    border-bottom: 1px solid #1a1a1a;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.4s ease;
    font-family: 'Helvetica Neue', Arial, sans-serif;
}

header h1 {
    color: #ffffff;
    font-size: 28px;
    font-weight: 300;
    letter-spacing: 6px;
    margin-bottom: 15px;
    text-transform: uppercase;
}

nav {
    display: flex;
    justify-content: center;
    gap: 35px;
}

nav a {
    color: #999;
    text-decoration: none;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 400;
    transition: color 0.3s ease;
}

nav a:hover, nav a.active {
    color: #ffffff;
}



    </style>
</head>
<body>
     <header>
        <h1>HEARTH POISON</h1>
        <nav>
            <a href="paginaprincipal.php" class="active">Inicio</a>
            <a href="paginanosotros.php">Nosotros</a>
            <a href="paginaproductos.php">Productos</a>
            <a href="usuario/paginasesion.php">Iniciar Sesión</a>
        </nav>
    </header>
</body>
</html>