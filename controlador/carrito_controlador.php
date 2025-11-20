<?php
session_start();
require_once "../modelo/carrito.php";

$carrito = new Carrito_modelo();

$id_usuario = $_SESSION["usuario"]["id_usuario"] ?? null;

if (!$id_usuario) {
    echo json_encode(["status" => "error", "msg" => "Debes iniciar sesión"]);
    exit;
}

// AGREGAR AL CARRITO
if ($_POST["accion"] == "agregar") {

    $id_menu = $_POST["id"];
    $cantidad = (int)$_POST["cantidad"];

    $carrito->agregar($id_usuario, $id_menu, $cantidad);

    echo json_encode(["status" => "ok", "msg" => "Producto añadido"]);
    exit;
}

// ELIMINAR
if ($_POST["accion"] == "eliminar") {

    $id_menu = $_POST["id"];
    $carrito->eliminar($id_usuario, $id_menu);

    echo json_encode(["status" => "ok"]);
    exit;
}

// VACIAR
if ($_POST["accion"] == "vaciar") {

    $carrito->vaciar($id_usuario);

    echo json_encode(["status" => "ok"]);
    exit;
}
