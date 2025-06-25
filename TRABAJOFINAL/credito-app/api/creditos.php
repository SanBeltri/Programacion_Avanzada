<?php
// api/creditos.php
// Maneja las operaciones CRUD para los créditos hipotecarios.

require_once __DIR__ . '/../db.php';
require_once 'middleware.php'; // Incluye el middleware para la autenticación y roles

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

$pdo = connectDB(); // Conecta a la base de datos

// Directorio donde se guardarán los archivos subidos
define('UPLOAD_DIR', __DIR__ . '/../uploads/'); // En la raíz de credito-app/uploads/
// Asegúrate de que el directorio de carga exista
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true); // Crea el directorio con permisos de escritura (0777 para desarrollo)
}
// Obtiene el ID y rol del usuario actual de la sesión
$current_user_id = $_SESSION['user_id'] ?? null;
$current_user_role = $_SESSION['user_role'] ?? null;

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
 * Maneja las solicitudes GET para créditos.
 */
function handleGetRequests() {
    global $pdo, $current_user_id, $current_user_role;

    requireAuth(); // Requiere autenticación para cualquier GET

    $id = $_GET['id'] ?? null;

    try {
        if ($id) {
            // Obtener un crédito específico
            $stmt = $pdo->prepare("SELECT l.*, u.username as client_username
                                   FROM loans l
                                   JOIN users u ON l.user_id = u.id
                                   WHERE l.id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $loan = $stmt->fetch();

            if ($loan) {
                // Restricción de visibilidad: Un cliente solo puede ver sus propios créditos.
                // Otros roles pueden ver todos los créditos o los relevantes para su etapa.
                if ($current_user_role === 'cliente' && $loan['user_id'] != $current_user_id) {
                    sendErrorResponse('Acceso denegado. No tiene permiso para ver este crédito.', 403);
                }
                echo json_encode($loan);
            } else {
                sendErrorResponse('Crédito no encontrado.', 404);
            }
        } else {
            // Obtener todos los créditos o créditos relevantes según el rol
            $sql = "SELECT l.*, u.username as client_username,
                           a.username as advisor_username,
                           s.username as subgerente_username,
                           g.username as gerente_username
                    FROM loans l
                    JOIN users u ON l.user_id = u.id
                    LEFT JOIN users a ON l.advisor_id = a.id
                    LEFT JOIN users s ON l.subgerente_id = s.id
                    LEFT JOIN users g ON l.gerente_id = g.id";

            $whereClauses = [];
            $params = [];

            switch ($current_user_role) {
                case 'cliente':
                    // Un cliente solo ve sus propios créditos
                    $whereClauses[] = "l.user_id = :user_id";
                    $params[':user_id'] = $current_user_id;
                    break;
                case 'asesor':
                    // Un asesor ve créditos pendientes de su asignación o pendientes de asesor
                    $whereClauses[] = "(l.status = 'pending_asesor' OR l.advisor_id = :advisor_id)";
                    $params[':advisor_id'] = $current_user_id;
                    break;
                case 'subgerente':
                    // Un subgerente ve créditos pendientes de subgerente o asignados a él
                    $whereClauses[] = "(l.status = 'pending_subgerente' OR l.subgerente_id = :subgerente_id)";
                    $params[':subgerente_id'] = $current_user_id;
                    break;
                case 'gerente':
                    // Un gerente ve créditos pendientes de gerente o asignados a él
                    $whereClauses[] = "(l.status = 'pending_gerente' OR l.gerente_id = :gerente_id)";
                    $params[':gerente_id'] = $current_user_id;
                    break;
                // 'admin' o otros roles podrían ver todos los créditos, si se implementan
                default:
                    // Si no hay rol específico, no debería llegar aquí si requireAuth() funciona.
                    // Para roles sin reglas específicas (ej. un admin futuro), aquí iría un 'true'
                    break;
            }

            if (!empty($whereClauses)) {
                $sql .= " WHERE " . implode(' AND ', $whereClauses);
            }

            $stmt = $pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $loans = $stmt->fetchAll();
            echo json_encode($loans);
        }
    } catch (PDOException $e) {
        sendErrorResponse('Error al obtener los créditos: ' . $e->getMessage(), 500);
    }
}

/**
 * Maneja las solicitudes POST para crear nuevos créditos.
 */
function handlePostRequests() {
    global $pdo, $current_user_id, $current_user_role;

    requireRole(['cliente']); // Solo los clientes pueden crear créditos

    // Para POST con FormData, los datos vienen en $_POST y $_FILES
    $amount = $_POST['amount'] ?? null;
    $term = $_POST['term'] ?? null;
    $client_notes = $_POST['client_notes'] ?? null;
    $document_path = null;

    if (empty($amount) || empty($term)) {
        sendErrorResponse('Monto y plazo son requeridos.', 400);
    }

    // Manejo de la carga de archivos
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['document'];

        // Validaciones básicas del archivo
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            sendErrorResponse('Tipo de archivo no permitido. Solo PDF, JPG, PNG, GIF.', 400);
        }
        if ($file['size'] > $maxSize) {
            sendErrorResponse('El archivo es demasiado grande. Máximo 5MB.', 400);
        }

        // Generar un nombre único para el archivo para evitar colisiones
        $fileName = uniqid('doc_') . '_' . basename($file['name']);
        $destination = UPLOAD_DIR . $fileName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Guardar la ruta relativa al directorio raíz de la aplicación
            $document_path = 'uploads/' . $fileName;
        } else {
            sendErrorResponse('Error al subir el archivo.', 500);
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO loans (user_id, amount, term, client_notes, document_path, status) VALUES (:user_id, :amount, :term, :client_notes, :document_path, 'pending_asesor')");
        $stmt->bindParam(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':term', $term, PDO::PARAM_INT);
        $stmt->bindParam(':client_notes', $client_notes);
        $stmt->bindParam(':document_path', $document_path); // Puede ser NULL
        $stmt->execute();

        $lastId = $pdo->lastInsertId();
        echo json_encode(['message' => 'Crédito solicitado exitosamente.', 'id' => $lastId]);
    } catch (PDOException $e) {
        sendErrorResponse('Error al solicitar el crédito: ' . $e->getMessage(), 500);
    }
}
/**
 * Maneja las solicitudes PUT para actualizar créditos.
 */
function handlePutRequests() {
    global $pdo, $current_user_id, $current_user_role;

    $id = $_GET['id'] ?? null; // El ID del crédito a actualizar
    if (!$id) {
        sendErrorResponse('ID del crédito no especificado.', 400);
    }

    $data = json_decode(file_get_contents('php://input'), true);

    try {
        // Obtener el crédito actual para verificar el estado y los permisos
        $stmt = $pdo->prepare("SELECT * FROM loans WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $loan = $stmt->fetch();

        if (!$loan) {
            sendErrorResponse('Crédito no encontrado.', 404);
        }

        $updateFields = [];
        $params = [':id' => $id];

        // Lógica de actualización basada en el rol y el estado del crédito
        switch ($current_user_role) {
            case 'asesor':
                requireRole(['asesor']);
                if ($loan['status'] === 'pending_asesor') {
                    if (isset($data['advisor_notes'])) {
                        $updateFields[] = "advisor_notes = :advisor_notes";
                        $params[':advisor_notes'] = $data['advisor_notes'];
                    }
                    // El asesor puede cambiar el estado a 'pending_subgerente'
                    if (isset($data['status']) && $data['status'] === 'pending_subgerente') {
                        $updateFields[] = "status = :status";
                        $params[':status'] = $data['status'];
                        $updateFields[] = "advisor_id = :current_user_id";
                        $params[':current_user_id'] = $current_user_id;
                    }
                } else {
                    sendErrorResponse('El asesor solo puede actualizar créditos pendientes de asesoría.', 403);
                }
                break;

            case 'subgerente':
                requireRole(['subgerente']);
                if ($loan['status'] === 'pending_subgerente') {
                    if (isset($data['subgerente_notes'])) {
                        $updateFields[] = "subgerente_notes = :subgerente_notes";
                        $params[':subgerente_notes'] = $data['subgerente_notes'];
                    }
                    // El subgerente puede cambiar el estado a 'pending_gerente'
                    if (isset($data['status']) && $data['status'] === 'pending_gerente') {
                        $updateFields[] = "status = :status";
                        $params[':status'] = $data['status'];
                        $updateFields[] = "subgerente_id = :current_user_id";
                        $params[':current_user_id'] = $current_user_id;
                    }
                } else {
                    sendErrorResponse('El subgerente solo puede actualizar créditos pendientes de subgerencia.', 403);
                }
                break;

            case 'gerente':
                requireRole(['gerente']);
                if ($loan['status'] === 'pending_gerente') {
                    if (isset($data['gerente_notes'])) {
                        $updateFields[] = "gerente_notes = :gerente_notes";
                        $params[':gerente_notes'] = $data['gerente_notes'];
                    }
                    // El gerente puede aprobar o denegar
                    if (isset($data['status']) && in_array($data['status'], ['approved', 'denied'])) {
                        $updateFields[] = "status = :status";
                        $params[':status'] = $data['status'];
                        $updateFields[] = "gerente_id = :current_user_id";
                        $params[':current_user_id'] = $current_user_id;
                    }
                } else {
                    sendErrorResponse('El gerente solo puede actualizar créditos pendientes de gerencia.', 403);
                }
                break;

            default:
                sendErrorResponse('Acceso denegado. No tiene permisos para actualizar créditos.', 403);
                break;
        }

        if (empty($updateFields)) {
            sendErrorResponse('No se proporcionaron datos válidos para actualizar o no tiene permiso.', 400);
        }

        $sql = "UPDATE loans SET " . implode(', ', $updateFields) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        echo json_encode(['message' => 'Crédito actualizado exitosamente.']);

    } catch (PDOException $e) {
        sendErrorResponse('Error al actualizar el crédito: ' . $e->getMessage(), 500);
    }
}

/**
 * Maneja las solicitudes DELETE para créditos.
 * Esto es principalmente para roles administrativos, si se implementa un CRUD completo de gestión.
 * Por el flujo solicitado, no es estrictamente necesario que un 'cliente' o 'asesor' elimine.
 */
function handleDeleteRequests() {
    global $pdo;
    requireRole(['gerente']); // Solo el gerente (o un rol admin) puede eliminar créditos.

    $id = $_GET['id'] ?? null;
    if (!$id) {
        sendErrorResponse('ID del crédito no especificado.', 400);
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM loans WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Crédito eliminado exitosamente.']);
        } else {
            sendErrorResponse('Crédito no encontrado.', 404);
        }
    } catch (PDOException $e) {
        sendErrorResponse('Error al eliminar el crédito: ' . $e->getMessage(), 500);
    }
}
?>
