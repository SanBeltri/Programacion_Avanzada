<?php
$conexion = new mysqli("localhost", "root", "", "Trabajo3");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM Trabajo3";
$resultado = $conexion->query($sql);

echo "<h2>Registros en la tabla 'Trabajo3'</h2>";
echo "<table border='1'><tr><th>ID</th><th>Operación</th><th>Dato1</th><th>Dato2</th><th>Resultado</th></tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['ID']}</td>
            <td>{$fila['operacion']}</td>
            <td>{$fila['Dato1']}</td>
            <td>{$fila['Dato2']}</td>
            <td>{$fila['Resultado']}</td>
          </tr>";
}
echo "</table>";

$conexion->close();
?>
