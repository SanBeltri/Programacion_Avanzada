<?php
include 'conexion.php';

$n1 = $_GET['n1'];
$n2 = $_GET['n2'];

if ($n2 == 0) {
    echo json_encode(["error" => "No se puede dividir por cero"]);
    exit();
}

$resultado = $n1 / $n2;

$query = "INSERT INTO operaciones (operacion, valor1, valor2, resultado)
          VALUES ('division', $n1, $n2, $resultado)";
obtenerResultado($query);

echo json_encode(["operacion" => "division", "resultado" => $resultado]);
?>
