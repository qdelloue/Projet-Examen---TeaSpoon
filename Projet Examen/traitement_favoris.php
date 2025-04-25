<?php

require __DIR__ . '/autoload.php';

use App\Controller\FavoriteController;
use App\Manager\FavoriteManager;
use App\Manager\RecipeManager;

require __DIR__ . '/src/db.php';

session_start();

$favoriteManager = new FavoriteManager($conn);
$recipeManager = new RecipeManager($conn);

$favoriteController = new FavoriteController($favoriteManager, $recipeManager);
$favoriteController->toggleFavorite();
