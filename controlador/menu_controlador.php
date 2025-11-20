<?php

require_once "../configuracion/conexion.php";
require_once "../modelo/menu.php";

class Menu_controlador{
    private $modelo_menu;

    public function __construct(){
        $this -> modelo_menu = new Menu();
    }

    // Obtener o listar todos los usuarios
    public function listar_menu(){
        // $menu = new Menu();
        // return $menu->listar_menu();
        $resultado = $this->modelo_menu->listar_menu();
        return $resultado;
    }

    // Obtener un usuario por su id
    public function obtener_plato_id($id_menu){
        $menu = new Menu();
        return $menu->obtener_plato_id($id_menu);
    }

    // Crear o añadir plato al menu
    public function crear_plato(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $tipo_menu = $_POST['tipo_menu'];

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
                $menu = new Menu();
                $menu->crear_plato($nombre, $descripcion, $nombreImagen, $precio, $tipo_menu);

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
    public function editar_plato(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_menu = $_POST['id_menu'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $tipo_menu = $_POST['tipo_menu'];

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
                $menu = new Menu();
                $menu->editar_plato($id_menu, $nombre, $descripcion, $nombreImagen, $precio, $tipo_menu);

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

    // Eliminar un plato
    public function eliminar_plato(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_menu = $_POST['id_menu'];

            $menu = new Menu();
            
            // Obtener los datos del plato (para saber el nombre de la imagen)
            $plato = $menu->obtener_plato_id($id_menu);

            if ($plato && !empty($plato['imagen'])) {
                $rutaImagen = "../uploads/" . $plato['imagen'];

                // Si el archivo existe, eliminarlo del servidor
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            // Eliminar el plato de la base de datos
            $menu->eliminar_plato($id_menu);

            // Mensaje de éxito y redirección
            session_start();
            $_SESSION['success_message'] = true;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        else{ 
            echo "No se pudo eliminar el plato";
        }
    }
}

?>