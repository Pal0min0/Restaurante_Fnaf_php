<?php

require_once "../controlador/sucursal_controlador.php";

$controlador = new Sucursal_controlador();
$accion = $_GET['accion'] ?? '';


switch ($accion) {
    case 'listar':
        $controlador->listar_sucursales();
        break;
    case 'sucursal_id':
        $id_sucursal = $_GET['id_sucursal'] ?? null;
        if ($id_sucursal) {
            $resultado = $controlador->obtener_sucursal_id($id_sucursal);
            print_r($resultado); // imprimir los resultados
        } else {
            echo "Falta el parámetro id_sucursal";
        }
        break;
    case 'crear':
        $controlador->crear_sucursal();
        break;
    case 'editar':
        $controlador->editar_sucursal();
        break;
    case 'eliminar':
        $controlador->eliminar_sucursal();
        break;
    default:
        echo "Acción no válida.";
        break;
}

?>