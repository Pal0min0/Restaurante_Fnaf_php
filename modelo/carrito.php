<?php
require_once "../configuracion/conexion.php";

class Carrito_modelo {

    private $db;

    public function __construct() {
       $this -> db = Database::connect();
    }

    // Agregar al carrito
    public function agregar($id_usuario, $id_menu, $cantidad) {

        $sql = "SELECT cantidad FROM Carrito WHERE Usuarioid_usuario = ? AND Menuid_menu = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_usuario, $id_menu]);

        if ($stmt->rowCount() > 0) {
            $sql = "UPDATE Carrito 
                    SET cantidad = cantidad + ? 
                    WHERE Usuarioid_usuario = ? AND Menuid_menu = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$cantidad, $id_usuario, $id_menu]);
        } else {
            $sql = "INSERT INTO Carrito (Usuarioid_usuario, Menuid_menu, cantidad)
                    VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id_usuario, $id_menu, $cantidad]);
        }
    }

    //Obtener del carrito
    public function listar($id_usuario) {
        $sql = "SELECT c.Menuid_menu AS id_menu,
                       m.nombre,
                       m.imagen,
                       m.precio,
                       c.cantidad
                FROM Carrito c
                INNER JOIN Menu m ON c.Menuid_menu = m.id_menu
                WHERE c.Usuarioid_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar producto
    public function eliminar($id_usuario, $id_menu) {
        $sql = "DELETE FROM Carrito 
                WHERE Usuarioid_usuario = ? AND Menuid_menu = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_usuario, $id_menu]);
    }

    // Vaciar Carrito
    public function vaciar($id_usuario) {
        $sql = "DELETE FROM Carrito WHERE Usuarioid_usuario = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_usuario]);
    }
}
