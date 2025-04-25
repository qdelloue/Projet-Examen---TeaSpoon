<?php

namespace App\Manager;

class FavoriteManager
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param int|null $user_id
     * @param int $recette_id
     * @return bool
     */
    public function isRecipeFavorite(int $user_id = null, int $recette_id): bool
    {
        if ($user_id) {
            $check_favorite = $this->db->prepare("SELECT * FROM favoris WHERE user_id = ? AND recette_id = ?");
            $check_favorite->bindValue(1, $user_id, \PDO::PARAM_INT);
            $check_favorite->bindValue(2, $recette_id, \PDO::PARAM_INT);
            $check_favorite->execute();
            return $check_favorite->rowCount() > 0;
        }
        return false;
    }

    /**
     * @param int $user_id
     * @return array
     */
    public function getFavoriteRecipes(int $user_id): array
    {
        $query = "SELECT r.id, r.titre, r.description, r.image 
                  FROM recettes r
                  JOIN favoris f ON r.id = f.recette_id
                  WHERE f.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $user_id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $user_id
     * @param int $recette_id
     * @return void
     */
    public function addFavorite(int $user_id, int $recette_id): void
    {
        $add_favorite = $this->db->prepare("INSERT INTO favoris (user_id, recette_id) VALUES (?, ?)");
        $add_favorite->bindValue(1, $user_id, \PDO::PARAM_INT);
        $add_favorite->bindValue(2, $recette_id, \PDO::PARAM_INT);
        $add_favorite->execute();
    }

    /**
     * @param int $user_id
     * @param int $recette_id
     * @return void
     */
    public function removeFavorite(int $user_id, int $recette_id): void
    {
        $delete_favorite = $this->db->prepare("DELETE FROM favoris WHERE user_id = ? AND recette_id = ?");
        $delete_favorite->bindValue(1, $user_id, \PDO::PARAM_INT);
        $delete_favorite->bindValue(2, $recette_id, \PDO::PARAM_INT);
        $delete_favorite->execute();
    }
}
