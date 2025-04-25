<?php

require __DIR__ . '/autoload.php';

session_start();

use App\Controller\DashboardController;
use App\Manager\UserManager;
use App\Manager\CategoryManager;

require __DIR__ . '/src/db.php';

$userManager = new UserManager($conn);
$categoryManager = new CategoryManager($conn);

$dashboardController = new DashboardController($userManager, $categoryManager);
$dashboardController->index();
