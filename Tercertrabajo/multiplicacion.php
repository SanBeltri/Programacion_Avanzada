<?php
include 'conexion.php';

$n1 = $_GET['n1'];
$n2 = $_GET['n2'];
$resultado = $n1 * $n2;

$query = "INSERT INTO operaciones (operacion, valor1, valor2, resultado)
          VALUES ('multiplicacion', $n1, $n2, $resultado)";
obtenerResultado($query);

echo json_encode(["operacion" => "multiplicacion", "resultado" => $resultado]);
?>
