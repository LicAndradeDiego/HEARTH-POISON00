// ==========================================
// CARGAR PRODUCTO
// ==========================================

function cargarProducto() {

    const parametros =
        new URLSearchParams(
            window.location.search
        );


    const codigo =
        parametros.get("codigo");


    const idPedido =
        parametros.get("idPedido");


    console.log("=================================");
    console.log("CARGANDO PRODUCTO");
    console.log("Código:", codigo);
    console.log("ID Pedido:", idPedido);
    console.log("=================================");


    // ==========================================
    // COMPROBAR CÓDIGO
    // ==========================================

    if (!codigo) {

        console.log(
            "No se encontró el código del producto en la URL."
        );

        return;

    }


    // ==========================================
    // CONSULTAR PRODUCTO
    // ==========================================

    fetch(
        "obtenerproducto.php?codigo=" +
        encodeURIComponent(codigo)
    )

        .then(respuesta => {

            console.log(
                "Estado obtenerproducto.php:",
                respuesta.status
            );


            if (!respuesta.ok) {

                throw new Error(
                    "Error HTTP: " +
                    respuesta.status
                );

            }


            return respuesta.json();

        })


        .then(producto => {

            console.log(
                "Producto recibido:",
                producto
            );


            // ==========================================
            // COMPROBAR ERROR
            // ==========================================

            if (producto.error) {

                console.log(
                    producto.error
                );

                return;

            }


            // ==========================================
            // NOMBRE
            // ==========================================

            const nombre =
                document.getElementById(
                    "nombreProducto"
                );


            if (nombre) {

                nombre.textContent =
                    producto.nombre;

            }


            // ==========================================
            // PRECIO
            // ==========================================

            const precio =
                document.getElementById(
                    "precioProducto"
                );


            if (precio) {

                precio.textContent =
                    "Bs. " +
                    producto.precio;

            }


            // ==========================================
            // DESCRIPCIÓN
            // ==========================================

            const descripcion =
                document.getElementById(
                    "descripcionProducto"
                );


            if (descripcion) {

                descripcion.textContent =
                    producto.descripcion;

            }


            // ==========================================
            // MINIATURAS
            // ==========================================

            const miniaturas =
                document.getElementById(
                    "miniaturas"
                );


            if (!miniaturas) {

                console.log(
                    "No existe #miniaturas"
                );

                return;

            }


            miniaturas.innerHTML = "";


            // ==========================================
            // IMÁGENES
            // ==========================================

            if (
                producto.imagenes &&
                producto.imagenes.length > 0
            ) {


                // ==========================================
                // IMAGEN PRINCIPAL
                // ==========================================

                const imagenPrincipal =
                    document.getElementById(
                        "imagenPrincipal"
                    );


                if (imagenPrincipal) {

                    imagenPrincipal.src =
                        "../Productos/" +
                        producto.imagenes[0];

                }


                // ==========================================
                // CREAR MINIATURAS
                // ==========================================

                producto.imagenes.forEach(imagen => {

                    miniaturas.innerHTML += `

                        <img
                            src="../Productos/${imagen}"
                            onclick="cambiarImagen(this)"
                            alt="${producto.nombre}"
                        >

                    `;

                });

            }

        })


        .catch(error => {

            console.log(
                "Error al cargar producto:",
                error
            );

        });

}


// ==========================================
// CAMBIAR IMAGEN
// ==========================================

function cambiarImagen(imagen) {

    const imagenPrincipal =
        document.getElementById(
            "imagenPrincipal"
        );


    if (imagenPrincipal) {

        imagenPrincipal.src =
            imagen.src;

    }

}


// ==========================================
// CARGAR AL INICIAR
// ==========================================

document.addEventListener(
    "DOMContentLoaded",
    () => {

        cargarProducto();

    }
);