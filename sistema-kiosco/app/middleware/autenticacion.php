<?php
require_once './app/modelo/modeloHistorial.php';
    function usuarioLogueado($res) {  //Verificar si el usuario está logueado.
        session_start();
        if(isset($_SESSION['ID_USER'])){
            $res->usuario = new stdClass();
            $res->usuario->id = $_SESSION['ID_USER'];
            $res->usuario->usuario = $_SESSION['EMAIL_USER'];
            return;
        } else {
            header('Location: ' . BASE_URL . 'mostrarLogueo');
            die();
        }
    }
    function admin($res){ //Verificar si el usuario está logueado y si es el ADMIN.
        session_start();
        if(isset($_SESSION['ID_USER']) && isset($_SESSION['EMAIL_USER'])){ 
            if(($_SESSION['EMAIL_USER']) == 'admin'){
            $res->usuario = new stdClass();
            $res->usuario->id = $_SESSION['ID_USER'];
            $res->usuario->usuario = $_SESSION['EMAIL_USER'];
            return;
            }else{
                echo 'sin acceso';
                die();
            }
        } else {
            header('Location: ' . BASE_URL . 'showLogin');
            echo 'ingrese';
            die();
        }
    }
?>