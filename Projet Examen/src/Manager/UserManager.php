<?php

namespace App\Manager;

use App\Entity\User;

class UserManager
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        $query = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $email, \PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                $data['id'],
                $data['nom_utilisateur'],
                $data['email'],
                $data['mot_de_passe'],
                $data['role']
            );
        }

        return null;
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $hashed_password
     * @return bool
     */
    public function createUser(string $username, string $email, string $hashed_password): bool
    {
        $query = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, role) VALUES (?, ?, ?, 'user')";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $username, \PDO::PARAM_STR);
        $stmt->bindValue(2, $email, \PDO::PARAM_STR);
        $stmt->bindValue(3, $hashed_password, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * @param int $user_id
     * @return User|null
     */
    public function getUserById(int $user_id): ?User
    {
        $query = "SELECT * FROM utilisateurs WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $user_id, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                $data['id'],
                $data['nom_utilisateur'],
                $data['email'],
                $data['mot_de_passe'],
                $data['role']
            );
        }

        return null;
    }

    /**
     * @param int $user_id
     * @param string $username
     * @param string $email
     * @param string|null $new_password
     * @return string|bool
     */
    public function updateUser(int $user_id, string $username, string $email, string $new_password = null)
    {
        // Validating the fields
        if (empty($username)) {
            return "Le nom d'utilisateur est obligatoire.";
        }
        if (empty($email)) {
            return "L'email est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "L'adresse email n'est pas valide.";
        }

        $update_fields = "nom_utilisateur = ?, email = ?";
        $update_params = [$username, $email];

        if (!empty($new_password)) {
            if (strlen($new_password) < 8) {
                return "Le nouveau mot de passe doit contenir au moins 8 caractères.";
            }
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_fields .= ", mot_de_passe = ?";
            $update_params[] = $hashed_password;
        }

        $update_sql = "UPDATE utilisateurs SET " . $update_fields . " WHERE id = ?";
        $stmt = $this->db->prepare($update_sql);

        $stmt->bindValue(1, $username, \PDO::PARAM_STR);
        $stmt->bindValue(2, $email, \PDO::PARAM_STR);
        if (!empty($new_password)) {
            $stmt->bindValue(3, $hashed_password, \PDO::PARAM_STR);
            $stmt->bindValue(4, $user_id, \PDO::PARAM_INT);
        } else {
            $stmt->bindValue(3, $user_id, \PDO::PARAM_INT);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return "Erreur lors de la mise à jour des informations.";
        }
    }

    /**
     * @param int $user_id
     * @param string $role
     * @return string|bool
     */
    public function updateUserRole(int $user_id, string $role)
    {
        if (empty($role)) {
            return "Le rôle est obligatoire.";
        }

        $sql = "UPDATE utilisateurs SET role = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $role, \PDO::PARAM_STR);
        $stmt->bindValue(2, $user_id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Erreur lors de la mise à jour du rôle.";
        }
    }

    /**
     * @param int $user_id
     * @return bool
     */
    public function deleteUser(int $user_id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM utilisateurs WHERE id = ?");
        $stmt->bindValue(1, $user_id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllUsers()
    {
        $query = "SELECT id, nom_utilisateur, email, role FROM utilisateurs";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
