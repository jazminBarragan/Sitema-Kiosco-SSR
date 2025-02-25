<?php
class ModeloUsuarios{
    private $db;
    private $vista;

    public function  __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=kiosco;charset=utf8', 'root', '');
    }
    public function obtenerUsuario($usuario){ //Obtiene un usuario de la DB.
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $query->execute([$usuario]);
    
        $usuario = $query->fetch(PDO::FETCH_OBJ);
    
        return $usuario;
   }
    }
    
