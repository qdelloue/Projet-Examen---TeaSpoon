<?php

require __DIR__ . '/autoload.php';

use App\Controller\SecurityController;
use App\Manager\UserManager;

require __DIR__ . '/src/db.php';

$userManager = new UserManager($conn);

$securityController = new SecurityController($userManager);
$securityController->connexion();
