<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../configuracion/conexion.php";
require_once "../modelo/sucursal.php";

class Sucursal_controlador{
    private $modelo_sucursal;

    public function __construct(){
        $this -> modelo_sucursal = new Sucursal();
    }

    // Obtener o listar todas las sucursales
    public function listar_sucursales(){
        $resultado = $this->modelo_sucursal->listar_sucursales();
        return $resultado;
    }

    // Obtener un usuario por su id
    public function obtener_sucursal_id($id_sucursal){
        $sucursal = new Sucursal();
        return $sucursal->obtener_sucursal_id($id_sucursal);
    }

    // Crear o añadir plato al menu
    public function crear_sucursal(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];

            // Crear carpeta uploads si no existe
            $carpeta = "../uploads/";
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            
            // Guardar imagen
            $nombreImagen = time() . "_" . basename($_FILES['imagen']['name']);
            $rutaImagen = $carpeta . $nombreImagen;

            // Validaciones
            $tamanoMaximo = 2 * 1024 * 1024; // 2 MB
            if ($_FILES['imagen']['size'] > $tamanoMaximo) {
                die("La imagen supera el tamaño máximo permitido (2 MB)");
            }

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                // Guardar solo el nombre o la ruta en la BD
                $sucursal = new Sucursal();
                $sucursal->crear_sucursal($nombre, $direccion, $nombreImagen, $total_mesas, $mesas_disponibles);

                session_start();
                $_SESSION['success_message'] = true;
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
            else{
                echo "Error al subir la imagen";
            }
        }
        else{
            echo "No se pudo crear el plato";
        }
    }

    // Editar plato
    public function editar_sucursal(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_sucursal = $_POST['id_sucursal'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];

            // Crear carpeta uploads si no existe
            $carpeta = "../uploads/";
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            
            // Guardar imagen
            $nombreImagen = time() . "_" . basename($_FILES['imagen']['name']);
            $rutaImagen = $carpeta . $nombreImagen;

            // Validaciones
            $tamanoMaximo = 2 * 1024 * 1024; // 2 MB
            if ($_FILES['imagen']['size'] > $tamanoMaximo) {
                die("La imagen supera el tamaño máximo permitido (2 MB)");
            }

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                // Guardar solo el nombre o la ruta en la BD
                $sucursal = new Sucursal();
                $sucursal->editar_sucursal($id_sucursal, $nombre, $direccion, $nombreImagen, $total_mesas, $mesas_disponibles);

                session_start();
                $_SESSION['success_message'] = true;
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
            else{
                echo "Error al subir la imagen";
            }
        }
        else{ 
            echo "No se pudo editar ";
        }
    }

    // Eliminar una sucursal
    public function eliminar_sucursal(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_sucursal = $_POST['id_sucursal'];

            $sucursal = new Sucursal();
            
            // Obtener los datos del plato (para saber el nombre de la imagen)
            $sucu = $sucursal->obtener_sucursal_id($id_sucursal);

            if ($sucu && !empty($sucu['imagen'])) {
                $rutaImagen = "../uploads/" . $sucu['imagen'];

                // Si el archivo existe, eliminarlo del servidor
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            // Eliminar el plato de la base de datos
            $sucursal->eliminar_sucursal($id_sucursal);

            // Mensaje de éxito y redirección
            session_start();
            $_SESSION['success_message'] = true;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        else{ 
            echo "No se pudo eliminar la sucursal";
        }
    }
}