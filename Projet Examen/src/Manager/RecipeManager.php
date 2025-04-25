<?php

namespace App\Manager;

use App\Entity\Recipe;
use PDO;

class RecipeManager
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $category_id
     * @return array
     */
    public function getRecipesByCategory(int $category_id): array
    {
        if ($category_id === 0) {
            $query = "SELECT r.id, r.titre, r.description, r.image 
                      FROM recettes r";
            $stmt = $this->db->prepare($query);
        } else {
            $query = "SELECT r.id, r.titre, r.description, r.image 
                      FROM recettes r
                      WHERE r.categorie_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(1, $category_id, \PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getRandomRecipes(int $limit): array
    {
        $query = "SELECT r.id, r.titre, r.description, r.image, r.categorie_id, c.nom AS categorie_nom 
            FROM recettes r
            JOIN categories c ON r.categorie_id = c.id
            ORDER BY RAND() 
            LIMIT :limit";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    /**
     * @param int $recette_id
     * @return array
     */
    public function getRecipeById(int $recette_id): array
    {
        $query = "SELECT r.id, r.titre, r.description, r.image, r.ingredients, r.instructions, r.categorie_id, c.nom AS categorie_nom 
                  FROM recettes r
                  JOIN categories c ON r.categorie_id = c.id
                  WHERE r.id = :id";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $recette_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result;
    }
    
    /**
     * @param Recipe $recipe
     * @return bool
     */
    public function createRecipe(Recipe $recipe): bool
    {
        $query = "INSERT INTO recettes (titre, categorie_id, description, ingredients, instructions, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $recipe->getTitre(), PDO::PARAM_STR);
        $stmt->bindValue(2, $recipe->getCategorieId(), PDO::PARAM_INT);
        $stmt->bindValue(3, $recipe->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(4, $recipe->getIngredients(), PDO::PARAM_STR);
        $stmt->bindValue(5, $recipe->getInstructions(), PDO::PARAM_STR);
        $stmt->bindValue(6, $recipe->getImage(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * @param Recipe $recipe
     * @return bool
     */
    public function updateRecipe(Recipe $recipe): bool
    {
        $query = "UPDATE recettes SET titre = ?, categorie_id = ?, description = ?, ingredients = ?, instructions = ?, image = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $recipe->getTitre(), PDO::PARAM_STR);
        $stmt->bindValue(2, $recipe->getCategorieId(), PDO::PARAM_INT);
        $stmt->bindValue(3, $recipe->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(4, $recipe->getIngredients(), PDO::PARAM_STR);
        $stmt->bindValue(5, $recipe->getInstructions(), PDO::PARAM_STR);
        $stmt->bindValue(6, $recipe->getImage(), PDO::PARAM_STR);
        $stmt->bindValue(7, $recipe->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * @param int $recette_id
     * @return bool
     */
    public function deleteRecipe(int $recette_id): bool
    {
        $query = "DELETE FROM favoris WHERE recette_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $recette_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $query = "DELETE FROM recettes WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $recette_id, PDO::PARAM_INT);
        return $stmt->execute();
    }      

    public function getAllRecipes()
    {
        $query = "SELECT id, titre FROM recettes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
}
