<?php
require_once "../controlador/reservas_controlador.php";

$controlador = new Reservas_controlador();
$accion = $_GET['accion'] ?? '';

switch ($accion) {
    case 'listar':
        $resu = $controlador->listar_reservas();
        echo '<pre>';
        print_r($resu);
        echo '</pre>';
        break;
    case 'listar_reservas_usuario':
        $id_usuario = $_GET['id_usuario'] ?? 0;
        $resu = $controlador->listar_reservas_usuario($id_usuario);
        print_r($resu);
        break;
    case 'crear':
        $controlador->crear_reserva();
        break;
    case 'cancelar':
        $id_reserva = $_GET['id_reserva'] ?? 0;
        $resu = $controlador->eliminar_reserva($id_reserva);
        break;
    default:
        echo "Acción no válida.";
        break;
}
?>