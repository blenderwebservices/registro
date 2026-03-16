<?php
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Mexico_City');

require_once __DIR__ . '/db_config.php';

$response = ['status' => 'error', 'msj' => 'Ocurrió un error inesperado'];

try {
    if (!isset($_GET['email']) || empty(trim($_GET['email']))) {
        throw new Exception('El email es requerido.');
    }
    
    $email = trim($_GET['email']);
    
    // Conexión a la base de datos
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $dbh = new mysqli($db_ENV_host, $db_ENV_user, $db_ENV_pass, $db_ENV_name);
    $dbh->set_charset("utf8mb4");
    
    // 1. Verificar si ya está registrado en esta edición (registro_leon_2026)
    $stmt = $dbh->prepare("SELECT id FROM registro_leon_2026 WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $response = [
            'status' => 'registrado',
            'msj' => 'Este email ya fue registrado en esta edición, utilice uno diferente'
        ];
        $stmt->close();
        echo json_encode($response);
        exit;
    }
    $stmt->close();
    
    /*
    // 2. Buscar datos previos en tabla asistido24
    $stmt2 = $dbh->prepare("SELECT asistido, ediciones FROM asistido24 WHERE email = ? LIMIT 1");
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $result = $stmt2->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $response = [
            'status' => 'true',
            'data' => ['data' => [$row]], // Mantenemos la estructura original requerida por el frontend
            'msj' => 'encontrado'
        ];
    } else {
        $response = [
            'status' => 'false',
            'msj' => 'no existen coincidencias'
        ];
    }
    $stmt2->close();
    */

    // Al estar deshabilitada la búsqueda en asistido24, devolvemos 'false' por defecto para continuar el flujo
    $response = [
        'status' => 'false',
        'msj' => 'no existen coincidencias'
    ];
    $dbh->close();
    
} catch (Exception $e) {
    // Retornamos el error en formato JSON para que frontend lo maneje
    $response['msj'] = 'Error del servidor: ' . $e->getMessage();
}

echo json_encode($response);
?>