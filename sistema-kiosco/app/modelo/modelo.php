<?php
class Modelo{
    private $db;
    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=kiosco;charset=utf8', 'root', '');
    }
    public function stock(){  //Obtiene stock de la db (productos).
        $query = $this->db ->prepare('SELECT * FROM productos');
        $query->execute();
        $productos=$query ->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }
    public function obtenerProducto($id){ //Obtiene un producto por id.
        $query = $this->db->prepare('SELECT * FROM productos WHERE id = ?');
        $query->execute([$id]);
        $producto=$query->fetch(PDO::FETCH_OBJ);
        return $producto;
    }
    public function productosSeleccionados(){ //Obtiene los productos seleccionados.
        $query = $this->db->prepare('SELECT * FROM productos WHERE seleccion = 1');
        $query->execute();
        $productos = $query->fetchAll(PDO:: FETCH_OBJ);
        return $productos;
    }
    public function productosSinSeleccionar(){ //Obtiene los productos sin seleccionar.
        $query = $this->db->prepare('SELECT * FROM productos WHERE seleccion = 0');
        $query->execute();
        $productos = $query->fetchAll(PDO:: FETCH_OBJ);
        return $productos;
    }
    public function seleccionarProducto($id){ //Selecciona un producto, setea un '1'.
        $query = $this->db->prepare('UPDATE productos SET seleccion = ? WHERE id = ?');
        $query->execute([1,$id]);
    }
    public function deseleccionarProducto($id){ //Deselecciona un producto, setea un '0'.
        $query = $this->db->prepare('UPDATE productos SET seleccion = ? WHERE id = ?');
        $query->execute([0,$id]);
    }
    //Botón 'Enviar Compra' en 'Realizar compra'.
    public function enviarCompra($cantProductos, $totalCosto, $totalVenta, $limpio, $fecha, $metPago){ //Crea una compra en la db.
        $query = $this->db->prepare("INSERT INTO historialcompras (cantProductos, nroCliente, metodoDePago, totalCosto, totalVenta, limpio, fecha) VALUES (?,?,?,?,?,?,?)");
        $query->execute([$cantProductos, 1, $metPago, $totalCosto, $totalVenta, $limpio, $fecha]);
    }
    //Botón 'Confirmar' en 'Realizar compra'.
    public function cantDeUnProducto($id, $cantidad){ //Setea la cantidad de un producto a llevarse en la db.
        $query = $this->db->prepare('UPDATE productos SET cantidadPorCompra = ? WHERE id = ?');
        $query->execute([$cantidad, $id]);
    }
    //Botón 'Enviar compra' en 'Realizar compra'.
    public function descontarProductoEnStock($id){//Modifica el stock, resta del stock de un producto,
        $producto = $this->obtenerProducto($id);//lo que se acaba de comprar.
        $nuevaCantidadStock = $producto->cantidadEnStock - $producto->cantidadPorCompra;
        $query = $this->db->prepare('UPDATE productos SET cantidadEnStock = ? WHERE id = ?');
        $query->execute([$nuevaCantidadStock, $id]);     
    } 
    //Botón 'EnviarCompra' en 'Realizar compra' (actualiza caja diaria en db)
    public function actualizarCajaDiaria($costo, $venta, $limpio, $cantProd){
    $caja = $this->ObtenerCajaDiaria();//Obtiene la caja del ÚLTIMO ID.
    $totalCosto = ($caja->totalCosto + $costo);
    $totalVenta = ($caja->totalVenta + $venta);
    $totalLimpio = ($caja->limpio + $limpio);
    $cantProductos = ($caja->cantProductos + $cantProd);//Actualiza nuevos valores dada una compra.
    $query = $this->db->prepare('UPDATE cajadiaria SET totalCosto = ?, totalVenta = ?, limpio = ?, cantProductos = ? ORDER BY id DESC LIMIT 1');
    $query->execute([$totalCosto, $totalVenta, $totalLimpio, $cantProductos]);
}    
    //Botón 'Eliminar compra' en 'Realizar compra'.
    public function resetearCantidadDeUnProducto($id){ //La cantidad del producto vuelve a 0.
        $query = $this->db->prepare('UPDATE productos SET cantidadPorCompra = ? WHERE id = ?');
        $query->execute([1,$id]);
    }
    //Botón 'Agregar Producto Nuevo' en caja diaria solo ADMIN.
    public function agregarProductoAlStock($nombre, $cantidad, $costo, $venta, $limpio){
        $query = $this->db->prepare("INSERT INTO productos (nombre, cantidadPorCompra, cantidadEnStock, costo, venta, limpio, seleccion) VALUES (?,?,?,?,?,?,?)");
        $query->execute([$nombre, 1, $cantidad, $costo, $venta, $limpio, 0]);
    }

    //Botón 'Actualizar' en caja diaria solo ADMIN.
    public function editarStockAdmin($nombre, $cantidad, $costo, $venta, $limpio, $id){
        $query = $this->db->prepare('UPDATE productos SET nombre = ?, cantidadPorCompra = ?, cantidadEnStock = ?, costo = ?, venta = ?, limpio = ?, seleccion = ? WHERE id = ?');
        $query->execute([$nombre, 1, $cantidad, $costo, $venta, $limpio, 0, $id]);

    }
    //Obtener caja diaria del ÚLTIMO ID de la db.
    public function ObtenerCajaDiaria(){
        $query = $this->db->prepare("SELECT * FROM cajadiaria ORDER BY id DESC LIMIT 1");
        $query->execute();
        $caja=$query->fetch(PDO::FETCH_OBJ);
        return $caja;
    }
    //Botón 'Ingresar' en logueo para crear cajaDiaria.
    public function abrirCaja($nombre, $fecha){
        $query = $this->db->prepare("INSERT INTO cajadiaria (inicioSesion, egresoSesion, empleado, totalCosto, totalVenta, limpio, cantProductos) VALUES (?,?,?,?,?,?,?)");
        $query->execute([$fecha, 1, $nombre, 0, 0, 0, 0]);
    } 
    //Botón 'deslogueo' cerrar caja.
    public function cerrarCaja($egreso){//Sete el egreso en la caja diaria.
        $query = $this->db->prepare('UPDATE cajadiaria SET egresoSesion = ? ORDER BY id DESC LIMIT 1');
        $query->execute([$egreso]);
    }       
    //Botón 'buscar' en caja diaria por nombre.
    public function buscadorPorNombre($nombre){ //Obtener un producto por nombre.
        $query = $this->db->prepare('SELECT * FROM productos WHERE nombre LIKE ? ORDER BY nombre ASC');
        $query->execute(["%$nombre%"]);
        $productos=$query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }
    //Botón 'buscar' en caja diaria por precio.
    public function buscadorPorPrecio($precio){ //Obtener un producto por nombre.
        $query = $this->db->prepare('SELECT * FROM productos WHERE venta LIKE ? ORDER BY venta ASC');
        $query->execute(["%$precio%"]);
        $productos=$query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }    
    //Botón 'Cajas del día' en home solo ADMIN.
    public function obtenerCajasDelDia($fecha){
        $query = $this->db->prepare('SELECT * FROM cajadiaria WHERE DATE(inicioSesion) = ?');
        $query->execute([$fecha]);
        $cajas=$query->fetchAll(PDO::FETCH_OBJ);
        return $cajas;
    }
    //Botón 'Registro de sesiones' en home solo ADMIN.
    public function obtenerSesionesDelDia($fecha){
        $query = $this->db->prepare('SELECT * FROM historialsesiones WHERE DATE(fecha) = ?');
        $query->execute([$fecha]);
        $sesiones=$query->fetchAll(PDO::FETCH_OBJ);
        return $sesiones;
    }
    //Botón 'Ventas del día' en home solo ADMIN.
    public function obtenerVentasDelDia($fecha){
        $query = $this->db->prepare('SELECT * FROM historialcompras WHERE DATE(fecha) = ?');
        $query->execute([$fecha]);
        $ventas=$query->fetchAll(PDO::FETCH_OBJ);
        return $ventas;
    }
    
}