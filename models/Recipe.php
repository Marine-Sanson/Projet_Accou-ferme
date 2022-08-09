<?php

class Recipe extends News
{
    private ?int $produceId;
    private string $ingredients;
    private string $steps;
    
    function __construct (?int $produceId, string $ingredients, string $steps)
    {
        $this->produceId = $produceId;
        $this->ingredients = $ingredients;
        $this->steps = $steps;
    }
    
    public function getProduceId() : ?int
    {
        return $this->produceId;
    }
    
    public function setProduceId(int $produceId) : void
    {
        $this->produceId = $produceId;
    }
    
    public function getIngredients() : string
    {
        return $this->name;
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