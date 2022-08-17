<?php

class RecipeManager
{
    
    public function createRecipe(Recipe $recipe) : Recipe
    {
        $query = $this->db->prepare('INSERT INTO recipes ( category_id, name, content, product_id, ingredients, steps ) VALUES ( :category_id, :name, :content, :product_id, :ingredients, :steps )');
        $parameters = [
            'category_id' => $categoryId->getCategoryId() ,
            'name' => $name->getName(),
            'content' => $content->getContent,
            'product_id' => $productId->getProductId(),
            'ingredients' => $ingredients->getIngredients(),
            'steps' => $steps->getSteps()
        ];
        $query->execute($parameters);
        
        $recipe = [];

        return $recipe;
    }
    
    public function getRecipeId(string $name) : int
    {
        
        $query = $this->db->prepare('SELECT id FROM recipes WHERE recipe.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $recipe = [];

        return $recipe['id'];
        
    }
    
    public function getRecipeById(Recipe $id) : Recipe
    {
        $query = $this->db->prepare('SELECT category_id, name, media_id, content, product_id, ingredients, steps FROM recipes WHERE recipe.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $recipe = [];

        return $recipe;
    }
    
    public function updateRecipe(Recipe $recipe) : Recipe
    {
        $query = $this->db->prepare('UPDATE recipe SET category_id = :category_id, name = :name, content = :content, product_id = :product_id, ingredients = :ingredients, steps = :steps FROM recipes WHERE recipe.name = :name');
        $parameters = [
            'category_id' => $categoryId,
            'name' => $name,
            'content' => $content,
            'product_id' => $productId,
            'ingredients' => $ingredients,
            'steps' => $steps
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $recipe = [];

        return $recipe;
        
    }
    
    public function deleteRecipe(Recipe $recipe) : void
    {
        
        $query = $this->db->prepare('DELETE id, category_id, name, media_id, content, product_id, ingredients, steps FROM varieties WHERE recipe.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>