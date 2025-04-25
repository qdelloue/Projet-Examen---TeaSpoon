<?php

namespace App\Controller;

use App\Manager\UserManager;
use App\Manager\CategoryManager;

class DashboardController
{
    private $userManager;
    private $categoryManager;

    public function __construct(UserManager $userManager, CategoryManager $categoryManager)
    {
        $this->userManager = $userManager;
        $this->categoryManager = $categoryManager;
    }

    public function index()
    {
        // Checking if the user is connected
        if (!isset($_SESSION['user_id'])) {
            header("Location: connexion.php");
            exit();
        }

        // Retrieving user information
        $user_id = $_SESSION['user_id'];
        $user = $this->userManager->getUserById($user_id);

        // Checking if the user was found
        if (!$user) {
            session_destroy();
            header("Location: connexion.php?error=user_not_found");
            exit();
        }
                
        // Categories Header
        $categoriesHeader = $this->categoryManager->getAllCategories();

        // Managing user actions
        $action = $_GET['action'] ?? 'account'; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update'])) {
                // Updating user data
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $new_password = trim($_POST['new_password']);

                $result = $this->userManager->updateUser($user_id, $username, $email, $new_password);

                if ($result === true) {
                    $_SESSION['success_message'] = "Vos informations ont été mises à jour avec succès.";

                    // Reload user information after update
                    $user = $this->userManager->getUserById($user_id);

                    header("Location: dashboard.php?action=account");
                    exit();
                } else {
                    $_SESSION['error_message'] = $result; 
                }
            } elseif (isset($_POST['delete'])) {
                // Deleting user account
                $result = $this->userManager->deleteUser($user_id);
                if ($result) {
                    session_destroy();
                    header("Location: connexion.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression du compte.";
                }
            }
        }

        // Logging out
        if (isset($_GET['logout'])) {
            session_destroy();
            header("Location: connexion.php");
            exit();
        }

        // Displaying the hashed password as stars
        $password_stars = str_repeat('*', 20); 

        // Include the view and pass the data to it
        include 'template/dashboard/dashboard.template.php';
    }
}
