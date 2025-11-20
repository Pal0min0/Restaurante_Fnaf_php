<?php
require_once "../controlador/usuario_controlador.php";

$controlador = new Usuario_controlador();
$accion = $_GET['accion'] ?? '';

switch ($accion) {
    case 'login':
        $controlador->validar_usuario();
        break;
    case 'cerrar':
        $controlador->cerrar_sesion();
        break;
    case 'registrar':
        $controlador->registrar_usuario();
        break;
    case 'listar':
        $controlador->obtener_usuarios();
        break;
    case 'usuario_id':
        $id_usuario = $_GET['id_usuario'] ?? null;
        if ($id_usuario) {
            $resultado = $controlador->obtener_usuario_id($id_usuario);
            // print_r($resultado); // imprimir los resultados
        } else {
            echo "Falta el parámetro id_usuario.";
        }
        break;
    case 'editar':
        $controlador->editar_usuario();
        break;
    case 'eliminar':
        $controlador->eliminar_usuario();
        break;
    default:
        echo "Acción no válida.";
        break;
}
?>