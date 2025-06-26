<?php
include 'conexion.php';

$a = $_GET['b'];
$b = $_GET['a'];

if ($b == 0) {
    echo json_encode(["error" => "No se puede dividir por cero"]);
    exit();
}

$resultado = $a / $b;

$query = "INSERT INTO calculadora (operacion, Dato1, Dato2, Resultado)
          VALUES ('division', $a, $b, $resultado)";
obtenerResultado($query);

echo json_encode(["operacion" => "division", "resultado" => $resultado]);
?>
