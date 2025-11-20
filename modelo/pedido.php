<?php

require_once "../configuracion/conexion.php";

class Pedido{
    private $db;

    public function __construct() {
       $this -> db = Database::connect();
    }

    // Listar todas las reservas
    public function listar_pedidos() {
        $sql = "SELECT * FROM pedido INNER JOIN usuario on usuario.id_usuario=pedido.Usuarioid_usuario ORDER BY pedido.fecha DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar pedidos del usuario
    public function listar_pedidos_usuario($id_usuario) {
        $sql = "SELECT * FROM pedido INNER JOIN usuario on usuario.id_usuario=pedido.Usuarioid_usuario WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario'=>$id_usuario]);
        // Retorna todos los usuarios como un array asociativo
        $resu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resu;
    }

    // Método que genera un código aleatorio
    private function generarCodigoPedido($longitud = 8) {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $codigo = '';
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }
        return $codigo;
    }

    //Crear codigo de reserva unico 
    private function generarCodigoUnico() {
        do {
            $codigo = $this->generarCodigoPedido();
            $sql = "SELECT COUNT(*) FROM pedido WHERE codigo = :codigo";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':codigo' => $codigo]);
            $count = $stmt->fetchColumn();
        } while ($count > 0);
        return $codigo;
    }

    // Crear o registrar un pedido
    public function crear_pedido($direccion, $id_usuario) {
        $codigo = $this->generarCodigoUnico(); // generar código único

        $fecha = date("Y-m-d H:i:s"); // fecha actual
        $estado = "En proceso";

        $sql = "INSERT INTO pedido (codigo, fecha, direccion, estado, Usuarioid_usuario)
                VALUES (:codigo, :fecha, :direccion, :estado, :id_usuario)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':codigo' => $codigo,
            ':fecha' => $fecha,
            ':direccion' => $direccion,
            ':estado' => $estado,
            ':id_usuario' => $id_usuario
        ]);
    }

    // Cambiar estado del pedido
    public function editar_pedido($id_pedido){

        $estado = "Entregado";

        $sql = "UPDATE pedido SET estado = :estado  WHERE id_pedido = :id_pedido";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar un pedido
    public function eliminar_pedido($id_pedido){
        $sql = "DELETE FROM pedido WHERE id_pedido = :id_pedido";
        $consul = $this->db->prepare($sql);
        $consul->execute([':id_pedido'=>$id_pedido]);

        return true;
    }
}

?>