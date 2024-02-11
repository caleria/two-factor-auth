<?php

session_start();

require('../vendor/autoload.php');

use App\Controllers\UserController;

$rawData = file_get_contents("php://input");

$data = json_decode($rawData, true);

$userController = new UserController();

$resultado = $userController->validateCode($data['code']);

if (!$resultado) {
    http_response_code(400);
    echo "Codigo incorrecto";
} else {
    http_response_code(200);
}
