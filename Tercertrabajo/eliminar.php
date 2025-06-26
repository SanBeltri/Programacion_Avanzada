<?php
include 'conexion.php';

$ID = $_GET['ID'];

$query = "DELETE FROM calculadora WHERE ID = $ID";
obtenerResultado($query);

echo json_encode(["mensaje" => "Registro eliminado"]);
?>
