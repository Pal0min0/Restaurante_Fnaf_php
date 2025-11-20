<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../configuracion/conexion.php";
require_once "../modelo/reservas.php";

Class Reservas_controlador{
    private $modelo_reserva;

    public function __construct(){
        $this -> modelo_reserva = new Reservas();
    }

    
    //Listar Reservas
    public function listar_reservas() {
        $this->modelo_reserva->eliminar_reserva_pasadas();
        return $this->modelo_reserva->listar_reservas();
    }

    //Listar Reservas del usuario
    public function listar_reservas_usuario($id_usuario) {
        $this->modelo_reserva->eliminar_reserva_pasadas();
        return $this->modelo_reserva->listar_reservas_usuario($id_usuario);
    }

   // Crear Reserva
    public function crear_reserva() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $Usuarioid_usuario = $_POST['id_usuario'];
            $Sucursalid_sucursal = $_POST['id_sucursal'];
            $mesas = isset($_POST['mesas']) ? $_POST['mesas'] : []; 

            $reserva = new Reservas();
            $reserva->crear_reserva($fecha, $hora, $Usuarioid_usuario, $Sucursalid_sucursal, $mesas);

            session_start();
            $_SESSION['success_message'] = true;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        else{ 
            echo "No se pudo realizar la reserva";
        }
    }

    //Eliminar(cancelar) Reservas
    public function eliminar_reserva($id_reserva) {
        $this->modelo_reserva->eliminar_reserva($id_reserva);

        session_start();
        $_SESSION['success_message'] = true;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>