<?php
include 'conexion.php';

$ID = $_GET['ID'];
$Resultado = $_GET['Resultado'];

$query = "UPDATE calculadora SET Resultado = $Resultado WHERE id = $ID";
obtenerResultado($query);

echo json_encode(["mensaje" => "Resultado actualizado"]);
?>
