<?php
require_once "../configuracion/conexion.php";

class Mesas{
    private $db;

    public function __construct() {
       $this -> db = Database::connect();
    }

    // Listar mesas de las sucursales
    public function listar_mesas($id_sucursal) {
        $sql = "SELECT mesa.id_mesa, mesa.numero_mesa, mesa.estado, sucursal.nombre, sucursal.id_sucursal
                FROM sucursal
                INNER JOIN mesa ON mesa.sucursal_id = sucursal.id_sucursal
                WHERE sucursal.id_sucursal = :id_sucursal";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_sucursal' => $id_sucursal]);
        $resu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resu;
    }
}
