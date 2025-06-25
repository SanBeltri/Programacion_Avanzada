<?php
include 'conexion.php';

$id = $_GET['id'];
$resultado = $_GET['resultado'];

$query = "UPDATE operaciones SET resultado = $resultado WHERE id = $id";
obtenerResultado($query);

echo json_encode(["mensaje" => "Resultado actualizado"]);
?>
