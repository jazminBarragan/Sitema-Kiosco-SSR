//Agarro todos los botones de actualizar producto.
let btn_actualizar = document.querySelectorAll("#btn-actualizar");

//Agarro todos los inputs del form.
let input_nombre = document.querySelector("#input-nombre");
let input_cantidad = document.querySelector("#input-cantidad");
let input_costo = document.querySelector("#input-costo");
let input_venta = document.querySelector("#input-venta");

//Agarro el form.
let formEditarProductoEnStock = document.querySelector("#formEditarProductoEnStock");

btn_actualizar.forEach(function (button) {
    button.addEventListener('click', function () {
        
        //Tomo la info del producto que tiene el boton.
        let idDelProducto = button.getAttribute('data-id');
        let nombreDelProducto = button.getAttribute('data-nombre');
        let cantidadDelProducto = button.getAttribute('data-cantidad');
        let costoDelProducto = button.getAttribute('data-costo');
        let ventaDelProducto = button.getAttribute('data-venta');

        // Seteo el valor a cada input.
        input_nombre.value = nombreDelProducto;
        input_cantidad.value = cantidadDelProducto;
        input_costo.value = costoDelProducto;
        input_venta.value = ventaDelProducto;

        // Seteo la URL del form para el submit.
        formEditarProductoEnStock.setAttribute('action', 'editarProductoStock/' + idDelProducto);

    });
});
