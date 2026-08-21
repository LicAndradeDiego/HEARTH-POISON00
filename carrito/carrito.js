//==============================
// ABRIR CARRITO
//==============================

function abrirCarrito() {
    document.getElementById("side-cart").classList.add("active");
    document.getElementById("cart-overlay").classList.add("active");
    actualizarCarrito();
}

//==============================
// CERRAR
//==============================

const cartOverlay = document.getElementById("cart-overlay");
if (cartOverlay) {
    cartOverlay.addEventListener("click", cerrarSidebar);
}

function cerrarSidebar() {
    document.getElementById("side-cart").classList.remove("active");
    document.getElementById("cart-overlay").classList.remove("active");
}

//==============================
// AGREGAR AL CARRITO
//==============================

function agregarAlCarrito(nombre, precio, codigo) {
    fetch("carrito/carrito.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `accion=agregar&codigo=${encodeURIComponent(codigo)}`
    })
    .then(res => res.json())
    .then(datos => {
        if (datos.ok) {
            actualizarCarrito();
        } else {
            alert(datos.mensaje); // Muestra el mensaje de error de PHP
        }
    })
    .catch(error => console.log("Error al agregar:", error));
}
//==============================
// ACTUALIZAR CARRITO
//==============================

function actualizarCarrito() {

    fetch("carrito/carrito.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "accion=mostrar"
    })
    .then(res => res.json())
    .then(datos => {

        console.log(datos);

        let html = "";
        let total = 0;
        let cantidadTotal = 0;

        if (!Array.isArray(datos) || datos.length === 0) {
            document.getElementById("cart-items").innerHTML = '<p class="empty-msg">Tu carrito está vacío.</p>';
            document.getElementById("cart-count").innerHTML = "0";
            document.getElementById("cart-total").innerHTML = "Bs. 0.00";
            return;
        }

        datos.forEach(producto => {

            let subtotal = Number(producto.CostoTotal);
            let cantidad = Number(producto.Cantidad);

            total += subtotal;
            cantidadTotal += cantidad;

            html += `
            <div class="cart-item" style="margin-bottom: 10px; border-bottom: 1px solid #333; padding-bottom: 5px;">
                <h3>${producto.Nombre}</h3>
                <p>Precio: Bs ${producto.Precio}</p>
                <p>Cantidad: ${cantidad}</p>
                <p>Subtotal: Bs ${subtotal}</p>
            </div>
            `;
        });

        document.getElementById("cart-items").innerHTML = html;
        document.getElementById("cart-count").innerHTML = cantidadTotal;
        document.getElementById("cart-total").innerHTML = "Bs. " + total;

    })
    .catch(error => {
        console.log("Error carrito:", error);
    });

}

//==============================
// VACIAR CARRITO
//==============================

function vaciarCarrito() {

    if (!confirm("¿Desea vaciar todo el carrito?")) {
        return;
    }

    fetch("carrito/carrito.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "accion=vaciar"
    })
    .then(res => res.json())
    .then(datos => {

        if (datos.ok) {
            actualizarCarrito();
        } else {
            alert(datos.mensaje);
        }

    })
    .catch(error => {
        console.log(error);
    });

}

//==============================
// CONFIRMAR Y REDIRIGIR AL RECIBO
//==============================

document.addEventListener("click", function(e) {

    if (e.target.id == "comprar" || e.target.classList.contains("btn-checkout")) {

    fetch("pedidos/finalizarpedido.php")
    .then(res => res.json())
    .then(data => {

        if (data.ok) {
            window.location.href = "pedidos/recibo.php";
        } else {
            alert(data.mensaje);
        }

    })
    .catch(error => {
        console.log("Error al finalizar:", error);
    });

}

});

document.addEventListener("DOMContentLoaded", actualizarCarrito);