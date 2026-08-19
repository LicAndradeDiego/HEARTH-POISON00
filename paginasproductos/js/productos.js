let listaProductos = [];
let pedidoActivo = false;


// ==========================================
// SWEET ALERT
// ==========================================

function mostrarAlerta(
    mensaje,
    elemento = null,
    icono = "error"
) {

    Swal.fire({

        icon: icono,

        title:
            icono === "success"
                ? "¡Listo!"
                : "¡Oops!",

        text: mensaje,

        confirmButtonColor: "#62a38a",

        confirmButtonText: "Entendido"

    }).then(() => {

        if (elemento) {

            elemento.focus();

        }

    });

}


// ==========================================
// CARGAR PRODUCTOS
// ==========================================

document.addEventListener(
    "DOMContentLoaded",
    () => {

        mostrarProductos();

    }
);


// ==========================================
// MOSTRAR PRODUCTOS
// ==========================================

function mostrarProductos() {

    fetch("obtenerproductos.php")

        .then(respuesta => {

            if (!respuesta.ok) {

                throw new Error(
                    "Error HTTP: " +
                    respuesta.status
                );

            }

            return respuesta.json();

        })


        .then(productos => {

            console.log(
                "Productos:",
                productos
            );


            listaProductos = productos;


            const contenedor =
                document.getElementById(
                    "productos"
                );


            if (!contenedor) {

                console.log(
                    "No existe el elemento #productos"
                );

                return;

            }


            contenedor.innerHTML = "";


            // ==========================================
            // CREAR TARJETAS
            // ==========================================

            productos.forEach(producto => {

                contenedor.innerHTML += `

                    <div
                        class="proc"
                        data-codigo="${producto.codigo}"
                    >

                        <div class="img-producto">

                            <img
                                class="imgb"
                                src="../imagenes/producto.png"
                                alt="${producto.nombre}"
                            >

                        </div>


                        <div class="ba">

                            <h1>
                                ${producto.nombre}
                            </h1>

                            <p>
                                ${producto.descripcion}
                            </p>

                        </div>


                        <div class="bb">

                            <h1 class="precio">

                                Bs.
                                ${producto.precio}

                            </h1>


                            <div class="cantidad">

                                <button
                                    type="button"
                                    class="btnCantidad"
                                    data-codigo="${producto.codigo}"
                                    data-cambio="-1"
                                >
                                    -
                                </button>


                                <span
                                    id="cantidad-${producto.codigo}"
                                >
                                    1
                                </span>


                                <button
                                    type="button"
                                    class="btnCantidad"
                                    data-codigo="${producto.codigo}"
                                    data-cambio="1"
                                >
                                    +
                                </button>

                            </div>


                            <button
                                type="button"
                                class="anadir"
                                data-codigo="${producto.codigo}"
                            >

                                <img
                                    class="carro"
                                    src="../imagenes/anadir-al-carrito.png"
                                    alt="Añadir al carrito"
                                >

                                <p>
                                    Añadir
                                </p>

                            </button>

                        </div>

                    </div>

                `;

            });


            // ==========================================
            // ABRIR PRODUCTO INDIVIDUAL
            // ==========================================

            document
                .querySelectorAll(".proc")
                .forEach(tarjeta => {

                    tarjeta.addEventListener(
                        "click",
                        function(event) {


                            // No abrir producto
                            // al presionar cantidad

                            if (
                                event.target.closest(
                                    ".btnCantidad"
                                )
                            ) {

                                return;

                            }


                            // No abrir producto
                            // al presionar añadir

                            if (
                                event.target.closest(
                                    ".anadir"
                                )
                            ) {

                                return;

                            }


                            const codigo =
                                this.dataset.codigo;


                            if (!codigo) {

                                console.log(
                                    "No se encontró el código del producto"
                                );

                                return;

                            }


                            const parametros =
                                new URLSearchParams(
                                    window.location.search
                                );


                            const idPedido =
                                parametros.get(
                                    "idPedido"
                                );


                            let url =
                                "producto.php?codigo=" +
                                encodeURIComponent(
                                    codigo
                                );


                            // ==========================================
                            // ENVIAR ID DEL PEDIDO
                            // ==========================================

                            if (idPedido) {

                                url +=
                                    "&idPedido=" +
                                    encodeURIComponent(
                                        idPedido
                                    );

                            }


                            console.log(
                                "Abriendo:",
                                url
                            );


                            window.location.href =
                                url;

                        }

                    );

                });


            // ==========================================
            // BOTONES + Y -
            // ==========================================

            document
                .querySelectorAll(".btnCantidad")
                .forEach(boton => {

                    boton.addEventListener(
                        "click",
                        function(event) {

                            event.preventDefault();

                            event.stopPropagation();


                            const codigo =
                                this.dataset.codigo;


                            const cambio =
                                parseInt(
                                    this.dataset.cambio
                                );


                            cambiarCantidad(
                                codigo,
                                cambio
                            );

                        }

                    );

                });


            // ==========================================
            // BOTONES AÑADIR
            // ==========================================

            document
                .querySelectorAll(".anadir")
                .forEach(boton => {

                    boton.addEventListener(
                        "click",
                        function(event) {

                            event.preventDefault();

                            event.stopPropagation();


                            const codigo =
                                this.dataset.codigo;


                            anadirAlCarrito(
                                codigo
                            );

                        }

                    );

                });

        })


        .catch(error => {

            console.log(
                "Error al cargar productos:",
                error
            );

        });

}


// ==========================================
// CAMBIAR CANTIDAD
// ==========================================

function cambiarCantidad(
    codigo,
    cambio
) {

    const span =
        document.getElementById(
            "cantidad-" + codigo
        );


    if (!span) {

        return;

    }


    let cantidad =
        parseInt(
            span.textContent
        );


    cantidad += cambio;


    if (cantidad < 1) {

        cantidad = 1;

    }


    span.textContent =
        cantidad;

}


// ==========================================
// AÑADIR AL CARRITO
// ==========================================

function anadirAlCarrito(
    codigo
) {

    const span =
        document.getElementById(
            "cantidad-" + codigo
        );


    // ==========================================
    // NO SE ENCONTRÓ LA CANTIDAD
    // ==========================================

    if (!span) {

        mostrarAlerta(
            "No se encontró la cantidad del producto.",
            null,
            "error"
        );

        return;

    }


    let cantidad =
        parseInt(
            span.textContent
        );


    if (cantidad < 1) {

        cantidad = 1;

    }


    const parametros =
        new URLSearchParams(
            window.location.search
        );


    const idPedido =
        parametros.get(
            "idPedido"
        );


    console.log(
        "Código:",
        codigo
    );


    console.log(
        "Cantidad:",
        cantidad
    );


    console.log(
        "ID DEL PEDIDO:",
        idPedido
    );


    // ==========================================
    // NO SE ENCONTRÓ EL ID DEL PEDIDO
    // ==========================================

    if (!idPedido) {

        Swal.fire({

            icon: "error",

            title: "¡Oops!",

            text:
                "No se encontró el ID del pedido.",

            confirmButtonColor:
                "#62a38a",

            confirmButtonText:
                "Entendido"

        }).then(() => {

            window.location.href =
                "crearpedidocliente.php";

        });


        return;

    }


    // ==========================================
    // ENVIAR AL CARRITO
    // ==========================================

    fetch(
        "carrito.php",
        {

            method: "POST",

            headers: {

                "Content-Type":
                    "application/x-www-form-urlencoded"

            },


            body:

                "accion=agregar" +

                "&codigo=" +
                encodeURIComponent(
                    codigo
                ) +

                "&cantidad=" +
                encodeURIComponent(
                    cantidad
                ) +

                "&idPedidos=" +
                encodeURIComponent(
                    idPedido
                )

        }

    )


        .then(respuesta => {

            console.log(
                "Estado HTTP:",
                respuesta.status
            );


            return respuesta.text();

        })


        .then(texto => {

            console.log(
                "RESPUESTA DE carrito.php:"
            );


            console.log(
                texto
            );


            let datos;


            try {

                datos =
                    JSON.parse(
                        texto
                    );

            }


            catch(error) {

                console.log(
                    "carrito.php NO devolvió JSON"
                );


                console.log(
                    "Respuesta recibida:",
                    texto
                );


                Swal.fire({

                    icon: "error",

                    title: "¡Oops!",

                    text:
                        "carrito.php está devolviendo un error. Revisa F12 > Console.",

                    confirmButtonColor:
                        "#62a38a",

                    confirmButtonText:
                        "Entendido"

                });


                return;

            }


            console.log(
                "Datos recibidos:",
                datos
            );


            // ==========================================
            // PRODUCTO AGREGADO
            // ==========================================

            if (datos.ok) {

                mostrarAlerta(
                    datos.mensaje,
                    null,
                    "success"
                );


                span.textContent =
                    "1";


                if (
                    typeof actualizarCarrito ===
                    "function"
                ) {

                    actualizarCarrito();

                }

            }


            else {

                mostrarAlerta(
                    datos.mensaje,
                    null,
                    "error"
                );

            }

        })


        .catch(error => {

            console.log(
                "ERROR REAL AL CONECTAR CON carrito.php:"
            );


            console.log(
                error
            );


            Swal.fire({

                icon: "error",

                title: "¡Oops!",

                text:
                    "Error al conectar con carrito.php",

                confirmButtonColor:
                    "#62a38a",

                confirmButtonText:
                    "Entendido"

            });

        });

}


// ==========================================
// HABILITAR COMPRA
// ==========================================

function habilitarCompra() {

    pedidoActivo = true;


    document
        .querySelectorAll(".anadir")
        .forEach(boton => {

            boton.disabled = false;

        });

}