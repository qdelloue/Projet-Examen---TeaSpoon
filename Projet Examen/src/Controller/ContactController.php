<?php

namespace App\Controller;

use App\Manager\ContactManager;

class ContactController
{
    private $contactManager;

    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }

    public function index()
    {
        // Initializing variables
        $errors = [];
        $formSubmitted = false;
        $success = null;

        // Checking if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $formSubmitted = true;

            // Retrieving and sanitizing form data
            $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
            $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
            $email = trim(htmlspecialchars($_POST['email'] ?? ''));
            $objet = trim(htmlspecialchars($_POST['objet'] ?? ''));
            $message = trim(htmlspecialchars($_POST['message'] ?? ''));

            // Validating fields
            if (empty($nom)) {
                $errors['nom'] = "Le nom est requis.";
            }
            if (empty($prenom)) {
                $errors['prenom'] = "Le prénom est requis.";
            }
            if (empty($email)) {
                $errors['email'] = "L'email est requis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "L'email n'est pas valide.";
            }
            if (empty($objet)) {
                $errors['objet'] = "L'objet est requis.";
            }
            if (empty($message)) {
                $errors['message'] = "Le message est requis.";
            }

            // Sending the message if no errors
            if (empty($errors)) {
                $data = [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'objet' => $objet,
                    'message' => $message
                ];
                
                // Creating the contact via the ContactManager
                if ($this->contactManager->createContact($data)) {
                    $success = "Votre message a été envoyé avec succès !";
                } else {
                    $errors['db'] = "Erreur lors de l'envoi du message.";
                }
            }
        }

        // Include the view and pass the data to it
        include 'template/contact/contact.template.php';
    }
}
