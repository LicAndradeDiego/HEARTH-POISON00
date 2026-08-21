<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo | HEARTH POISON</title>
    <link rel="stylesheet" href="urielgood.css">
    <style>
        * {
            text-decoration: none;
        }
        .card-link {
            display: block;
            color: inherit;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <main>
        <section class="animate-fade">
            <h2 class="section-title">El Catálogo</h2>
            
            <div class="cards-grid">
                
                <!-- PRODUCTO 1: Acqua Di Gio (ID/Código: 1) -->
                <div class="product-card">
                    <a href="productos/productosinfo/acqua.php" class="card-link">
                        <div class="img-container">
                            <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?q=80&w=600&auto=format&fit=crop" alt="Acqua Di Gio">
                        </div>
                        <div class="product-info">
                            <div class="brand">Giorgio Armani</div>
                            <h3>Acqua Di Gio</h3>
                            <div class="precio">Bs. 550</div>
                        </div>
                    </a>
                    <button class="btn-add" onclick="agregarAlCarrito('ACQUA DI GIO', 550, '1')">Añadir al carrito</button>
                </div>

                <!-- PRODUCTO 2: Versace Eros (ID/Código: 2) -->
                <div class="product-card">
                    <a href="productos/productosinfo/eros.php" class="card-link">
                        <div class="img-container">
                            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=600&auto=format&fit=crop" alt="Versace Eros">
                        </div>
                        <div class="product-info">
                            <div class="brand">Versace</div>
                            <h3>Versace Eros</h3>
                            <div class="precio">Bs. 650</div>
                        </div>
                    </a>
                    <button class="btn-add" onclick="agregarAlCarrito('VERSACE EROS', 650, '2')">Añadir al carrito</button>
                </div>

                <!-- PRODUCTO 3: Le Beau Paradise (ID/Código: 3) -->
                <div class="product-card">
                    <a href="productos/productosinfo/paradise.php" class="card-link">
                        <div class="img-container">
                            <img src="https://images.unsplash.com/photo-1523293182086-7651a899d37f?q=80&w=600&auto=format&fit=crop" alt="Le Beau">
                        </div>
                        <div class="product-info">
                            <div class="brand">Jean Paul Gaultier</div>
                            <h3>Le Beau Paradise</h3>
                            <div class="precio">Bs. 700</div>
                        </div>
                    </a>
                    <button class="btn-add" onclick="agregarAlCarrito('LE BEAU PARADISE', 700, '3')">Añadir al carrito</button>
                </div>

                <!-- PRODUCTO 4: Bleu De Chanel (ID/Código: 4) -->
                <div class="product-card">
                    <a href="productos/productosinfo/bleu.php" class="card-link">
                        <div class="img-container">
                            <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?q=80&w=600&auto=format&fit=crop" alt="Bleu de Chanel">
                        </div>
                        <div class="product-info">
                            <div class="brand">Chanel</div>
                            <h3>Bleu De Chanel</h3>
                            <div class="precio">Bs. 980</div>
                        </div>
                    </a>
                    <button class="btn-add" onclick="agregarAlCarrito('Bleu De Chanel', 980, '4')">Añadir al Carrito</button>
                </div>

            </div>
        </section>
    </main>

    <!-- CARRITO LATERAL -->
    <div id="cart-overlay" class="cart-overlay"></div>
    <div id="side-cart" class="side-cart">
        <div class="cart-header">
            <h3>Mi Carrito</h3>
            <span class="btn-close" onclick="cerrarSidebar()">&times;</span>
        </div>

        <div class="cart-body" id="cart-items">
            <p class="empty-msg">Tu carrito está vacío.</p>
        </div>

        <div class="cart-footer">
            <div class="cart-info-row">
                <span>Productos:</span>
                <span id="cart-count">0</span>
            </div>
            <div class="cart-total-row">
                <span>Total:</span>
                <span id="cart-total">Bs. 0.00</span>
            </div>
            <button class="btn-checkout" id="comprar">Finalizar compra</button>
            <button class="btn-vaciar" onclick="vaciarCarrito()">Vaciar carrito</button>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- JS EXTERNO VINCULADO -->
    <script src="carrito/carrito.js"></script>
</body>
</html>