<?php
    function validacionCaja($caja){
        if($caja){
            $totalVenta = $caja->totalVenta;
            } else {
                $totalVenta = 0;
            }
            return $totalVenta;    
    }
    function validacionProductos($cantProductos, $totalCosto, $totalVenta){
        return (isset($cantProductos) && !empty($cantProductos) && is_numeric($cantProductos) &&
            isset($totalCosto) && !empty($totalCosto) && is_numeric($totalCosto) &&
            isset($totalVenta) && !empty($totalVenta) && is_numeric($totalVenta));
                
    }
    

