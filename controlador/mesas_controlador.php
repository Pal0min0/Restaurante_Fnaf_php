<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../configuracion/conexion.php";
require_once "../modelo/mesas.php";

class Mesas_Controlador{
    private $modelo_mesas;

    public function __construct(){
        $this -> modelo_mesas = new Mesas();
    }

    // Obtener mesas de una sucursal
    public function listar_mesas($id_sucursal){
        $resultado = $this->modelo_mesas->listar_mesas($id_sucursal); // ✔ Pasamos el parámetro
        return $resultado;
    }
}