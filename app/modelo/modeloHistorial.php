<?php
class ModeloHistorial{
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=kiosco;charset=utf8', 'root', '');
    }
    public function insertarSesion($usuario, $fecha, $estado){ //Setea sesiones en el historial.
        $sql = $this->db->prepare("INSERT INTO historialsesiones (nombre,fecha, estado) VALUES (?,?,?)");
        $sql->execute([$usuario, $fecha, $estado]);
        return;
    }
}