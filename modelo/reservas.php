<?php
require_once "../configuracion/conexion.php";

class Reservas{
    private $db;

    public function __construct() {
       $this -> db = Database::connect();
    }

    // Listar todas las reservas
    public function listar_reservas() {
        $sql = "
            SELECT r.*, u.nombres, u.documento, u.telefono, u.Correo,
                s.nombre AS sucursal_nombre, s.direccion AS sucursal_direccion
            FROM reserva r
            INNER JOIN usuario u ON u.id_usuario = r.Usuarioid_usuario
            INNER JOIN sucursal s ON s.id_sucursal = r.Sucursalid_sucursal
            ORDER BY r.fecha, r.hora
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar reservas del usuario
    public function listar_reservas_usuario($id_usuario) {
        $sql = "SELECT * FROM reserva WHERE Usuarioid_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario'=>$id_usuario]);
        // Retorna todos los usuarios como un array asociativo
        $resu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resu;
    }

    // Método que genera un código aleatorio
    private function generarCodigoReserva($longitud = 8) {
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
            $codigo = $this->generarCodigoReserva();
            $sql = "SELECT COUNT(*) FROM reserva WHERE codigo_reserva = :codigo";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':codigo' => $codigo]);
            $count = $stmt->fetchColumn();
        } while ($count > 0);
        return $codigo;
    }

    // Crear Reserva
    public function crear_reserva($fecha, $hora, $Usuarioid_usuario, $Sucursalid_sucursal, $mesas = []){

        $this->db->beginTransaction();

        // Generar el código antes de insertarlo
        $codigo_reserva = $this->generarCodigoUnico();

        //Crear Reserva
        $sql = "INSERT INTO reserva (codigo_reserva, fecha, hora, Usuarioid_usuario, Sucursalid_sucursal) VALUES(:codigo_reserva, :fecha, :hora, :Usuarioid_usuario ,:Sucursalid_sucursal )";
        $consul = $this->db->prepare($sql);

        $consul->execute([':codigo_reserva'=>$codigo_reserva, ':fecha'=>$fecha, ':hora'=>$hora, ':Usuarioid_usuario'=>$Usuarioid_usuario, ':Sucursalid_sucursal'=>$Sucursalid_sucursal]);


        //Rervar mesas
        $id_reserva = $this->db->lastInsertId();

        foreach ($mesas as $numero_mesa) {
            // Verificar si la mesa existe
            $sql_check = "SELECT id_mesa FROM Mesa WHERE numero_mesa = :numero AND sucursal_id = :sucursal";
            $stmt_check = $this->db->prepare($sql_check);
            $stmt_check->execute([':numero' => $numero_mesa, ':sucursal' => $Sucursalid_sucursal]);
            $mesa = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($mesa) {
                $id_mesa = $mesa['id_mesa'];
                // Actualizar estado
                $sql_update = "UPDATE Mesa SET estado = 'ocupada' WHERE id_mesa = :id_mesa";
                $stmt_update = $this->db->prepare($sql_update);
                $stmt_update->execute([':id_mesa' => $id_mesa]);
            } else {
                // Crear la mesa (le damos capacidad por defecto 4)
                $sql_insert = "INSERT INTO Mesa (numero_mesa, capacidad, estado, sucursal_id) VALUES (:numero, 4, 'ocupada', :sucursal)";
                $stmt_insert = $this->db->prepare($sql_insert);
                $stmt_insert->execute([':numero' => $numero_mesa, ':sucursal' => $Sucursalid_sucursal]);
                $id_mesa = $this->db->lastInsertId();
            }

            // Insertar en reserva_mesa
            $sql_reserva_mesa = "INSERT INTO reserva_mesa (id_reserva, id_mesa) VALUES (:id_reserva, :id_mesa)";
            $stmt_reserva_mesa = $this->db->prepare($sql_reserva_mesa);
            $stmt_reserva_mesa->execute([':id_reserva' => $id_reserva, ':id_mesa' => $id_mesa]);
        }


        $this->db->commit();

        return true;
    }

    //Eliminar Reservas ya pasadas
    public function eliminar_reserva_pasadas() {

        // 1. obtener reservas que ya pasaron
        $sql = "SELECT id_reserva FROM Reserva WHERE fecha < CURDATE()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$reservas) return true;

        // preparar consultas
        $sql_mesas = "SELECT id_mesa FROM reserva_mesa WHERE id_reserva = :id_reserva";
        $stmt_mesas = $this->db->prepare($sql_mesas);

        $sql_del_mesa = "DELETE FROM Mesa WHERE id_mesa = :id_mesa";
        $stmt_del_mesa = $this->db->prepare($sql_del_mesa);

        $sql_del_rel = "DELETE FROM reserva_mesa WHERE id_reserva = :id_reserva";
        $stmt_del_rel = $this->db->prepare($sql_del_rel);

        foreach ($reservas as $r) {

            // 2. traer mesas asociadas a esa reserva
            $stmt_mesas->execute([':id_reserva' => $r['id_reserva']]);
            $mesas = $stmt_mesas->fetchAll(PDO::FETCH_ASSOC);

            // 3. eliminar las mesas físicamente
            foreach ($mesas as $m) {
                $stmt_del_mesa->execute([':id_mesa' => $m['id_mesa']]);
            }

            // 4. eliminar relación reserva-mesa
            $stmt_del_rel->execute([':id_reserva' => $r['id_reserva']]);
        }

        // 5. eliminar reservas pasadas
        $sql_del_res = "DELETE FROM Reserva WHERE fecha < CURDATE()";
        $stmt_del_res = $this->db->prepare($sql_del_res);
        return $stmt_del_res->execute();
    }

    //Eliminar(cancelar) Reservas
    public function eliminar_reserva($id_reserva) {

        // 1. Verificar si la reserva existe
        $sql = "SELECT id_reserva FROM Reserva WHERE id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_reserva' => $id_reserva]);
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reserva) {
            return false; // no existe
        }

        // =============== PREPARAR CONSULTAS ===============

        // traer mesas asociadas
        $sql_mesas = "SELECT id_mesa FROM reserva_mesa WHERE id_reserva = :id_reserva";
        $stmt_mesas = $this->db->prepare($sql_mesas);

        // eliminar mesa física
        $sql_del_mesa = "DELETE FROM Mesa WHERE id_mesa = :id_mesa";
        $stmt_del_mesa = $this->db->prepare($sql_del_mesa);

        // eliminar la relación
        $sql_del_rel = "DELETE FROM reserva_mesa WHERE id_reserva = :id_reserva";
        $stmt_del_rel = $this->db->prepare($sql_del_rel);

        // =============== EJECUCIÓN ===============

        // 2. obtener mesas de esa reserva
        $stmt_mesas->execute([':id_reserva' => $id_reserva]);
        $mesas = $stmt_mesas->fetchAll(PDO::FETCH_ASSOC);

        // 3. eliminar mesas físicas
        foreach ($mesas as $m) {
            $stmt_del_mesa->execute([':id_mesa' => $m['id_mesa']]);
        }

        // 4. eliminar relación reserva-mesa
        $stmt_del_rel->execute([':id_reserva' => $id_reserva]);

        // 5. eliminar la reserva
        $sql_del_res = "DELETE FROM Reserva WHERE id_reserva = :id_reserva";
        $stmt_del_res = $this->db->prepare($sql_del_res);

        return $stmt_del_res->execute([':id_reserva' => $id_reserva]);
    }
}
