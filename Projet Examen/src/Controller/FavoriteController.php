<?php

namespace App\Controller;

use App\Manager\FavoriteManager;
use App\Manager\RecipeManager;

class FavoriteController
{
    private $favoriteManager;
    private $recipeManager;

    public function __construct(FavoriteManager $favoriteManager, RecipeManager $recipeManager)
    {
        $this->favoriteManager = $favoriteManager;
        $this->recipeManager = $recipeManager;
    }

    public function index()
    {
        // Checking if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: connexion.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // Retrieving the user's favorite recipes
        $recipes = $this->favoriteManager->getFavoriteRecipes($user_id);

        // Include the view and pass the data to it
        include 'template/favorite/favoris.template.php';
    }

    public function toggleFavorite()
    {
        // Checking if the user is logged in and if the recipe ID is present in the POST request
        if (!isset($_SESSION['user_id']) || !isset($_POST['recette_id'])) {
            header("Location: index.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $recette_id = intval($_POST['recette_id']);

        // Checking if the recipe is already a favorite
        $is_favorite = $this->favoriteManager->isRecipeFavorite($user_id, $recette_id);

        if ($is_favorite) {
            // Removing from favorites
            $this->favoriteManager->removeFavorite($user_id, $recette_id);
        } else {
            // Adding to favorites
            $this->favoriteManager->addFavorite($user_id, $recette_id);
        }

        // Redirecting to the recipe page
        header("Location: recette.php?id=" . $recette_id);
        exit();
    }
}
