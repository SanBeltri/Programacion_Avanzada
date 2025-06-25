<?php
// index.php
// Este archivo actúa como el enrutador principal para todas las solicitudes API.
// Redirige las solicitudes a los archivos PHP apropiados en el directorio 'api'.


// Iniciar la sesión para que las APIs puedan acceder a ella.
// Esto debe estar al principio de cualquier script que use sesiones.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Definir la base del directorio para las APIs
define('API_DIR', __DIR__ . '/api/');

// Obtener la ruta de la solicitud (ej. /creditos, /auth/login)
// Eliminamos la parte base del path si existe (ej. /credito-app/index.php)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']); // Obtiene el directorio del script actual

// Remover el subdirectorio si la aplicación está en uno (ej. /credito-app)
if (strpos($requestUri, $scriptName) === 0) {
    $requestUri = substr($requestUri, strlen($scriptName));
}

// Limpiar la ruta para obtener el recurso (ej. /creditos, /auth)
$requestUri = trim($requestUri, '/');
$parts = explode('/', $requestUri);
$resource = $parts[1] ?? ''; // creditos, auth, usuarios
$id = $parts[2] ?? null; // id del recurso, si existe

// Determinar qué archivo API incluir
switch ($resource) {
    case 'auth':
        require API_DIR . 'auth.php';
        break;
    case 'creditos':
        $_GET['id'] = $id; // Pasar el ID a la API de créditos si existe
        require API_DIR . 'creditos.php';
        break;
    case 'usuarios':
        require API_DIR . 'usuarios.php';
        break;
    case '':
         header('Location: /credito-app/public/index.html');
        break;
    default:
        // Recurso no encontrado
        header('Content-Type: application/json');
        http_response_code(404); // Not Found
        echo json_encode(['message' => 'Recurso no encontrado.']);
        break;
}
?>
