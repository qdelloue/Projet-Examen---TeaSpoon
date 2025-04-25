<?php

require __DIR__ . '/autoload.php';

use App\Controller\RecipeController;
use App\Manager\RecipeManager;
use App\Manager\FavoriteManager;
use App\Manager\CategoryManager;

require __DIR__ . '/src/db.php';

session_start(); 

$recipeManager = new RecipeManager($conn);
$favoriteManager = new FavoriteManager($conn);
$categoryManager = new CategoryManager($conn);

$recipeController = new RecipeController($recipeManager, $favoriteManager, $categoryManager);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeController->handleAjouterRecette();
} else {
    $recipeController->ajouterRecette(); 
}
