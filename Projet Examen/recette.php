<?php

require __DIR__ . '/autoload.php'; 
require __DIR__ . '/src/db.php'; 

use App\Controller\RecipeController;
use App\Manager\RecipeManager;
use App\Manager\FavoriteManager;
use App\Manager\CategoryManager;

session_start();

$recipeManager = new RecipeManager($conn);
$favoriteManager = new FavoriteManager($conn);
$categoryManager = new CategoryManager($conn);

$recipeController = new RecipeController($recipeManager, $favoriteManager, $categoryManager);
$recipeController->index();
