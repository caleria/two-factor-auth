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

try {
    $res = $userController->deactivateSecondFactor();

    if (!$res) {
        http_response_code(400);
    } else {
        http_response_code(200);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error interno del servidor.";
}

