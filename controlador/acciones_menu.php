<?php

require_once "../controlador/menu_controlador.php";

$controlador = new Menu_controlador();
$accion = $_GET['accion'] ?? '';


switch ($accion) {
    case 'listar':
        $controlador->listar_menu();
        break;
    case 'menu_id':
        $id_menu = $_GET['id_menu'] ?? null;
        if ($id_menu) {
            $resultado = $controlador->obtener_plato_id($id_menu);
            // print_r($resultado); // imprimir los resultados
        } else {
            echo "Falta el parámetro id_usuario.";
        }
        break;
    case 'crear':
        $controlador->crear_plato();
        break;
    case 'editar':
        $controlador->editar_plato();
        break;
    case 'eliminar':
        $controlador->eliminar_plato();
        break;
    default:
        echo "Acción no válida.";
        break;
}

?>