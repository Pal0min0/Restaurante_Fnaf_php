<?php

require_once "../controlador/mesas_controlador.php";

$controlador = new Mesas_Controlador();
$accion = $_GET['accion'] ?? '';


switch ($accion) {
    case 'listar':
        $id_sucursal = $_GET['id_sucursal'] ?? 0; // o algún valor por defecto
        $mesas = $controlador->listar_mesas($id_sucursal);
        header('Content-Type: application/json');
        echo json_encode($mesas);
        break;  
        break;  
    default:
        echo "Acción no válida.";
        break;
}

?>