<?php

namespace App\Controller;

use App\Manager\CategoryManager;
use App\Manager\RecipeManager;

class IndexController
{
    private $categoryManager;
    private $recipeManager;

    public function __construct(CategoryManager $categoryManager, RecipeManager $recipeManager)
    {
        $this->categoryManager = $categoryManager;
        $this->recipeManager = $recipeManager;
    }

    public function index()
    {
        // Welcome Section
        $welcomeSections = $this->categoryManager->getWelcomeSections();

        // Slider
        $recipes = $this->recipeManager->getRandomRecipes(4);

        // Category Section
        $categorySections = $this->categoryManager->getMainCategories();

        // Include the view and pass the data to it
        include 'template/index/index.template.php';
    }
}
