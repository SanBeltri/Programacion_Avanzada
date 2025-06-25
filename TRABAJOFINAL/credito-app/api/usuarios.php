<?php
// api/usuarios.php
// Maneja las operaciones CRUD para los usuarios (principalmente para un rol de administrador o gerente).

require_once __DIR__ . '/../db.php';
require_once 'middleware.php'; // Incluye el middleware para la autenticación y roles

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

$pdo = connectDB(); // Conecta a la base de datos

// Enrutamiento de solicitudes
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        handleGetRequests();
        break;
    case 'POST':
        handlePostRequests();
        break;
    case 'PUT':
        handlePutRequests();
        break;
    case 'DELETE':
        handleDeleteRequests();
        break;
    default:
        sendErrorResponse('Método no permitido.', 405); // Método no permitido
        break;
}

/**
 * Maneja las solicitudes GET para usuarios.
 */
function handleGetRequests() {
    global $pdo;
    requireRole(['gerente']); // Solo el gerente puede listar/ver usuarios

    $id = $_GET['id'] ?? null;

    try {
        if ($id) {
            // Obtener un usuario específico (sin la contraseña)
            $stmt = $pdo->prepare("SELECT id, username, role FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user) {
                echo json_encode($user);
            } else {
                sendErrorResponse('Usuario no encontrado.', 404);
            }
        } else {
            // Obtener todos los usuarios (sin las contraseñas)
            $stmt = $pdo->query("SELECT id, username, role FROM users");
            $users = $stmt->fetchAll();
            echo json_encode($users);
        }
    } catch (PDOException $e) {
        sendErrorResponse('Error al obtener los usuarios: ' . $e->getMessage(), 500);
    }
}

/**
 * Maneja las solicitudes POST para crear nuevos usuarios.
 */
function handlePostRequests() {
    global $pdo;
    requireRole(['gerente']); // Solo el gerente puede crear usuarios

    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'] ?? null;
    $password = $data['password'] ?? null;
    $role = $data['role'] ?? null;

    if (empty($username) || empty($password) || empty($role)) {
        sendErrorResponse('Nombre de usuario, contraseña y rol son requeridos.', 400);
    }

    // Validar que el rol sea uno de los permitidos
    $allowedRoles = ['cliente', 'asesor', 'subgerente', 'gerente'];
    if (!in_array($role, $allowedRoles)) {
        sendErrorResponse('Rol inválido. Los roles permitidos son: ' . implode(', ', $allowedRoles), 400);
    }

    try {
        // Hashear la contraseña antes de guardarla
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        $lastId = $pdo->lastInsertId();
        echo json_encode(['message' => 'Usuario creado exitosamente.', 'id' => $lastId]);
    } catch (PDOException $e) {
        // Verificar si el error es por nombre de usuario duplicado
        if ($e->getCode() == '23000') { // Código de error SQLSTATE para violación de unicidad
            sendErrorResponse('El nombre de usuario ya existe.', 409); // Conflict
        }
        sendErrorResponse('Error al crear el usuario: ' . $e->getMessage(), 500);
    }
}

/**
 * Maneja las solicitudes PUT para actualizar usuarios.
 */
function handlePutRequests() {
    global $pdo;
    requireRole(['gerente']); // Solo el gerente puede actualizar usuarios

    $id = $_GET['id'] ?? null;
    if (!$id) {
        sendErrorResponse('ID de usuario no especificado.', 400);
    }

    $data = json_decode(file_get_contents('php://input'), true);

    $updateFields = [];
    $params = [':id' => $id];

    if (isset($data['username'])) {
        $updateFields[] = "username = :username";
        $params[':username'] = $data['username'];
    }
    if (isset($data['password']) && !empty($data['password'])) {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $updateFields[] = "password = :password";
        $params[':password'] = $hashedPassword;
    }
    if (isset($data['role'])) {
        $allowedRoles = ['cliente', 'asesor', 'subgerente', 'gerente'];
        if (!in_array($data['role'], $allowedRoles)) {
            sendErrorResponse('Rol inválido. Los roles permitidos son: ' . implode(', ', $allowedRoles), 400);
        }
        $updateFields[] = "role = :role";
        $params[':role'] = $data['role'];
    }

    if (empty($updateFields)) {
        sendErrorResponse('No se proporcionaron datos para actualizar.', 400);
    }

    try {
        $sql = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Usuario actualizado exitosamente.']);
        } else {
            sendErrorResponse('Usuario no encontrado o no se realizaron cambios.', 404);
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') { // Código de error SQLSTATE para violación de unicidad
            sendErrorResponse('El nombre de usuario ya existe.', 409); // Conflict
        }
        sendErrorResponse('Error al actualizar el usuario: ' . $e->getMessage(), 500);
    }
}

/**
 * Maneja las solicitudes DELETE para eliminar usuarios.
 */
function handleDeleteRequests() {
    global $pdo;
    requireRole(['gerente']); // Solo el gerente puede eliminar usuarios

    $id = $_GET['id'] ?? null;
    if (!$id) {
        sendErrorResponse('ID de usuario no especificado.', 400);
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Usuario eliminado exitosamente.']);
        } else {
            sendErrorResponse('Usuario no encontrado.', 404);
        }
    } catch (PDOException $e) {
        sendErrorResponse('Error al eliminar el usuario: ' . $e->getMessage(), 500);
    }
}
?>
