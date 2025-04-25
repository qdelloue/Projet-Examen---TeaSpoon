<?php

namespace App\Manager;

class ContactManager
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function createContact(array $data): bool
    {
        $sql = "INSERT INTO contacts (nom, prenom, email, objet, message) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $data['nom'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $data['prenom'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $data['email'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $data['objet'], \PDO::PARAM_STR);
        $stmt->bindValue(5, $data['message'], \PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * @param int $message_id
     * @return bool
     */
    public function deleteMessage(int $message_id): bool
    {
        $query = "DELETE FROM contacts WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $message_id, \PDO::PARAM_INT);
        return $stmt->execute();
    }    

    public function getAllMessages()
    {
        $query = "SELECT id, nom, email, objet, message FROM contacts";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
