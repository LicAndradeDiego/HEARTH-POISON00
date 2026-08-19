<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header | HEARTH POISON</title>
    <style>
        /* ==============================
           ESTILOS DEL HEADER PRINCIPAL
        ============================== */
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
            box-sizing: border-box;
        }

        header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 6px;
            margin: 0 0 15px 0;
            text-transform: uppercase;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 35px;
        }

        nav a {
            color: #999999;
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

        /* ==============================
           BOTÓN E ÍCONO DEL CARRITO
        ============================== */
        .carrito-btn {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .carrito-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Ícono SVG moderno para el carrito */
        .carrito-btn svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: #ffffff;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ==============================
           FONDO Y SIDEBAR DEL CARRITO
        ============================== */
        .fondo {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 2000;
        }

        .fondo.activo {
            opacity: 1;
            visibility: visible;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 380px;
            max-width: 90%;
            height: 100vh;
            background: #0f0f0f;
            border-left: 1px solid #1a1a1a;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.8);
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            z-index: 2001;
            display: flex;
            flex-direction: column;
            color: #ffffff;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .sidebar.activo {
            transform: translateX(0);
        }

        /* Cabecera del Panel */
        .cabeceraCarrito {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 25px;
            background: #0a0a0a;
            border-bottom: 1px solid #1a1a1a;
        }

        .cabeceraCarrito h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 300;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        #cerrarCarrito {
            border: none;
            background: transparent;
            color: #888;
            font-size: 26px;
            cursor: pointer;
            line-height: 1;
            transition: color 0.3s ease;
        }

        #cerrarCarrito:hover {
            color: #ffffff;
        }

        /* Contenido de productos */
        .contenidoCarrito {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        /* Pie del Carrito */
        .pieCarrito {
            padding: 25px;
            background: #0a0a0a;
            border-top: 1px solid #1a1a1a;
        }

        .resumenCarrito {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #888888;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        #totalCarrito {
            margin: 10px 0 20px 0;
            color: #ffffff;
            font-size: 18px;
            font-weight: 300;
            letter-spacing: 1px;
        }

        /* Botón Finalizar Compra */
        #comprar {
            width: 100%;
            border: none;
            padding: 14px;
            background: #ffffff;
            color: #000000;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #comprar:hover {
            background: #cccccc;
        }

        /* Botón Vaciar Carrito */
        #vaciarCarrito {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #333333;
            background: transparent;
            color: #777777;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #vaciarCarrito:hover {
            border-color: #666666;
            color: #ffffff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
            }
            .carrito-btn {
                right: 20px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>HEARTH POISON</h1>
        
        <nav>
            <a href="/HEARTH-POISON00/paginaprincipal.php">Inicio</a>
<a href="/HEARTH-POISON00/paginanosotros.php">Nosotros</a>
<a href="/HEARTH-POISON00/paginaproductos.php">Productos</a>
<a href="/HEARTH-POISON00/usuario/paginasesion.php">Iniciar Sesión</a>
        </nav>

        <!-- Botón del Carrito en la esquina superior derecha -->
        <div id="carrito" class="carrito-btn" onclick="abrirCarrito()">
            <svg viewBox="0 0 24 24">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
        </div>
    </header>

    <!-- Fondo oscuro traslucido -->
    <div id="fondo" class="fondo" onclick="cerrarCarrito()"></div>

    <!-- Panel Lateral del Carrito (Sidebar) -->
    <aside id="sidebar" class="sidebar">

        <div class="cabeceraCarrito">
            <h2>Mi Carrito</h2>
            <button id="cerrarCarrito" type="button" onclick="cerrarCarrito()">&times;</button>
        </div>

        <div id="contenidoCarrito" class="contenidoCarrito">
            <p style="color: #666; font-size: 13px; text-align: center; margin-top: 40px;">Tu carrito está vacío.</p>
        </div>

        <div class="pieCarrito">
            <div class="resumenCarrito">
                <span>Productos:</span>
                <span id="cantidadCarrito">0</span>
            </div>

            <h3 id="totalCarrito">Total: Bs 0.00</h3>

            <button id="comprar" type="button" onclick="window.location.href='pedidos/crearpedido.php'">
                Finalizar compra
            </button>

            <button id="vaciarCarrito" type="button" onclick="vaciarCarrito()">
                Vaciar carrito
            </button>
        </div>

    </aside>

    <!-- Script básico para abrir/cerrar el carrito -->
    <script>
        function abrirCarrito() {
            document.getElementById('sidebar').classList.add('activo');
            document.getElementById('fondo').classList.add('activo');
        }

        function cerrarCarrito() {
            document.getElementById('sidebar').classList.remove('activo');
            document.getElementById('fondo').classList.remove('activo');
        }

        function vaciarCarrito() {
            document.getElementById('contenidoCarrito').innerHTML = '<p style="color: #666; font-size: 13px; text-align: center; margin-top: 40px;">Tu carrito está vacío.</p>';
            document.getElementById('cantidadCarrito').innerText = '0';
            document.getElementById('totalCarrito').innerText = 'Total: Bs 0.00';
        }
    </script>

</body>
</html>