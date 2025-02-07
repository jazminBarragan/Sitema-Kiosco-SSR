<?php
require_once './app/middleware/validaciones.php';
class Controlador{
    protected $modelo;
    protected $vista;

    public function __construct(){
        $this->modelo=new Modelo();
        $this->vista=new Vista();
    }
    //Traer productos en 'caja diaria'.
    public function stock(){ //Trae todos los productos en stock.
        $productos = $this->modelo->stock();
        if(!$productos){
            $this->vista->mostrarError('Sin stock');
        }
        $caja = $this->modelo->ObtenerCajaDiaria();
        $totalVenta = validacionCaja($caja);
        $this->vista->mostrarStock($productos, $totalVenta);
    }
    //Botón 'Agregar' en 'caja diaria'.
    public function seleccionarProducto($id){ //Setear un '1' en la seleccion de un producto.
        $this->modelo->seleccionarProducto($id);
        $productos = $this->modelo->stock(); //Volver a mostrar todo el stock en caja diaria.
        if(!$productos){
            $this->vista->mostrarError('sin stock');
        }
        $caja = $this->modelo->ObtenerCajaDiaria();
        $totalVenta = validacionCaja($caja);
        $this->vista->mostrarStock($productos, $totalVenta);
    }
    //Botón 'Eliminar' en 'caja diaria'.
    public function deseleccionarProductoHome($id){ //Setear un '0' en la seleccion de un producto.
        $this->modelo->deseleccionarProducto($id); //Volver a mostrar todo el stock en caja diaria.
        header('Location:'. BASE_URL . 'home');
    }    
    //Btoón 'Realizar compra', traer productos en 'realizar compra'.
    public function productosSeleccionados(){ //Muestra todos los productos seleccionados.
        $productos = $this->modelo->productosSeleccionados();
        if(!$productos){
            $this->vista->mostrarError('No hay productos seleccionados.');
        }
        $this->vista->realizarCompra($productos);
    }
    //Botón 'Confirmar' en 'Realizar compra'.
    public function cantDeUnProducto($id){ //SETEA la cantidad a llevarse de un producto que llega por form.
        if(is_numeric($_POST['cantDeUnProducto'])){
            $cantidad = $_POST['cantDeUnProducto']; 
            $this->modelo->cantDeUnProducto($id, $cantidad); 
            $productos = $this->modelo->productosSeleccionados();//vuelve a traer todos los productos.
            if(!$productos){
                $this->vista->mostrarError('No hay productos seleccionados.');
            }
            $this->vista->realizarCompra($productos);    
        } else {
            $this->vista->mostrarError('Ingrese un NÚMERO VÁLIDO.');
        }
    }    
    //Botón 'Eliminar' en 'realizar compra'.
    public function deseleccionarProducto($id){//Eliminar UN producto en 'realizar compra'.
        $this->modelo->deseleccionarProducto($id);////Deselecciona un producto (== 0).
        $this->modelo->resetearCantidadDeUnProducto($id);//reseta la cantidad de ese producto (== 1).

        header('Location:'. BASE_URL . 'realizarCompra');
    }
    //Botón 'Enviar compra' en 'realizar compra'.
    public function enviarCompra(){ //Guarda en el registro de compras los DATOS.
        if(validacionProductos($_POST['cantProductos'],  $_POST['totalCosto'], $_POST['totalVenta'])){
            $cantProductos = $_POST['cantProductos'];
            $totalCosto = $_POST['totalCosto'];
            $totalVenta = $_POST['totalVenta'];
            $limpio = $_POST['limpio'];    
            $fecha = $_POST['fecha'];
            $metPago = $_POST['metPago'];
            $this->modelo->enviarCompra($cantProductos, $totalCosto, $totalVenta, $limpio, $fecha, $metPago);    
        } else {
            $this->vista->mostrarError('No puede enviar una compra sin datos.');
        }

        //Actualizar la caja diaria en la db en cada compra.
        $this->modelo->actualizarCajaDiaria($totalCosto, $totalVenta, $limpio, $cantProductos);
        $productos = $this->modelo->productosSeleccionados();//Por cada producto seleccionado, modifica el STOCK.
        if(!$productos){
            $this->vista->mostrarError('No hay productos seleccionados.');
        }
        foreach($productos as $producto){
            $this->modelo->descontarProductoEnStock($producto->id);
        }
        $this->deshacerCompra();
    }
    //Botón 'Eliminar compra' en 'realizar compra'.
    public function deshacerCompra(){
        $productos = $this->modelo->productosSeleccionados();//Por cada producto seleccionado,
        if(!$productos){
            $this->vista->mostrarError('No hay productos seleccionados.');
        }
        foreach($productos as $producto){
            $this->modelo->resetearCantidadDeUnProducto($producto->id);//resetear la cantidad (== 1)
            $this->modelo->deseleccionarProducto($producto->id);//deseleccionarlo de a uno (== 0).   
        }
        $productos = $this->modelo->stock(); //Devolver todos los productos.
        if(!$productos){
            $this->vista->mostrarError('Sin stock.');
        }
        header('Location:'. BASE_URL . 'home');

    }
    //Botón 'Agregar Producto Nuevo' en caja diaria solo ADMIN.
    public function agregarProductoAlStock(){
        if(validacionProductos($_POST['cantidad'], $_POST['costo'], $_POST['venta'])){
            $nombre = $_POST['nombre'];
            $cantidad = $_POST['cantidad'];
            $costo = $_POST['costo'];
            $venta = $_POST['venta'];    
            $limpio = ($venta - $costo);
            $this->modelo->agregarProductoAlStock($nombre, $cantidad, $costo, $venta, $limpio);    
        }else{
            $this->vista->mostrarError('Ingrese valores correctos.');
        }
        header('Location:'. BASE_URL . 'home');
    }
    //Botón 'Actualizar' en caja diaria solo ADMIN.
    public function editarStockAdmin($id){
        if(validacionProductos($_POST['cantidad'], $_POST['costo'], $_POST['venta'])){
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $costo = $_POST['costo'];
        $venta = $_POST['venta'];
        $limpio = ($venta - $costo);
        $this->modelo->editarStockAdmin($nombre, $cantidad, $costo, $venta, $limpio, $id);
        }else{
            $this->vista->mostrarError('Ingrese valores correctos.');
        }
        header('Location:'. BASE_URL . 'home');
    }
    //Botón 'buscar' en caja diaria.
    public function buscador(){
        if(is_numeric($_POST['infoDelProducto'])){
            $precio = $_POST['infoDelProducto'];
            $productos = $this->modelo->buscadorPorPrecio($precio); //Busca el producto con ese nombre en la db. 
        } else {
            $nombre = $_POST['infoDelProducto'];
            $productos = $this->modelo->buscadorPorNombre($nombre); //Busca el producto con ese nombre en la db. 
        }
        $caja = $this->modelo->ObtenerCajaDiaria();//Obtiene la caja con el ÚLTIMO ID.
        $totalVenta = validacionCaja($caja);//Actualiza el total de venta en el home.
        if(!$productos){
            $this->vista->mostrarStock($productos, $totalVenta);
            $this->vista->mostrarError('No se encontraron resultados.');
        }
        $this->vista->mostrarStock($productos, $totalVenta);

    }
    //Botón 'Cajas del día' en home solo ADMIN.
    public function obtenerCajasDelDia(){
        $fecha = date("Y-d-m"); 
        $cajas = $this->modelo->obtenerCajasDelDia($fecha);
        if(!$cajas){
            $this->vista->mostrarError('No hay cajas del día de hoy.');
        }else{
            $this->vista->mostrarCajasDelDia($cajas);
        }
    }
    //Botón 'Registro de sesiones' en home solo ADMIN.
    public function obtenerSesionesDelDia(){
        $fecha = date("Y-d-m"); 
        $sesiones = $this->modelo->obtenerSesionesDelDia($fecha);
        if(!$sesiones){
            $this->vista->mostrarError('No hay sesiones del día de hoy.');
        }else{
            $this->vista->mostrarSesionesDelDia($sesiones);
        }
    }
        //Botón 'Ventas del día' en home solo ADMIN.
        public function obtenerVentasDelDia(){
            $fecha = date("Y-d-m"); 
            $ventas = $this->modelo->obtenerVentasDelDia($fecha);
            if(!$ventas){
                $this->vista->mostrarError('No hay ventas del día de hoy.');
            }else{
                $this->vista->mostrarVentasDelDia($ventas);
            }
        }
    
}