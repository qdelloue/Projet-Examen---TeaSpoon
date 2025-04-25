<?php
require __DIR__ . '/autoload.php';

use App\Controller\AdminController;
use App\Manager\RecipeManager;
use App\Manager\UserManager;
use App\Manager\ContactManager;

require __DIR__ . '/src/db.php';

$recipeManager = new RecipeManager($conn);
$userManager = new UserManager($conn);
$contactManager = new ContactManager($conn);

$adminController = new AdminController($recipeManager, $userManager, $contactManager);
$adminController->supprimerMessage();
