<?php

session_start();

require('../vendor/autoload.php');

use App\Controllers\UserController;

$userController = new UserController();

// Verificar si el usuario está autenticado
if (!$userController->isUserLoggedIn()) {
    http_response_code(401);
    echo "No existe autenticación";
    exit;
}

// Obtener los datos JSON enviados a través de la solicitud
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Verificar si los datos necesarios están presentes
if (isset($data['secret']) && isset($data['codigo'])) {
    // Llamar a la función activateSecondFactor() del controlador
    try {
        $res = $userController->activateSecondFactor($data['secret'], $data['codigo']);

        if (!$res) {
            // Si la activación del segundo factor falla debido a un código incorrecto
            http_response_code(400);
            echo "Código incorrecto para la autenticación de dos factores";
        } else {
            // Si la activación del segundo factor es exitosa
            http_response_code(200);
            echo "El segundo factor de autenticación se ha activado correctamente.";
        }
    } catch (PDOException $e) {
        // Manejar la excepción aquí si es necesario
        // Por ejemplo, podrías registrar el error en un archivo de registro
        http_response_code(500);
        echo "Error interno del servidor.";
    }
} else {
    // Si no se proporcionaron los datos necesarios, devolver un mensaje de error
    http_response_code(400);
    echo "Faltan datos en la solicitud.";
}

