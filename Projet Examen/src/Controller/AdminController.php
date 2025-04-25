<?php

namespace App\Controller;

use App\Manager\RecipeManager;
use App\Manager\UserManager;
use App\Manager\ContactManager;

class AdminController
{
    private $recipeManager;
    private $userManager;
    private $contactManager;

    public function __construct(RecipeManager $recipeManager, UserManager $userManager, ContactManager $contactManager)
    {
        $this->recipeManager = $recipeManager;
        $this->userManager = $userManager;
        $this->contactManager = $contactManager;
    }

    public function index()
    {
        // Starting the session
        session_start();

        // Checking if the user is logged in and is an administrator
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: adminconnect.php");
            exit();
        }

        // Including the admin dashboard template
        $adminController = $this;
        include 'template/admin/tableau-de-bord-admin.template.php';
    }

    public function getAllRecipes()
    {
        // Retrieving all recipes via the RecipeManager
        return $this->recipeManager->getAllRecipes();
    }

    public function getAllUsers()
    {
        // Retrieving all users via the UserManager
        return $this->userManager->getAllUsers();
    }

    public function getAllMessages()
    {
        // Retrieving all messages via the ContactManager
        return $this->contactManager->getAllMessages();
    }

    public function modifierUtilisateur()
    {
        // Checking for the presence of the user ID in the GET request
        if (!isset($_GET['id'])) {
            header('Location: tableau-de-bord-admin.php?action=users');
            exit;
        }

        $userId = $_GET['id'];
        $user = $this->userManager->getUserById($userId);

        // Checking if the user was found
        if (!$user) {
            header('Location: tableau-de-bord-admin.php?action=users&error=user_not_found');
            exit;
        }

        // Handling the modification form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'];

            // Validate the role
            if ($role !== 'user' && $role !== 'admin') {
                $user_errors = ['Rôle invalide.'];
            } else {
                $result = $this->userManager->updateUserRole($userId, $role);

                // Redirecting on success or displaying an error
                if ($result === true) {
                    header('Location: tableau-de-bord-admin.php?action=users&success=1');
                    exit;
                } else {
                    $user_errors = [$result];
                }
            }
        }

        // Preparing user data for the view
        $userData = [
            'id' => $user->getId(),
            'nom_utilisateur' => $user->getNomUtilisateur(),
            'email' => $user->getEmail(),
            'role' => $user->getRole()
        ];

        // Include the view and pass the data to it
        include 'template/admin/modifier_utilisateur.template.php';
    }

    public function supprimerUtilisateur()
    {
        // Checking for the presence of the user ID in the GET request
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $result = $this->userManager->deleteUser($userId);
            // Redirecting on success or displaying an error
            if ($result) {
                header('Location: tableau-de-bord-admin.php?action=users&success=1');
            } else {
                header('Location: tableau-de-bord-admin.php?action=users&error=1');
            }
            exit;
        } else {
            // Redirecting to the user list if the ID is missing
            header('Location: tableau-de-bord-admin.php?action=users');
            exit;
        }
    }

    public function supprimerMessage()
    {
        // Checking for the presence of the message ID in the GET request
        if (isset($_GET['id'])) {
            $messageId = $_GET['id'];
            $result = $this->contactManager->deleteMessage($messageId);
            // Redirecting on success or displaying an error
            if ($result) {
                header('Location: tableau-de-bord-admin.php?action=messages&success=1');
            } else {
                header('Location: tableau-de-bord-admin.php?action=messages&error=1');
            }
            exit;
        } else {
            // Redirecting to the message list if the ID is missing
            header('Location: tableau-de-bord-admin.php?action=messages');
            exit;
        }
    }

}
