<?php

namespace App\Manager;

class CategoryManager
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getWelcomeSections()
    {
        $query = "SELECT * FROM categories WHERE section_class = 'welcome'";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMainCategories()
    {
        $query = "SELECT * FROM categories WHERE id IN (1, 2, 3)";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllCategories()
    {
        $query = "SELECT id, nom FROM categories ORDER BY nom";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $category_id
     * @return string
     */
    public function getCategoryName(int $category_id): string
    {
        $query = "SELECT nom FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $category_id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ($result) ? $result['nom'] : 'Toutes les recettes';
    }
}
