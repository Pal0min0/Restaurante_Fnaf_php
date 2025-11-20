<?php
require_once "../controlador/pedido_controlador.php";

$controlador = new Pedido_controlador();
$accion = $_GET['accion'] ?? '';

switch ($accion) {
    case 'listar':
        $resu = $controlador->listar_pedidos();
        echo '<pre>';
        print_r($resu);
        echo '</pre>';
        break;
    case 'listar_pedidos_usuario':
        $id_usuario = $_GET['id_usuario'] ?? 0;
        $resu = $controlador->listar_pedidos_usuario($id_usuario);
        echo '<pre>';
        print_r($resu);
        echo '</pre>';
        break;
    case 'crear':
        $controlador->crear_pedido();
        header("Location: ../vista/historial.php");
        exit();
        break;
    case 'editar_esta_entregado':
        $controlador->editar_pedido();
        break;
    case 'eliminar':
        $controlador->eliminar_pedido();
        break;
    default:
        echo "Acción no válida.";
        break;
}
?>