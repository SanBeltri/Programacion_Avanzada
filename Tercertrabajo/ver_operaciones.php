<?php
$conexion = new mysqli("localhost", "root", "", "calculadora");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM operaciones";
$resultado = $conexion->query($sql);

echo "<h2>Registros en la tabla 'operaciones'</h2>";
echo "<table border='1'><tr><th>ID</th><th>Operación</th><th>Valor1</th><th>Valor2</th><th>Resultado</th></tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['operacion']}</td>
            <td>{$fila['valor1']}</td>
            <td>{$fila['valor2']}</td>
            <td>{$fila['resultado']}</td>
          </tr>";
}
echo "</table>";

$conexion->close();
?>
