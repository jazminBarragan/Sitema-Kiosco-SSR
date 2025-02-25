<?php
class ControladorUsuario{
    private $modelo;
    private $modeloDbSistema;
    private $modeloHistorial;
    private $vista;
    
    public function __construct(){
        $this->modelo = new ModeloUsuarios();
        $this->modeloDbSistema = new Modelo();
        $this->modeloHistorial = new ModeloHistorial();
        $this->vista = new VistaLogueo();
    }
    public function mostrarLogueo() { // Muestro el formulario de login
        return $this->vista->mostrarLogueo();
    }
    public function logueo() { //Loguearse.
        //Llegan por POST los datos del formulario.
        if (!isset($_POST['usuario']) || empty($_POST['usuario'])) {
            return $this->vista->mostrarLogueo('Falta completar el nombre de usuario.');
        }
    
        if (!isset($_POST['contraseña']) || empty($_POST['contraseña'])) {
            return $this->vista->mostrarLogueo('Falta completar la contraseña.');
        }
    
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
    
        // Verificar que el usuario está en la base de datos
        $userFromDB = $this->modelo->obtenerUsuario($usuario);

        if($userFromDB && password_verify($contraseña, $userFromDB->contraseña)){
            // Guardo en la sesión el ID del usuario
            session_start();
            $_SESSION['ID_USER'] = $userFromDB->id;
            $_SESSION['EMAIL_USER'] = $userFromDB->usuario;
            $_SESSION['LAST_ACTIVITY'] = time();
            date_default_timezone_set("America/Argentina/Jujuy");
            $fecha = date('Y-m-d H:i:s');
            $nombre=$_SESSION['EMAIL_USER'];
            //Alamacenar la sesion en el historial DB.
            $this->modeloHistorial->insertarSesion($nombre, $fecha, $estado='ingreso');    

            //Abrir caja, crear Caja Diaria en la db.
            $this->modeloDbSistema->abrirCaja($nombre, $fecha);

            // Redirijo al home
            header('Location: ' . BASE_URL);
        } else {
            return $this->vista->mostrarLogueo('Credenciales incorrectas...');
        }
    }
    public function checkeoSesion(){
        if(!empty($_SESSION['ID_USER'] == null)){ //Checkea si el usuario está logueado.
            return false;
        }
        return true;
    }
    public function deslogueo() { //Desloguearse.
        session_start(); // Va a buscar la cookie
        $usuario = $_SESSION['EMAIL_USER'];
        session_destroy(); // Borra la cookie que se buscó
        date_default_timezone_set("America/Argentina/Jujuy");
        $fecha = date('Y-m-d H:i:s');

        //Almacenar la sesion en el historial DB.
        $this->modeloHistorial->insertarSesion($usuario, $fecha, $estado = 'egreso');
        
        //Cerrar caja (setear egreso) en la caja diaria de la db.
        $this->modeloDbSistema->cerrarCaja($fecha);

        header('Location: ' . BASE_URL. 'mostrarLogueo'); //Redirije al home.
    }
}