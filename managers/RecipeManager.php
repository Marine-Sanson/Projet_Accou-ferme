<?php

class RecipeManager extends AbstractManager
{
    
    /**
     * reçoit une Recipe et la crée dans la base de données
     * @param Recipe
     * @return
     */
    
    public function createRecipe(Recipe $recipe) : void
    {
        $query = $this->db->prepare('INSERT INTO recipes ( news_id, product_id, ingredients, steps )
        VALUES ( :news_id, :product_id, :ingredients, :steps )');
        $parameters = [
            'news_id' => $recipe->getNewsId(),
            'product_id' => $recipe->getProductId(),
            'ingredients' => $recipe->getIngredients(),
            'steps' => $recipe->getSteps()
        ];
        $query->execute($parameters);
    }
    
    /**
     * va chercher l'id d'une Recipe d'après son nom
     * @param $name
     * @return id
     */
    
    public function getRecipeId(string $name) : int
    {
        $query = $this->db->prepare('SELECT recipe_id FROM recipes WHERE recipes.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $recipe = [];

        return $recipe['id'];
    }
    
    /**
     * va chercher tous les newsid des Recipe
     * @param 
     * @return un array avec les id
     */

    public function getAllNewsIds() : array
    {
        $query = $this->db->prepare('SELECT news_id FROM recipes');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    /**
     * va chercher une Recipe d'après une News
     * @param News
     * @return Recipe
     */
    
    public function getRecipeByNews(News $newsDetail) : Recipe
    {
        $query = $this->db->prepare('SELECT recipe_id, product_id, ingredients, steps
        FROM recipes
        WHERE news_id = :news_id');
        $parameters = [
            'news_id' => $newsDetail->getId()
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $newsId = $newsDetail->getId();
        $categoryId = $newsDetail->getCategoryId();
        $name = $newsDetail->getName();
        $mediaId = $newsDetail->getMediaId();
        $content = $newsDetail->getContent();
        $recipeId = $result["0"]["recipe_id"];
        $productId = $result["0"]["product_id"];
        $ingredients = $result["0"]["ingredients"];
        $steps = $result["0"]["steps"];

        $recipe = new Recipe($recipeId, $newsId, $productId, $ingredients, $steps);
        $recipe->setId($newsId);
        $recipe->setCategoryId($categoryId);
        $recipe->setName($name);
        $recipe->setMediaId($mediaId);
        $recipe->setContent($content);
        
        return $recipe;
    }
    
    /**
     * va chercher l'id d'une News d'après l'id de la Recipe
     * @param News
     * @return Recipe
     */
    
    public function getNewsId(int $id) : int
    {
        $query = $this->db->prepare('SELECT news_id FROM recipes WHERE recipe.recipe_id = :recipe_id');
        $parameters = [
            'recipe_id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $recipe = [];

        return $recipe['recipe_id'];
    }

    /**
     * met à jour une Recipe
     * @param Recipe
     * @return 
     */

    public function updateRecipe(Recipe $recipe) : void
    {
        $query = $this->db->prepare('UPDATE recipes
        SET product_id = :product_id, ingredients = :ingredients, steps = :steps
        WHERE recipe_id = :recipe_id');
        $parameters = [
            'recipe_id' => $recipe->getRecipeId(),
            'product_id' => $recipe->getProductId(),
            'ingredients' => $recipe->getIngredients(),
            'steps' => $recipe->getSteps()
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * supprime une Recipe
     * @param Recipe
     * @return 
     */

    
    public function deleteRecipe(Recipe $recipe) : void
    {
        $query = $this->db->prepare('DELETE FROM recipes WHERE recipe_id = :recipe_id');
        $parameters = [
            'recipe_id' => $recipe->getRecipeId()
        ];
        $query->execute($parameters);
    }
}

?>