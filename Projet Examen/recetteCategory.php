<?php

require __DIR__ . '/autoload.php';

use App\Controller\RecipeCategoryController;
use App\Manager\RecipeManager;
use App\Manager\CategoryManager;

require __DIR__ . '/src/db.php';

session_start();

$recipeManager = new RecipeManager($conn);
$categoryManager = new CategoryManager($conn);

$recipeCategoryController = new RecipeCategoryController($recipeManager, $categoryManager);
$recipeCategoryController->index();
