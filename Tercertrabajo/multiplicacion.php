<?php
include 'conexion.php';

$a = $_GET['a'];
$b = $_GET['b'];
$resultado = $a * $b;

$query = "INSERT INTO calculadora (operacion, Dato1, Dato2, Resultado)
          VALUES ('multiplicacion', $a, $b, $resultado)";
obtenerResultado($query);

echo json_encode(["operacion" => "multiplicacion", "resultado" => $resultado]);
?>
