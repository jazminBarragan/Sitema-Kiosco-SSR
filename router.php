<?php
require_once './app/controlador/controlador.php';
require_once './app/modelo/modelo.php';
require_once './app/vista/vista.php';
require_once './app/controlador/controladorUsuarios.php';
require_once './app/vista/vistaLogueo.php';
require_once './app/modelo/modeloUsuarios.php';
require_once './libs/response.php';
require_once './app/middleware/autenticacion.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'home'; // acción por defecto si no envían nada.
}
$res = new Response();

$params = explode('/', $action);

switch($params[0]){
    case 'home';
    usuarioLogueado($res);
    $controlador = new Controlador();
    $controlador->stock();
    break;

    case "mostrarLogueo";
    $controlador = new ControladorUsuario();
    $controlador->mostrarLogueo();
    break;

    case 'logueo';
    $controlador = new ControladorUsuario();
    $controlador->logueo();
    break;

    case 'deslogueo';
    $controlador = new ControladorUsuario();
    $controlador->deslogueo();
    break;

    case 'seleccionarProducto'; //Botón 'Agregar' en 'caja diaria'. Seleccionar producto en caja diaria para comprar.
    $controlador = new Controlador();
    $controlador->seleccionarProducto($params[1]);
    break;
    
    case 'deseleccionarProductoHome'; //Botón 'Eliminar' en 'caja diaria'. Deseleccionar producto en caja diaria para comprar.
    $controlador = new Controlador($params[1]);
    $controlador->deseleccionarProductoHome($params[1]);
    break;

    case 'realizarCompra'; //Traer productos en 'realizar compra'.
    $controlador = new Controlador();
    $controlador->productosSeleccionados();
    break;

    case 'cantDeUnProducto'; //Botón 'Enter' en 'Realizar compra'. Permite elegir la cantidad de un producto en 'realizar compra'.
    $controlador = new Controlador($params[1]);
    $controlador->cantDeUnProducto($params[1]);
    break;

    case 'deseleccionarProducto'; //Botón 'Eliminar' en 'realizar compra'. Deseleccionar producto seleccionado.
    $controlador = new Controlador($params[1]);
    $controlador->deseleccionarProducto($params[1]);
    break;

    case 'enviarCompra'; //Botón 'Enviar compra' en 'Realizar compra'.
    $controlador = new Controlador();
    $controlador->enviarCompra();
    break;

    case 'deshacerCompra'; //Botón 'Deshacer compra' en 'Realizar compra'.
    $controlador = new Controlador();
    $controlador->deshacerCompra();
    break;

    case 'agregarProductoAlStock';
    admin($res);
    $controlador = new Controlador();
    $controlador->agregarProductoAlStock();
    break;

    case 'editarProductoStock';
    admin($res);
    $controlador = new Controlador($params[1]);
    $controlador->editarStockAdmin($params[1]);
    break;

    case 'registros';
    admin($res);
    $controlador = new Controlador();
    break;

    case 'buscador';
    $controlador = new Controlador();
    $controlador->buscador();
    break;

    case 'cajaDiaria';
    admin($res);
    $controlador = new Controlador();
    $controlador->obtenerCajasDelDia();
    break;

    case 'sesiones';
    admin($res);
    $controlador = new Controlador();
    $controlador->obtenerSesionesDelDia();
    break;

    case 'ventasDelDia';
    $controlador = new Controlador();
    $controlador->obtenerVentasDelDia();
    break;

}
