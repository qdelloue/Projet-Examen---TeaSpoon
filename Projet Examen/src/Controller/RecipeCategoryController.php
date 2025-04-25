<?php

namespace App\Controller;

use App\Manager\RecipeManager;
use App\Manager\CategoryManager;

class RecipeCategoryController
{
    private $recipeManager;
    private $categoryManager;

    public function __construct(RecipeManager $recipeManager, CategoryManager $categoryManager)
    {
        $this->recipeManager = $recipeManager;
        $this->categoryManager = $categoryManager;
    }

    public function index()
    {
        // Retrieving the category ID from the GET request
        $category_id = isset($_GET['recetteCategory']) ? intval($_GET['recetteCategory']) : 0;

        // Retrieving the recipes from the category
        $recipes = $this->recipeManager->getRecipesByCategory($category_id);

        // Retrieving the category name
        $category_name = $this->categoryManager->getCategoryName($category_id);

        // Checking if the user is logged in and is an admin
        isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

        // Include the view and pass the data to it
        include 'template/recetteCategory/recetteCategory.template.php';
    }
}
