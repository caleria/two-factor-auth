<?php

session_start();

require('../vendor/autoload.php');

use App\Controllers\UserController;

$userController = new UserController();
$userController->logout();

header('Location: ../index.php');