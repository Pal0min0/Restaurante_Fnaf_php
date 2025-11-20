<?php

require_once "../configuracion/conexion.php";
require_once "../modelo/pedido.php";

Class Pedido_controlador{
    private $modelo_pedido;

    public function __construct(){
        $this -> modelo_pedido = new Pedido();
    }

    //Listar pedidos
    public function listar_pedidos() {
        return $this->modelo_pedido->listar_pedidos();;
    }

    //Listar pedidos del usuario
    public function listar_pedidos_usuario($id_usuario) {
        return $this->modelo_pedido->listar_pedidos_usuario($id_usuario);
    }

    // Crear Pedido
    public function crear_pedido() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $direccion = $_POST['direccion'];
            $id_usuario = $_POST['id_usuario'];

            $pedido = new Pedido();
            $pedido->crear_pedido($direccion, $id_usuario);

            session_start();
            $_SESSION['success_message'] = true;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        else{ 
            echo "No se pudo realizar el pedido";
        }
    }

    // Editar pedido
    public function editar_pedido(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_pedido = $_POST['id_pedido'];

            $pedido = new Pedido();
            $pedido->editar_pedido($id_pedido);

            session_start();
            $_SESSION['success_message'] = true;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();

            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";
            // exit();
        }
        else{ 
            echo "No se pudo editar ";
        }
    }

    // Eliminar un usuario
    public function eliminar_pedido(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_pedido = $_POST['id_pedido'];

            $pedido = new Pedido();
            $pedido->eliminar_pedido($id_pedido);

            session_start();
            $_SESSION['success_message'] = true;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();

            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";
            // exit();
        }
        else{ 
            echo "No se pudo eliminar el pedido";
        }
    }
}
?>