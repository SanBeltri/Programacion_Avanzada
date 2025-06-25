<?php
// api/middleware.php
// Middleware para validación de sesión y roles.


/**
 * Valida si el usuario está autenticado.
 * @return bool True si el usuario está logueado, false de lo contrario.
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

/**
 * Valida si el usuario tiene el rol requerido para acceder a una ruta o función.
 * @param array $allowedRoles Array de roles permitidos (ej. ['admin', 'gerente']).
 * @return bool True si el usuario tiene un rol permitido, false de lo contrario.
 */
function hasRole($allowedRoles) {
    if (!isAuthenticated()) {
        return false; // No autenticado
    }
    $userRole = $_SESSION['user_role'];
    return in_array($userRole, $allowedRoles);
}

/**
 * Envía una respuesta de error JSON y termina la ejecución.
 * @param string $message Mensaje de error.
 * @param int $statusCode Código de estado HTTP.
 */
function sendErrorResponse($message, $statusCode) {
    http_response_code($statusCode);
    echo json_encode(['message' => $message]);
    exit();
}

/**
 * Middleware para proteger rutas que requieren autenticación.
 */
function requireAuth() {
    if (!isAuthenticated()) {
        sendErrorResponse('No autorizado. Por favor, inicie sesión.', 401); // Unauthorized
    }
}

/**
 * Middleware para proteger rutas que requieren roles específicos.
 * @param array $allowedRoles Array de roles permitidos.
 */
function requireRole($allowedRoles) {
    if (!isAuthenticated()) {
        sendErrorResponse('No autorizado. Por favor, inicie sesión.', 401); // Unauthorized
    }
    if (!hasRole($allowedRoles)) {
        sendErrorResponse('Acceso denegado. No tiene los permisos necesarios.', 403); // Forbidden
    }
}
?>
