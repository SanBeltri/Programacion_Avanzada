
<?php
// db.php
// Configuración de la conexión a la base de datos MySQL

define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Tu usuario de MySQL
define('DB_PASS', '');     // Tu contraseña de MySQL
define('DB_NAME', 'hipotecario_db');

/**
 * Función para establecer la conexión a la base de datos.
 * @return PDO Objeto PDO para la conexión.
 * @throws PDOException Si la conexión falla.
 */
function connectDB() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones en errores
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Obtener resultados como arrays asociativos
            PDO::ATTR_EMULATE_PREPARES   => false,                // Deshabilitar la emulación de preparaciones para seguridad
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // En un entorno de producción, loguear el error y mostrar un mensaje genérico.
        // echo "Error de conexión a la base de datos: " . $e->getMessage();
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Error de conexión a la base de datos.']);
        exit();
    }
}
?>
