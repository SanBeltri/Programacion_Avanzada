<?php
include 'conexion.php';

$id = $_GET['id'];

$query = "DELETE FROM operaciones WHERE id = $id";
obtenerResultado($query);

echo json_encode(["mensaje" => "Registro eliminado"]);
?>
