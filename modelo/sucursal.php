<?php
require_once "../configuracion/conexion.php";

class Sucursal{
    private $db;

    public function __construct() {
       $this -> db = Database::connect();
    }

    // Listar todos las sucursales
    public function listar_sucursales() {
        $sql = "SELECT * FROM sucursal";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        // Retorna todos los usuarios como un array asociativo
        $resu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resu;
    }

    // Obtener plato por id
    public function obtener_sucursal_id($id_sucursal) {
        $sql = "SELECT * FROM sucursal WHERE id_sucursal = :id_sucursal";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_sucursal'=>$id_sucursal]);
        // Retorna todos los usuarios como un array asociativo
        $resu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resu;
    }

    // Crear sucursales
    public function crear_sucursal($nombre, $direccion, $imagen) {
        $sql = "INSERT INTO sucursal (nombre, direccion, imagen) VALUES (:nombre, :direccion, :imagen)";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':nombre'=>$nombre, ':direccion'=>$direccion, ':imagen'=>$imagen]);

        return true;
    }

    // Editar una sucursal
    public function editar_sucursal($id_sucursal, $nombre, $direccion, $imagen){
        $sql = "UPDATE sucursal SET nombre = :nombre, direccion = :direccion, imagen = :imagen WHERE id_sucursal = :id_sucursal";
        $consul = $this->db->prepare($sql);
        $consul->execute([':nombre'=>$nombre, ':direccion'=>$direccion, ':imagen'=>$imagen, ':id_sucursal'=>$id_sucursal]);

        return true;
    }

    // Eliminar una sucursal
    public function eliminar_sucursal($id_sucursal){
        $sql = "DELETE FROM sucursal WHERE id_sucursal = :id_sucursal";
        $consul = $this->db->prepare($sql);
        $consul->execute([':id_sucursal'=>$id_sucursal]);

        return true;
    }

}
