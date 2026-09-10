<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEARTH POISON | Official Site</title>
    <link rel="stylesheet" href="urielgood.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <main>
        <section class="hero">
            <div class="hero-bg"></div>
            <div class="hero-content animate-fade">
                <h2>HEARTH POISON</h2>
                <p>Veneno en la piel, poder en el aire.</p>
                <a href="paginaproductos.php" class="btn">Descubrir Colección</a>
            </div>
        </section>

        <section class="animate-fade">
            <h2 class="section-title">Las Colecciones</h2>
            <div class="grid-editorial">
                <div class="box-editorial">
                    <h3>Odyssey Mandarin Sky</h3>
                    <p>Olores imprecnados de un dulce aroma a implecables lugares que te haran volar de frescura</p>
                </div>
                <div class="box-editorial">
                    <h3>Femme Absolu</h3>
                    <p>La máxima expresión de la sofisticación floral. Acordes misteriosos de alquimia pura que dejan una estela inolvidable.</p>
                </div>
                <div class="box-editorial">
                    <h3>Édition Privée</h3>
                    <p>Lotes limitados creados con las materias primas más raras del mundo. Extractos puros concebidos para el coleccionista exigente.</p>
                </div>
            </div>
        </section>

        <section class="animate-fade" id="seguimiento-pedido">
            <h2 class="section-title">Consulta tu pedido</h2>
            <div style="max-width:620px;margin:0 auto;background:#111;border:1px solid #292929;border-radius:18px;padding:28px;text-align:center;">
                <p style="color:#aaa;margin-bottom:18px;">Ingresa el número de tu pedido para conocer su estado.</p>
                <form id="formSeguimiento" style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
                    <input type="number" id="numeroPedido" min="1" required placeholder="N.º de pedido"
                        style="flex:1;min-width:220px;padding:13px;border-radius:8px;border:1px solid #333;background:#090909;color:#fff;">
                    <button type="submit" class="btn">Ver estado</button>
                </form>
                <div id="resultadoPedido" style="margin-top:20px;"></div>
            </div>
        </section>

    </main>


<script>
document.getElementById('formSeguimiento').addEventListener('submit', async function(e){
    e.preventDefault();
    const id=document.getElementById('numeroPedido').value;
    const box=document.getElementById('resultadoPedido');
    const fd=new FormData(); fd.append('id',id);
    try{
        const r=await fetch('paginasproductos/consultar_pedido.php',{method:'POST',body:fd});
        const data=await r.json();
        if(data.ok){
            box.innerHTML=`<div style="border:1px solid #333;border-radius:12px;padding:18px;text-align:left">
                <strong>Pedido #${data.pedido.id}</strong><br>
                Cliente: ${escapeHtml(data.pedido.nombre)}<br>
                Fecha: ${escapeHtml(data.pedido.fecha)}<br>
                <strong>Estado: ${escapeHtml(data.pedido.estado || 'Pendiente')}</strong>
            </div>`;
            if(window.Swal) Swal.fire({icon:'success',title:'Pedido encontrado',text:'Estado actual: '+(data.pedido.estado||'Pendiente'),confirmButtonColor:'#7a2735',background:'#111',color:'#fff'});
        }else{
            box.innerHTML='<p style="color:#ff7070">'+escapeHtml(data.mensaje)+'</p>';
            if(window.Swal) Swal.fire({icon:'error',title:'No encontrado',text:data.mensaje,confirmButtonColor:'#7a2735',background:'#111',color:'#fff'});
        }
    }catch(err){ box.innerHTML='<p style="color:#ff7070">No se pudo consultar el pedido.</p>'; }
});
function escapeHtml(v){return String(v??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));}
</script>

   <?php include 'footer.php'; ?>

</body>
</html>
