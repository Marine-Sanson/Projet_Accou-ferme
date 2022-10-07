<?php

class Recipe extends News
{
    private ?int $recipeId;
    private ?int $newsId;
    private ?int $productId;
    private string $ingredients;
    private string $steps;
    
    function __construct (?int $recipeId, ?int $newsId, ?int $productId, string $ingredients, string $steps)
    {
        $this->recipeId = $recipeId;
        $this->newsId = $newsId;
        $this->productId = $productId;
        $this->ingredients = $ingredients;
        $this->steps = $steps;
    }
    
    public function getRecipeId() : ?int
    {
        return $this->recipeId;
    }
    
    public function setRecipeId(?int $recipeId) : void
    {
        $this->recipeId = $recipeId;
    }
    
    public function getNewsId() : ?int
    {
        return $this->newsId;
    }
    
    public function setNewsId(int $newsId) : void
    {
        $this->newsId = $newsId;
    }
    
    public function getProductId() : ?int
    {
        return $this->productId;
    }
    
    public function setProductId(int $productId) : void
    {
        $this->productId = $productId;
    }
    
    public function getIngredients() : string
    {
        return $this->ingredients;
    }
    
    public function setIngredients(string $ingredients) : void
    {
        $this->ingredients = $ingredients;
    }
    
    public function getSteps() : string
    {
        return $this->steps;
    }
    
    public function setSteps(string $steps) : void
    {
        $this->steps = $steps;
    }
    
}

?>