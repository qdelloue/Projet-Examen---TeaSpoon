<?php

require __DIR__ . '/autoload.php';

use App\Controller\IndexController;
use App\Manager\CategoryManager;
use App\Manager\RecipeManager;

require __DIR__ . '/src/db.php';

$categoryManager = new CategoryManager($conn);
$recipeManager = new RecipeManager($conn);

$indexController = new IndexController($categoryManager, $recipeManager);
$indexController->index();

