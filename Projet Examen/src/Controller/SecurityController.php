<?php

namespace App\Controller;

use App\Manager\UserManager;

class SecurityController
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function connexion()
    {
        session_start();
        $form_to_show = $_SESSION['form_to_show'] ?? 'default';
        unset($_SESSION['form_to_show']); 

        include 'template/security/connexion.template.php';
    }

    public function authenticate()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $_SESSION['form_to_show'] = $action; 

            if ($action === 'login') {
                $email = trim($_POST['email'] ?? '');
                $password = trim($_POST['password'] ?? '');

                $_SESSION['login_errors'] = [];

                // Checking if the fields are empty
                if (empty($email) || empty($password)) {
                    $_SESSION['login_errors']['password'] = "Email ou mot de passe incorrect.";
                } else {
                    // Checking the credentials (email and password)
                    $user = $this->userManager->getUserByEmail($email);

                    if ($user) {
                        if (!password_verify($password, $user->getMotDePasse())) {
                            $_SESSION['login_errors']['password'] = "Email ou mot de passe incorrect.";
                        } else {
                            // Successful login
                            $_SESSION['user_id'] = $user->getId();
                            $_SESSION['user_role'] = $user->getRole(); 
                            header("Location: dashboard.php");
                            exit();
                        }
                    } else {
                        $_SESSION['login_errors']['password'] = "Email ou mot de passe incorrect.";
                    }
                }
            } elseif ($action === 'register') {
                $username = trim($_POST['username'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = trim($_POST['password'] ?? '');

                $_SESSION['register_errors'] = [];

                // Validating the fields
                if (empty($username)) {
                    $_SESSION['register_errors']['username'] = "Le nom d'utilisateur est obligatoire.";
                }
                if (empty($email)) {
                    $_SESSION['register_errors']['email'] = "L'email est obligatoire.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['register_errors']['email'] = "L'adresse email n'est pas valide.";
                }
                if (empty($password)) {
                    $_SESSION['register_errors']['password'] = "Le mot de passe est obligatoire.";
                } elseif (strlen($password) < 8) {
                    $_SESSION['register_errors']['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
                }

                if (empty($_SESSION['register_errors'])) {
                    // Checking if the email already exists
                    $existingUser = $this->userManager->getUserByEmail($email);
                    if ($existingUser) {
                        $_SESSION['register_errors']['email'] = "Cet email est déjà utilisé.";
                    } else {
                        // Inserting the new user
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $result = $this->userManager->createUser($username, $email, $hashed_password);
                        if ($result) {
                            $_SESSION['register_success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                            $_SESSION['form_to_show'] = 'login'; 
                        } else {
                            $_SESSION['register_errors']['general'] = "Erreur lors de l'inscription.";
                        }
                    }
                }
            }

            header("Location: connexion.php");
            exit();
        } else {
            header("Location: connexion.php");
            exit();
        }
    }

    public function adminConnect()
    {
        session_start();

        // Check if the admin is already logged in
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            header("Location: tableau-de-bord-admin.php"); 
            exit();
        }

        // Set a flag to indicate the admin is logging in from this page
        $_SESSION['admin_login'] = true;

        include 'template/security/adminconnect.template.php';
    }

    

}
