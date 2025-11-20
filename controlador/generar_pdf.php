<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../vista/Inicio_sesion.php");
    exit();
}

require_once "../controlador/pedido_controlador.php";
require_once "../vendor/autoload.php"; // O ../dompdf/autoload.inc.php

use Dompdf\Dompdf;

$pedido_controlador = new Pedido_controlador();
$lista_pedidos = $pedido_controlador->listar_pedidos();

$html = '
<h1 style="text-align:center;">Lista de Pedidos</h1>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Código</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Cliente</th>
            <th>Documento</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Dirección</th>
        </tr>
    </thead>
    <tbody>';
    
foreach ($lista_pedidos as $p) {
    $html .= '
        <tr>
            <td>'.$p['codigo'].'</td>
            <td>'.$p['fecha'].'</td>
            <td>'.$p['estado'].'</td>
            <td>'.$p['nombres'].'</td>
            <td>'.$p['documento'].'</td>
            <td>'.$p['Correo'].'</td>
            <td>'.$p['telefono'].'</td>
            <td>'.$p['direccion'].'</td>
        </tr>';
}

$html .= '
    </tbody>
</table>
';

// Crear el PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // horizontal
$dompdf->render();
$dompdf->stream("lista_pedidos.pdf", ["Attachment" => true]);
