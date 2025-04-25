<?php

namespace App\Entity;

class User
{
    private $id;
    private $nom_utilisateur;
    private $email;
    private $mot_de_passe;
    private $role;

    public function __construct($id, $nom_utilisateur, $email, $mot_de_passe, $role)
    {
        $this->id = $id;
        $this->nom_utilisateur = $nom_utilisateur;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->role = $role;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNomUtilisateur()
    {
        return $this->nom_utilisateur;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMotDePasse()
    {
        return $this->mot_de_passe;
    }

    public function getRole()
    {
        return $this->role;
    }
}
