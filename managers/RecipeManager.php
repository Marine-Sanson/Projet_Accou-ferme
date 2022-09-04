<?php

class RecipeManager extends DBConnect
{
    
    public function createRecipe(Recipe $recipe) : Recipe
    {
        $query = $this->db->prepare('INSERT INTO recipes ( news_id, category_id, name, content, product_id, ingredients, steps ) VALUES ( :news_id, :category_id, :name, :content, :product_id, :ingredients, :steps )');
        $parameters = [
            'news_id' => $newsId->getNewsId,
            'category_id' => $categoryId->getCategoryId(),
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
        $query = $this->db->prepare('SELECT news_id, category_id, name, media_id, content, product_id, ingredients, steps FROM recipes WHERE recipe.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $recipe = [];

        return $recipe;
    }
    
    public function getNewsId(int $id) : int
    {
        
        $query = $this->db->prepare('SELECT news_id FROM recipes WHERE recipe.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $recipe = [];

        return $recipe['id'];
    }

    public function getRecipeByNewsId(int $newsId) : Recipe
    {
        $query = $this->db->prepare('SELECT id, category_id, name, media_id, content, product_id, ingredients, steps FROM recipes WHERE recipe.news_id = :news_id');
        $parameters = [
            'newsid' => $newsId
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $recipe = [];

        return $recipe;
    }

    
    public function updateRecipe(Recipe $recipe) : Recipe
    {
        $query = $this->db->prepare('UPDATE recipe SET news_id = :news_id, category_id = :category_id, name = :name, content = :content, product_id = :product_id, ingredients = :ingredients, steps = :steps FROM recipes WHERE recipe.name = :name');
        $parameters = [
            'news_id' => $newsId,
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
        
        $query = $this->db->prepare('DELETE id, news_id, category_id, name, media_id, content, product_id, ingredients, steps FROM varieties WHERE recipe.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>