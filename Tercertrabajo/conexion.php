<?php
header("Content-type: text/html; charset=utf-8");

function obtenerResultado($query){
    $mysqli = new mysqli("localhost", "root", "", "calculadora");

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $resultado = $mysqli->query($query);

    if (!$resultado) {
        echo "Error en la consulta: " . $mysqli->error;
    }

    $mysqli->close();
    return $resultado;
}
?>
