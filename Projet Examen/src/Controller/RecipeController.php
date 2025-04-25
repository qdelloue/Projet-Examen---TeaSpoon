<?php

namespace App\Controller;

use App\Manager\RecipeManager;
use App\Manager\FavoriteManager;
use App\Manager\CategoryManager;
use App\Entity\Recipe;
use Exception;

class RecipeController
{
    private $recipeManager;
    private $favoriteManager;
    private $categoryManager;

    public function __construct(RecipeManager $recipeManager, FavoriteManager $favoriteManager, CategoryManager $categoryManager)
    {
        $this->recipeManager = $recipeManager;
        $this->favoriteManager = $favoriteManager;
        $this->categoryManager = $categoryManager;
    }

    public function index()
    {
        // Retrieving the recipe ID and category ID from the GET request
        $recette_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $category_id = isset($_GET['recetteCategory']) ? intval($_GET['recetteCategory']) : 0;

        // Retrieving the user ID if logged in
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Retrieving the recipe details
        $recette = $this->recipeManager->getRecipeById($recette_id);

        // Check if the recipe was found
        if (!$recette) {
            header("Location: index.php");
            exit();
        }

        // Check if the recipe is already a favorite
        $is_favorite = $this->favoriteManager->isRecipeFavorite($user_id, $recette_id);

        // Include the view and pass the data to it
        include 'template/recipe/recette.template.php';
    }

    public function ajouterRecette()
    {
        // Checking if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: connexion.php");
            exit();
        }
    
        // Retrieving categories
        $categories = $this->categoryManager->getAllCategories();
    
        // Check and Unset success and error messages before including the view
        $recipe_success = isset($_SESSION['recipe_success']) ? $_SESSION['recipe_success'] : null;
        unset($_SESSION['recipe_success']); 
    
        $recipe_errors = isset($_SESSION['recipe_errors']) ? $_SESSION['recipe_errors'] : [];
        unset($_SESSION['recipe_errors']); 
    
        // Include the view and pass the data to it
        include 'template/recipe/ajouter_recette.template.php';
    }

    public function handleAjouterRecette()
    {
        // Checking if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: connexion.php");
            exit();
        }

        // Retrieving categories
        $categories = $this->categoryManager->getAllCategories();

        // Validating fields
        $_SESSION['recipe_errors'] = [];

        if (empty($_POST['titre'])) {
            $_SESSION['recipe_errors']['titre'] = "Le titre est obligatoire.";
        }
        if (empty($_POST['description'])) {
            $_SESSION['recipe_errors']['description'] = "La description est obligatoire.";
        }
        if (empty($_POST['ingredients'])) {
            $_SESSION['recipe_errors']['ingredients'] = "Les ingrédients sont obligatoires.";
        }
        if (empty($_POST['instructions'])) {
            $_SESSION['recipe_errors']['instructions'] = "Les instructions sont obligatoires.";
        }
        if (empty($_POST['categorie_id'])) {
            $_SESSION['recipe_errors']['categorie_id'] = "La catégorie est obligatoire.";
        }

        // Image management
        $chemin_image = '';
        $imageName = null; 

        if ($_FILES['image']['error'] == 0) {
            $nom_image = $_FILES['image']['name'];
            $tmp_image = $_FILES['image']['tmp_name'];
            $chemin_image = "assets/images/" . basename($nom_image);

            // Checking the file type
            $type_image = strtolower(pathinfo($nom_image, PATHINFO_EXTENSION));
            if ($type_image != "jpg" && $type_image != "png" && $type_image != "jpeg" && $type_image != "gif") {
                $_SESSION['recipe_errors']['image'] = "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            }

            // Resize the image
            $newWidth = 1280;
            $newHeight = 850;

            // Get the image dimensions
            list($width, $height) = getimagesize($tmp_image);

            // Create a new temporary image
            $tmp = imagecreatetruecolor($newWidth, $newHeight);

            // Load the image based on its type
            switch ($type_image) {
                case 'jpeg':
                case 'jpg':
                    $source = imagecreatefromjpeg($tmp_image);
                    break;
                case 'png':
                    $source = imagecreatefrompng($tmp_image);
                    imagealphablending($tmp, false);
                    imagesavealpha($tmp, true);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($tmp_image);
                    break;
                default:
                    $_SESSION['recipe_errors']['image'] = "Type de fichier image non supporté.";
                    break;
            }

            // Check if the image was loaded successfully
            if (!isset($_SESSION['recipe_errors']['image'])) {
                // Resize and copy the image
                imagecopyresampled($tmp, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Save the resized image
                switch ($type_image) {
                    case 'jpeg':
                    case 'jpg':
                        imagejpeg($tmp, $tmp_image, 80); 
                        break;
                    case 'png':
                        imagepng($tmp, $tmp_image, 9); 
                        break;
                    case 'gif':
                        imagegif($tmp, $tmp_image);
                        break;
                }

                // Free up memory
                imagedestroy($source);
                imagedestroy($tmp);
            }


            // Moving the file
            if (!isset($_SESSION['recipe_errors']['image'])) {
                if (!move_uploaded_file($tmp_image, $chemin_image)) {
                    $_SESSION['recipe_errors']['image'] = "Erreur lors du téléchargement de l'image.";
                } else {
                    $imageName = basename($nom_image); 
                }
            }
        }

        // Insert into the database if no errors
        if (empty($_SESSION['recipe_errors'])) {
            $titre = $_POST['titre'];
            $categorie_id = $_POST['categorie_id'];
            $description = $_POST['description'];
            $ingredients = $_POST['ingredients'];
            $instructions = $_POST['instructions'];
            $image = isset($imageName) ? $imageName : ''; 

            // Create a Recipe entity
            try {
                $recipe = new Recipe(0, $titre, $categorie_id, $description, $ingredients, $instructions, $image);
            } catch (Exception $e) {
                error_log("Error creating Recipe entity: " . $e->getMessage());
                $_SESSION['recipe_errors']['general'] = "Erreur lors de la création de la recette.";
                header("Location: ajouter_recette.php");
                exit();
            }

            // Use the RecipeManager to create the recipe
            $result = $this->recipeManager->createRecipe($recipe);

            if ($result) {
                $_SESSION['recipe_success'] = "Recette ajoutée avec succès!";
            } else {
                $_SESSION['recipe_errors']['general'] = "Erreur lors de l'ajout de la recette.";
            }
        }

        header("Location: ajouter_recette.php"); 
        exit();
    }

    public function modifierRecette()
    {
        session_start();

        // Checking if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: connexion.php");
            exit();
        }

        // Retrieving the recipe ID from the GET request
        $recette_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Retrieving the recipe information
        $recette = $this->recipeManager->getRecipeById($recette_id);

        // Checking if the recipe was found
        if (!$recette) {
            header("Location: index.php");
            exit();
        }

        // Retrieving categories
        $categories = $this->categoryManager->getAllCategories();

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'modifier') {
            $this->handleModifierRecette($recette_id); 
            return;
        }

        // Check and Unset success and error messages before including the view
        $recipe_success = isset($_SESSION['recipe_success']) ? $_SESSION['recipe_success'] : null;
        unset($_SESSION['recipe_success']); 

        $recipe_errors = isset($_SESSION['recipe_errors']) ? $_SESSION['recipe_errors'] : [];
        unset($_SESSION['recipe_errors']); 

        // Include the view and pass the data to it
        include 'template/recipe/modifier_recette.template.php';
    }

    public function handleModifierRecette(int $recette_id)
    {
        session_start();

        // Checking if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: connexion.php");
            exit();
        }

        // Retrieving the recipe information
        $recette = $this->recipeManager->getRecipeById($recette_id);

        // Checking if the recipe was found
        if (!$recette) {
            header("Location: index.php");
            exit();
        }

        // Retrieving the categories
        $categories = $this->categoryManager->getAllCategories();

        // Validating the fields
        $_SESSION['recipe_errors'] = [];

        if (empty($_POST['titre'])) {
            $_SESSION['recipe_errors']['titre'] = "Le titre est obligatoire.";
        }
        if (empty($_POST['description'])) {
            $_SESSION['recipe_errors']['description'] = "La description est obligatoire.";
        }
        if (empty($_POST['ingredients'])) {
            $_SESSION['recipe_errors']['ingredients'] = "Les ingrédients sont obligatoires.";
        }
        if (empty($_POST['instructions'])) {
            $_SESSION['recipe_errors']['instructions'] = "Les instructions sont obligatoires.";
        }
        if (empty($_POST['categorie_id'])) {
            $_SESSION['recipe_errors']['categorie_id'] = "La catégorie est obligatoire.";
        }

        // Managing the image
        $chemin_image = '';
        $imageName = null;

        if ($_FILES['image']['error'] == 0) {
            $nom_image = $_FILES['image']['name'];
            $tmp_image = $_FILES['image']['tmp_name'];
            $chemin_image = "assets/images/" . basename($nom_image);

            // Checking the file type
            $type_image = strtolower(pathinfo($nom_image, PATHINFO_EXTENSION));
            if ($type_image != "jpg" && $type_image != "png" && $type_image != "jpeg" && $type_image != "gif") {
                $_SESSION['recipe_errors']['image'] = "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            }

            // Resize the image
            $newWidth = 1280;
            $newHeight = 850;

            // Get the image dimensions
            list($width, $height) = getimagesize($tmp_image);

            // Create a new temporary image
            $tmp = imagecreatetruecolor($newWidth, $newHeight);

            // Load the image based on its type
            switch ($type_image) {
                case 'jpeg':
                case 'jpg':
                    $source = imagecreatefromjpeg($tmp_image);
                    break;
                case 'png':
                    $source = imagecreatefrompng($tmp_image);
                    imagealphablending($tmp, false);
                    imagesavealpha($tmp, true);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($tmp_image);
                    break;
                default:
                    $_SESSION['recipe_errors']['image'] = "Type de fichier image non supporté.";
                    break;
            }

            // Check if the image was loaded successfully
            if (!isset($_SESSION['recipe_errors']['image'])) {
                // Resize and copy the image
                imagecopyresampled($tmp, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Save the resized image
                switch ($type_image) {
                    case 'jpeg':
                    case 'jpg':
                        imagejpeg($tmp, $tmp_image, 80); 
                        break;
                    case 'png':
                        imagepng($tmp, $tmp_image, 9); 
                        break;
                    case 'gif':
                        imagegif($tmp, $tmp_image);
                        break;
                }

                // Free up memory
                imagedestroy($source);
                imagedestroy($tmp);
            }

            // Moving the file
            if (!isset($_SESSION['recipe_errors']['image'])) {
                if (!move_uploaded_file($tmp_image, $chemin_image)) {
                    $_SESSION['recipe_errors']['image'] = "Erreur lors du téléchargement de l'image.";
                } else {
                    $imageName = basename($nom_image);
                }
            }
        }

        // Update the database if no errors
        if (empty($_SESSION['recipe_errors'])) {
            $titre = $_POST['titre'];
            $categorie_id = $_POST['categorie_id'];
            $description = $_POST['description'];
            $ingredients = $_POST['ingredients'];
            $instructions = $_POST['instructions'];
            $image = isset($imageName) ? $imageName : $recette['image'];

            // Create a Recipe entity
            try {
                $recipe = new Recipe($recette_id, $titre, $categorie_id, $description, $ingredients, $instructions, $image);
            } catch (Exception $e) {
                error_log("Error creating Recipe entity: " . $e->getMessage());
                $_SESSION['recipe_errors']['general'] = "Erreur lors de la modification de la recette.";
                header("Location: modifier_recette.php?id=" . $recette_id);
                exit();
            }

            // Use the RecipeManager to update the recipe
            $result = $this->recipeManager->updateRecipe($recipe);

            if ($result) {
                $_SESSION['recipe_success'] = "Recette modifiée avec succès!";
            } else {
                $_SESSION['recipe_errors']['general'] = "Erreur lors de la modification de la recette.";
            }
        }

        header("Location: modifier_recette.php?id=" . $recette_id);
        exit();
    }

    public function supprimerRecette()
    {
        session_start();

        // Checking if the user is logged in and is an administrator
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: connexion.php");
            exit();
        }

        // Retrieving the recipe ID to delete
        $recette_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // If the ID is not valid, redirect
        if ($recette_id <= 0) {
            header("Location: recetteCategory.php");
            exit();
        }

        // Deleting the recipe
        $result = $this->recipeManager->deleteRecipe($recette_id);

        if ($result) {
            $_SESSION['recipe_success'] = "Recette supprimée avec succès!";
        } else {
            $_SESSION['recipe_errors']['general'] = "Erreur lors de la suppression de la recette.";
        }

        header("Location: recetteCategory.php");
        exit();
    }
}
