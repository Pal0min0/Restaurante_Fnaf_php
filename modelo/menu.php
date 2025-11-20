<?php

require_once "../configuracion/conexion.php";

class Menu{
    private $db;

    public function __construct() {
       $this -> db = Database::connect();
    }

    // Listar todo el menu
    public function listar_menu() {
        $sql = "SELECT * FROM menu INNER JOIN tipo_menu ON menu.Tipo_Menuid_tipo_menu=tipo_menu.id_tipo_menu ORDER BY menu.id_menu ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        // Retorna todos los usuarios como un array asociativo
        $resu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resu;
    }

    // Añadir platos al menu
    public function crear_plato($nombre, $descripcion, $imagen, $precio, $tipo_menu) {
        $sql = "INSERT INTO menu (nombre, descripcion, imagen, precio, Tipo_Menuid_tipo_menu) VALUES (:nombre, :descripcion, :imagen, :precio, :tipo_menu)";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':nombre'=>$nombre, ':descripcion'=>$descripcion, ':imagen'=>$imagen, ':precio'=>$precio, ':tipo_menu'=>$tipo_menu]);

        return true;
    }

    // Obtener plato por id
    public function obtener_plato_id($id_menu) {
        $sql = "SELECT * FROM menu WHERE id_menu = :id_menu";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_menu'=>$id_menu]);
        // Retorna todos los usuarios como un array asociativo
        $resu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resu;
    }

    // Editar un plato
    public function editar_plato($id_menu, $nombre, $descripcion, $imagen, $precio, $tipo_menu){
        $sql = "UPDATE menu SET nombre = :nombre, descripcion = :descripcion, imagen = :imagen, precio = :precio, Tipo_Menuid_tipo_menu = :tipo_menu WHERE id_menu = :id_menu";
        $consul = $this->db->prepare($sql);
        $consul->execute([':nombre'=>$nombre, ':descripcion'=>$descripcion, ':imagen'=>$imagen, ':precio'=>$precio, ':tipo_menu'=>$tipo_menu, ':id_menu'=>$id_menu]);

        return true;
    }

    // Eliminar un plato
    public function eliminar_plato($id_menu){
        $sql = "DELETE FROM menu WHERE id_menu = :id_menu";
        $consul = $this->db->prepare($sql);
        $consul->execute([':id_menu'=>$id_menu]);

        return true;
    }
}

?>