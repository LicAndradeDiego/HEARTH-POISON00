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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        <section class="animate-fade" id="seguimiento-pedido" style="margin-top:70px;">
            <h2 class="section-title">Estado de mi pedido</h2>
            <div style="max-width:620px;margin:0 auto;background:#111;border:1px solid #292929;border-radius:18px;padding:28px;text-align:center;">
                <p style="color:#aaa;margin-bottom:18px;">Consulta el estado de tu pedido con su número.</p>
                <form id="formSeguimientoProductos" style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
                    <input type="number" id="numeroPedidoProductos" min="1" required placeholder="N.º de pedido"
                    style="flex:1;min-width:220px;padding:13px;border-radius:8px;border:1px solid #333;background:#090909;color:#fff;">
                    <button type="submit" class="btn">Consultar estado</button>
                </form>
                <div id="resultadoPedidoProductos" style="margin-top:20px;"></div>
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


<script>
document.getElementById('formSeguimientoProductos').addEventListener('submit',async e=>{
 e.preventDefault(); const fd=new FormData(); fd.append('id',document.getElementById('numeroPedidoProductos').value);
 const box=document.getElementById('resultadoPedidoProductos');
 try{const r=await fetch('paginasproductos/consultar_pedido.php',{method:'POST',body:fd});const d=await r.json();
 if(d.ok){box.innerHTML='<div style="padding:15px;border:1px solid #333;border-radius:10px">Pedido #'+d.pedido.id+' · Estado: <strong>'+esc(d.pedido.estado||'Pendiente')+'</strong></div>';
 if(window.Swal)Swal.fire({icon:'success',title:'Estado del pedido',text:d.pedido.estado||'Pendiente',confirmButtonColor:'#7a2735',background:'#111',color:'#fff'});
 }else{box.innerHTML='<p style="color:#ff7070">'+esc(d.mensaje)+'</p>'; if(window.Swal)Swal.fire({icon:'error',title:'Pedido no encontrado',text:d.mensaje,confirmButtonColor:'#7a2735',background:'#111',color:'#fff'});}
 }catch(x){box.innerHTML='<p style="color:#ff7070">No se pudo consultar el pedido.</p>';}
});
function esc(v){return String(v??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));}
</script>

    <?php include 'footer.php'; ?>

    <!-- JS EXTERNO VINCULADO -->
    <script src="carrito/carrito.js"></script>
</body>
</html>