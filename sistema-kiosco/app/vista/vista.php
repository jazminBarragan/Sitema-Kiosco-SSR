<?php
class Vista{
    public function mostrarError($error){
        require_once './templates/header.phtml';
        require_once './templates/mostrarError.phtml';
    }
    public function mostrarStock($stock, $totalVenta){
        require_once './templates/cajaDiaria.phtml';
    }
    public function realizarCompra($productos){
        require_once './templates/realizarCompra.phtml';
    }
    public function mostrarCajasDelDia($cajas){
        require_once './templates/cajasDelDia.phtml';
    }
    public function mostrarSesionesDelDia($sesiones){
        require_once './templates/sesionesDelDia.phtml';
    }
    public function mostrarVentasDelDia($ventas){
        require_once './templates/ventasDelDia.phtml';
    }
    

    
}