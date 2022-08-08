<?php

class Product
{
    private ?int $id;
    private string $name;

    function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function setName(string $name) : void
    {
        $this->id = $name;
    }
    
}