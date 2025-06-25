<?php
// api/auth.php
// Maneja el login de usuarios y la gestión de sesiones.

require_once __DIR__ . '/../db.php';
require_once 'middleware.php'; // Incluye el middleware para iniciar sesión y acceder a sus funciones

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

$pdo = connectDB(); // Conecta a la base de datos

// Maneja solicitudes POST para el login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($username) || empty($password)) {
        sendErrorResponse('Nombre de usuario y contraseña son requeridos.', 400);
    }

    try {
        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username =?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && $password == $user['password']) {
            // Autenticación exitosa
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];

            echo json_encode([
                'message' => 'Login exitoso.',
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ]
            ]);
        } else {
            sendErrorResponse('Credenciales invalidas.', 401);
        }
    } catch (PDOException $e) {
        // En un entorno de producción, loguear el error y mostrar un mensaje genérico.
        sendErrorResponse('Error en el servidor: ' . $e->getMessage(), 500);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Maneja solicitudes GET para verificar el estado de la sesión
    if (isAuthenticated()) {
        echo json_encode([
            'isAuthenticated' => true,
            'user' => [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'role' => $_SESSION['user_role']
            ]
        ]);
    } else {
        echo json_encode(['isAuthenticated' => false]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Maneja solicitudes DELETE para cerrar la sesión (logout)
    session_destroy(); // Destruye todas las variables de sesión
    echo json_encode(['message' => 'Sesión cerrada exitosamente.']);
} else {
    // Método no permitido
    sendErrorResponse('Método no permitido.', 405);
}
?>
