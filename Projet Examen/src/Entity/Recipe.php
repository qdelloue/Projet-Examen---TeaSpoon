<?php

namespace App\Entity;

class Recipe
{
    private $id;
    private $titre;
    private $categorie_id;
    private $description;
    private $ingredients;
    private $instructions;
    private $image;

    public function __construct(int $id, string $titre, int $categorie_id, string $description, string $ingredients, string $instructions, string $image)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->categorie_id = $categorie_id;
        $this->description = $description;
        $this->ingredients = $ingredients;
        $this->instructions = $instructions;
        $this->image = $image;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getCategorieId(): int
    {
        return $this->categorie_id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    public function getInstructions(): string
    {
        return $this->instructions;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
